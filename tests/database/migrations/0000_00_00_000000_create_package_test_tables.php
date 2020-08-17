<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreatePackageTestTables
 */
class CreatePackageTestTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("users", function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->uuid("uuid");
            $table->string("api_key")->nullable();
            $table->string("slug")->unique();
            $table->string("name");
            $table->dateTime("banned_at")->nullable()->default(null);
            $table->dateTime("activated_at")->nullable()->default(null);
            $table->timestamps();
        });
        
        Schema::create("posts", function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->unsignedBigInteger("user_id")->nullable()->index();
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
        Schema::dropIfExists("users");
    }
}
