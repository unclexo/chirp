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
            $table->unsignedBigInteger('id')->unique();
            $table->unsignedBigInteger('user_id')->index();
            $table->json('data');
            $table->timestamp('created_at');
        });

        DB::statement("ALTER TABLE likes ADD COLUMN text LONGTEXT GENERATED ALWAYS AS (data -> '$.text') STORED");
        DB::statement('CREATE FULLTEXT INDEX likes_text_index ON likes (text);');
    }
}
