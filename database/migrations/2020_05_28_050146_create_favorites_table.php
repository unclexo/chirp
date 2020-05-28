<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFavoritesTable extends Migration
{
    public function up() : void
    {
        Schema::create('favorites', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->unique();
            $table->unsignedBigInteger('user_id')->index();
            $table->json('data');
            $table->timestamp('created_at');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        DB::statement("ALTER TABLE favorites ADD COLUMN full_text LONGTEXT GENERATED ALWAYS AS (data -> '$.full_text') STORED");
        DB::statement('CREATE FULLTEXT INDEX favorites_full_text_index ON favorites (full_text)');
    }
}
