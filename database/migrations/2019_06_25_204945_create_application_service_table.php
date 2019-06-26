<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateApplicationserviceTable extends Migration {

	public function up()
	{
		Schema::create('application_service', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
 
            $table->integer('application_id')->unsigned();
            $table->foreign('application_id')->references('id')->on('applications')->onDelete('cascade');

            $table->integer('service_id')->unsigned();
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
 
		});
	}

	public function down()
	{
		Schema::drop('application_service');
	}
}

