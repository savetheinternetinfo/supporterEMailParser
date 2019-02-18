<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFetchedEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fetchedEmails', function (Blueprint $table) {
            $table->increments('id');
            $table->text('name')->nullable();
            $table->text('mail')->nullable();
            $table->text('title')->nullable();
            $table->longText('body')->nullable();
            $table->integer('status')->default(0);
            $table->integer('type');
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
        Schema::dropIfExists('fetchedEmails');
    }
}
