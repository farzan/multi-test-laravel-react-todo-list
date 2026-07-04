<?php
declare(strict_types=1);

namespace App\Contracts\Repository;

use App\Models\TodoItem;

interface TodoItemRepositoryInterface
{
    /**
     * @return List<TodoItem>
     */
    public function getItems(): array;

    public function getItem(int $id): TodoItem;

    public function create(string $title, bool $completed): TodoItem;
}
