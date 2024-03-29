<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTomanSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('toman_sales', function (Blueprint $table) {
            $table->id();
            $table->integer('partyid'); // client id
            $table->integer('toman_balance_id');
            $table->integer('acctype');
            $table->decimal('toman', 20, 2);
            $table->decimal('rate', 20, 2);
            $table->integer('isopen')->default(1); // 1 is open 0 is closed
            $table->decimal('amount', 20, 2);
            $table->date('date');
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
        Schema::dropIfExists('toman_sales');
    }
}
