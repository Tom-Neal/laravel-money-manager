<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration {

    public function up() {
        Schema::create('comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('description');
            $table->unsignedBigInteger('commenttable_id');
            $table->string('commenttable_type', 50);
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('comments');
    }

}
