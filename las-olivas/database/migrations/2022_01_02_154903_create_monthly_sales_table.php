<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMonthlySalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monthly_sales', function (Blueprint $table) {
            $table->id();
            $table->float('fc', 10, 2)->nullable(false);
            $table->float('fcc', 10, 2)->nullable(false);
            $table->float('ef', 10, 2)->nullable(false);
            $table->float('tc', 10, 2)->nullable(false);
            $table->float('td', 10, 2)->nullable(false);
            $table->string('month', 2)->nullable(false);
            $table->string('year', 10)->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('monthly_sales');
    }
}
