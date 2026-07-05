<?php
declare(strict_types=1);

namespace App\Domain\Service;

use App\Domain\Contracts\Repository\TodoItemRepositoryInterface;
use App\Domain\Dto\TodoItem;

class TodoService
{
    public function __construct(
        private TodoItemRepositoryInterface $repo,
    ) {}

    /**
     * @return List<TodoItem>
     */
    public function getItems(): array
    {
        return $this->repo->getItems();
    }

    public function getItem(int $id): TodoItem
    {
        return $this->repo->getItem($id);
    }
}
