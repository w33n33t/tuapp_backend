<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAppKindApplicationTable extends Migration {

	public function up()
	{
		Schema::create('app_kind_application', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
 
            $table->integer('application_id')->unsigned();
            $table->foreign('application_id')->references('id')->on('applications')->onDelete('cascade');

            $table->integer('app_kind_id')->unsigned();
            $table->foreign('app_kind_id')->references('id')->on('app_kinds')->onDelete('cascade');
 
		});
	}

	public function down()
	{
		Schema::drop('app_kind_application');
	}
}

