<?php
declare(strict_types=1);

namespace App\Service;

use App\Contracts\Repository\TodoItemRepositoryInterface;
use App\Models\TodoItem;

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
}
