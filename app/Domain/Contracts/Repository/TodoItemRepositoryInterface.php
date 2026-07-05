<?php
declare(strict_types=1);

namespace App\Domain\Contracts\Repository;

use App\Domain\Dto\TodoItem;

interface TodoItemRepositoryInterface
{
    /**
     * @return List<TodoItem>
     */
    public function getItems(): array;

    public function getItem(int $id): TodoItem;

    public function create(string $title, bool $completed): TodoItem;
}
