<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organizations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_id')->index();
            $table->date('date', 0)->nullable();
            $table->string('status', 150)->nullable();
            $table->string('contact', 50)->nullable();
            $table->string('company', 50)->nullable();
            $table->string('town', 50)->nullable();
            $table->string('area', 50)->nullable();
            $table->string('tel', 50)->nullable();
            $table->string('mobile', 50)->nullable();
            $table->string('email', 50)->nullable();
            $table->string('web', 50)->nullable();
            $table->string('brands', 50)->nullable();
            $table->string('comments', 50)->nullable();
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('organizations');
    }
}
