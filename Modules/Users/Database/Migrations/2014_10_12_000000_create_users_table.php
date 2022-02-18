<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id')->index()->default(1);
            $table->string('name')->nullable();
            $table->string('email')->nullable()->unique()->index();
            $table->string('profile_image')->nullable();
            $table->string('password')->nullable();
            $table->string('social_provider')->nullable();
            $table->string('social_id')->nullable();
            $table->string('user_type')->nullable();
            $table->date('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

            //$table->foreign('company_id')->references('id')->on('company')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
