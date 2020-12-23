<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agents', function (Blueprint $table) {
            $table->id();
            $table->string('ain_no');
            $table->string('name');
            $table->string('owners_name')->nullable();
            $table->string('photo')->nullable();
            $table->string('destination')->nullable();
            $table->string('office_address')->nullable();
            $table->string('phone');
            $table->string('house')->nullable();
            $table->string('email');
            $table->text('note')->nullable();
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
        Schema::dropIfExists('agents');
    }
}
