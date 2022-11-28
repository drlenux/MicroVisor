<?php

namespace app\config;

final class Config
{
    private array $services = [];
    private float $timeout;

    public function __construct(array $config)
    {
        $this->timeout = $config['timeout'] ?? 0.1;

        foreach ($config['services'] ?? [] as $name => $conf) {
            $this->services[$name] = new Service($name, $conf);
        }
    }

    public function get(string $name): ?Service
    {
        return $this->services[$name] ?? null;
    }

    public function getTimeout(): float
    {
        return $this->timeout;
    }

    public function getServices(): array
    {
        return $this->services;
    }
}
