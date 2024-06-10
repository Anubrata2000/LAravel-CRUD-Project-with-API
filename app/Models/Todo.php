<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

class Todo extends Model {
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
    ];

    protected static function boot() {
        parent::boot();

        static::creating( function ( $model ) {
            if ( empty( $model->id ) ) {
                $model->id = Uuid::uuid4()->toString();
            }
        } );
    }

    protected $dates = ['deleted_at'];

}