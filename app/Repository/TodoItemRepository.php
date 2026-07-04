<?php
declare(strict_types=1);

namespace App\Repository;

use App\Contracts\Repository\TodoItemRepositoryInterface;
use App\Models\TodoItem;

class TodoItemRepository implements TodoItemRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function getItems(): array
    {
        return TodoItem::all()->toArray();
    }

    public function getItem(int $id): TodoItem
    {
        return TodoItem::findOrFail($id);
    }

    public function create(string $title, bool $completed): TodoItem
    {
        return TodoItem::create([
            'title' => $title,
            'completed' => $completed,
        ]);
    }
}
