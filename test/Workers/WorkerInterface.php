<?php

namespace Workers;

interface WorkerInterface
{
    public function handle(array $params): void;
}