<?php
declare(strict_types=1);

namespace App\Repository;

use App\Domain\Contracts\Repository\TodoItemRepositoryInterface;
use App\Domain\Dto\TodoItem;
use App\Models\TodoItemModel;

class TodoItemRepository implements TodoItemRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function getItems(): array
    {
        return TodoItemModel::all()
            ->map(fn (TodoItemModel $item) => $this->getTodoItem($item))
            ->toArray();
    }

    public function getItem(int $id): TodoItem
    {
        $item = TodoItemModel::findOrFail($id);

        return $this->getTodoItem($item);
    }

    public function create(string $title, bool $completed): TodoItem
    {
        $item = TodoItemModel::create([
            'title' => $title,
            'completed' => $completed,
        ]);

        return $this->getTodoItem($item);
    }

    private function getTodoItem(TodoItemModel $item): TodoItem
    {
        return new TodoItem(
            $item->id,
            $item->title,
            $item->completed,
        );
    }
}
