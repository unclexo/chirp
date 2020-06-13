<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLikesTable extends Migration
{
    public function up() : void
    {
        Schema::create('likes', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->unsignedBigInteger('user_id')->index();
            $table->json('data');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        DB::statement("ALTER TABLE likes ADD COLUMN author_name VARCHAR(255) GENERATED ALWAYS AS (data -> '$.user.name') STORED");
        DB::statement("ALTER TABLE likes ADD COLUMN author_screen_name VARCHAR(255) GENERATED ALWAYS AS (data -> '$.user.screen_name') STORED");
        DB::statement("ALTER TABLE likes ADD COLUMN full_text LONGTEXT GENERATED ALWAYS AS (data -> '$.full_text') STORED");
        DB::statement('CREATE FULLTEXT INDEX likes_full_text_index ON likes (author_name, author_screen_name, full_text) WITH PARSER ngram');
    }
}
