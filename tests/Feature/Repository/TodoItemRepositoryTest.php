<?php
declare(strict_types=1);

namespace Tests\Feature\Repository;

use App\Repository\TodoItemRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TodoItemRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_todo_item(): void
    {
        $repo = new TodoItemRepository();

        $todoItem = $repo->create('Test todo item', false);

        $this->assertSame('Test todo item', $todoItem->title);
        $this->assertFalse($todoItem->completed);

        $this->assertDatabaseCount('todo_items', 1);
        $this->assertDatabaseHas('todo_items', [
            'title' => 'Test todo item',
            'completed' => false,
        ]);
    }

    // @todo Add the rest of tests
}
