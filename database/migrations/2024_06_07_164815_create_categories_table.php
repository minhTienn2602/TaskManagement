<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50);
            $table->dateTime('date_created');
            //$table->timestamps(); // Thêm created_at và updated_at
        });

        // Insert initial data
        DB::table('categories')->insert([
            ['id' => 1, 'name' => 'Công việc', 'date_created' => '2020-06-12 00:00:00'],
            ['id' => 2, 'name' => 'Cá nhân', 'date_created' => '2020-06-12 00:00:00'],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('categories');
    }
}