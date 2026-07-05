<?php
declare(strict_types=1);

namespace Tests\Unit\Domain\Service;

use App\Domain\Contracts\Repository\TodoItemRepositoryInterface;
use App\Domain\Service\TodoService;
use App\Models\TodoItemModel;
use Tests\TestCase;

class TodoServiceTest extends TestCase
{
    public function test_get_items(): void
    {
        $repo = $this->createMock(TodoItemRepositoryInterface::class);
        $repo->expects($this->once())
            ->method('getItems')
            ->willReturn([
                TodoItemModel::make(['title' => 'Item 1', 'completed' => false]),
                TodoItemModel::make(['title' => 'Item 2', 'completed' => true]),
            ]);

        $service = new TodoService($repo);

        $items = $service->getItems();
        $this->assertCount(2, $items);
        $this->assertInstanceOf(TodoItemModel::class, $items[0]);
        $this->assertInstanceOf(TodoItemModel::class, $items[1]);
        $this->assertEquals('Item 1', $items[0]->title);
        $this->assertEquals('Item 2', $items[1]->title);
        $this->assertEquals(false, $items[0]->completed);
        $this->assertEquals(true, $items[1]->completed);
    }
}
