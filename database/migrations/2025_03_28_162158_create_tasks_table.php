<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_week_id')->constrained();
            $table->string('title');
            $table->enum('area', ['A', 'B']);
            $table->integer('priority')->unsigned(); // 1-5
            $table->date('task_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->integer('estimated_hours');
            $table->integer('actual_hours')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('completed')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
