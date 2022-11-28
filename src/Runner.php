<?php

namespace app;

use app\config\Config;
use app\config\Service;
use Psr\Log\LoggerInterface;
use Spatie\Async\Pool;

class Runner
{
    private Pool $pool;
    private array $info = [];

    public function __construct(
        private Config $config,
        private ?LoggerInterface $logger
    )
    {
        $this->pool = Pool::create()
            ->timeout($this->config->getTimeout());
    }

    public function run(Service $service): void
    {
        if (!$this->validate($service)) return;
        foreach (range(1, $service->getThread()) as $pid) {
            $this->info[$service->getName()]['items'][$pid]['start'] = time();
            $this->info[$service->getName()]['count'] = $this->info[$service->getName()]['count'] ?? 0;
            $this->info[$service->getName()]['count']++;
            $this->logger?->info('run', [
                'info' => $this->info[$service->getName()],
                'name' => $service->getName(),
                'pid' => $pid
            ]);

            $this->pool[] = async(function () use ($service) {
                $output = shell_exec($service->getCmd());
                return ['service' => $service, 'out' => $output];
            })->then(function (array $out) use ($pid) {
                /** @var Service $service */
                $service = $out['service'];
                $this->logger->info('shell-output', ['out' => $out['out']]);
                $this->info[$service->getName()]['count']--;
                $this->info[$service->getName()][$pid]['stop'] = time();
            });
        }
    }

    private function validate(Service $service): bool
    {
        $status = ($this->info[$service->getName()]['count'] ?? 0) < $service->getThread();
        $this->logger->info('validate', [
            'name' => $service->getName(),
            'status' => $status,
        ]);
        return $status;
    }

    /**
     * @return array
     */
    public function getInfo(): array
    {
        return $this->info;
    }
}