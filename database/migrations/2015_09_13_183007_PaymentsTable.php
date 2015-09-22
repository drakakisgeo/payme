<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments',function($table){
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->text('description');
            $table->decimal('amount',5,2);
            $table->integer('user_id')->unsigned();
            $table->string('code');
            $table->boolean('active')->default(1);
            $table->boolean('paid')->default(0);
            $table->boolean('invoiced')->default(0); // if an invoice was generated about this.
            $table->datetime('paid_at')->nullable();
            $table->string('gatewayref_id')->nullable();
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
        Schema::drop('payments');
    }
}
