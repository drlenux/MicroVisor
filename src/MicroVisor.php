<?php

namespace app;

use app\config\Config;
use Psr\Log\LoggerInterface;

class MicroVisor
{
    private Runner $runner;

    public function __construct(
        private Config $config,
        private ?LoggerInterface $logger = null,
    )
    {
        $this->runner = new Runner($this->config, $this->logger);
    }

    public function exec(): void
    {
        foreach ($this->config->getServices() as $name => $service) {
            $this->logger?->info('exec', ['name' => $name]);
            $this->runner->run($service);
        }
    }

    public function getRunner(): Runner
    {
        return $this->runner;
    }
}