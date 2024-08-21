<?php

namespace App\Models;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class UserTodo extends Model {
    use HasFactory;
    protected $fillable = [
        'user_id',
        'todo_id',
    ];

    protected static function boot() {
        parent::boot();

        static::creating( function ( $model ) {
            if ( empty( $model->id ) ) {
                $model->id = Uuid::uuid4()->toString();
            }
        } );
    }

    /**
     * Get the user associated with this UserTodo.
     */
    public function user() {
        return $this->belongsTo( User::class, 'user_id' );
    }

    /**
     * Get the todo associated with this UserTodo.
     */
    public function todo() {
        return $this->belongsTo( Todo::class, 'todo_id' );
    }

}