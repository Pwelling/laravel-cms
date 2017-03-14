<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('type')->comment('0=geen link,1=pagina, 2=pagina groep');
            $table->integer('itemId');
            $table->integer('parentId');
            $table->string('text')->comment('De weergegeven text');
            $table->tinyInteger('target')->default(0)->comment('0=zelfde scherm, 1=ander scherm');
            $table->string('url')->nullable();
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
        Schema::drop('menus');
    }
}
