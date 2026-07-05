<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Domain\Dto\TodoItem;
use App\Domain\Service\TodoService;
use App\Http\Controllers\Controller;

class TodoController extends Controller
{
    public function __construct(
        private readonly TodoService $todoService,
    ) {}

    public function list(): array {
        return $this->presentItems($this->todoService->getItems());
    }

    /**
     * @param List<TodoItem> $items
     */
    private function presentItems(array $items): array
    {
        $formattedItems = array_map(
            fn (TodoItem $item) => [
                'id' => $item->id,
                'title' => $item->title,
                'completed' => $item->completed,
            ],
            $this->todoService->getItems(),
        );

        return ['items' => $formattedItems];
    }
}
