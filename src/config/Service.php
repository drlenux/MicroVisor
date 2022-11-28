<?php

namespace app\config;

final class Service
{
    private string $name;
    private float $timeout;
    private string $cmd;
    private int $thread;

    public function __construct(string $name, array $config)
    {
        $this->name = $name;
        $this->thread = $config['thread'] ?? 1;
        $this->cmd = $config['cmd'];
        $this->timeout = $config['timeout'] ?? 1;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getTimeout(): float
    {
        return $this->timeout;
    }

    public function getCmd(): string
    {
        return $this->cmd;
    }

    public function getThread(): int
    {
        return $this->thread;
    }
}
