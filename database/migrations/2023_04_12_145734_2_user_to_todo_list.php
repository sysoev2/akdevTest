<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users_todo_lists', function (Blueprint $table) {
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('todo_list_id')->unsigned();
            $table->boolean('is_author');
            $table->primary(['user_id','todo_list_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_todo_lists');
    }
};
