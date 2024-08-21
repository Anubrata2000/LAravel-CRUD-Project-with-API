<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create( 'todos', function ( Blueprint $table ) {
            $table->string( 'id', 45 )->primary(); // UUID
            $table->string( 'title' ); // Title of the task
            $table->text( 'description' )->nullable(); // Detailed description of the task
            $table->enum( 'status', ['Pending', 'In Progress', 'Completed'] )->default( 'Pending' ); // Status of the task
            $table->enum( 'priority', ['Low', 'Medium', 'High'] )->default( 'Medium' ); // Priority level
            $table->date( 'due_date' )->nullable(); // Due date of the task
            $table->timestamp( 'completed_at' )->nullable(); // When the task was completed
            $table->text( 'comments' )->nullable(); // Additional comments or notes
            $table->softDeletes();
            $table->timestamps();
        } );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists( 'todos' );
    }
};