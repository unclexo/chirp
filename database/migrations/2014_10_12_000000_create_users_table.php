<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    public function up() : void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->unique();
            $table->string('name');
            $table->string('nickname');
            $table->string('token');
            $table->string('token_secret');
            $table->json('data');
            $table->json('followers');
            $table->json('friends');
            $table->json('muted');
            $table->json('blocked');
            $table->timestamps();
        });
    }
}
