<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $title
 * @property bool $completed
 */
#[Table(name: 'todo_items')]
class TodoItemModel extends Model
{
    protected $fillable = [
        'title',
        'completed',
    ];

    protected $casts = [
        'completed' => 'boolean',
    ];
}
