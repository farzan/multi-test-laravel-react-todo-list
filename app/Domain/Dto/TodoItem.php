<?php
declare(strict_types=1);

namespace App\Domain\Dto;

readonly class TodoItem
{
    public function __construct(
        public int $id,
        public string $title,
        public bool $completed,
    ) {}
}
