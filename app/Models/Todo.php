<?php

namespace App\Models;

use App\Models\UserTodo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

class Todo extends Model {
    use HasFactory, SoftDeletes;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'title',
        'description',
        'status',
        'priority',
        'due_date',
        'completed_at',
        'comments',
    ];

    protected static function boot() {
        parent::boot();

        static::creating( function ( $model ) {
            if ( empty( $model->id ) ) {
                $model->id = Uuid::uuid4()->toString();
            }
        } );
    }

    protected $dates = ['deleted_at', 'completed_at', 'due_date'];

    /**
     * Get the full description of the todo item.
     *
     * @return string
     */
    public function getFullDescriptionAttribute() {
        return "{$this->title}: {$this->description}";
    }

    /**
     * Get the users associated with the todo.
     */
    public function userTodos() {
        return $this->hasMany( UserTodo::class, 'todo_id' );
    }

}
