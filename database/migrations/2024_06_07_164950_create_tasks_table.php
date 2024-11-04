<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateTasksTable extends Migration
{
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->string('description', 400);
            $table->dateTime('start_date');
            $table->dateTime('due_date');
            $table->dateTime('finished_date')->nullable();
            $table->string('status', 20)->default('TODO');
            $table->unsignedInteger('category_id');
            $table->timestamps(); // Thêm các cột created_at và updated_at

            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });

        // Insert initial data
        DB::table('tasks')->insert([
            ['id' => 3, 'name' => 'Làm bài tập về nhà UDPT', 'description' => 'Xây dựng ứng dụng quản lý công việc', 'start_date' => '2020-06-13 00:00:00', 'due_date' => '2020-06-20 00:00:00', 'finished_date' => null, 'status' => 'TODO', 'category_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'name' => 'Đăng ký lớp học bơi', 'description' => 'Đăng ký lớp học bơi tại hồ bơi Lam Sơn', 'start_date' => '2020-06-19 00:00:00', 'due_date' => '2020-06-19 00:00:00', 'finished_date' => '2020-06-19 00:00:00', 'status' => 'FINISHED', 'category_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'name' => 'Tìm hiểu đề tài Seminar', 'description' => 'Tìm hiểu đề tài Seminar Lý thuyết', 'start_date' => '2020-06-19 00:00:00', 'due_date' => '2020-06-20 00:00:00', 'finished_date' => null, 'status' => 'TODO', 'category_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 6, 'name' => 'Họp nhóm làm đồ án thực hành', 'description' => 'Họp nhóm làm đồ án thực hành', 'start_date' => '2020-06-17 00:00:00', 'due_date' => '2020-06-18 00:00:00', 'finished_date' => '2020-06-18 00:00:00', 'status' => 'FINISHED', 'category_id' => 1, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}