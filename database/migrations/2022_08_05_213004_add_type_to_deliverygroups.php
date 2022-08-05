<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class {
	public function up() {
		Schema::table('deliverygroups', function (Blueprint $table) {
            $table->integer('type')->default(0); // 0 => contains delivery, 1 => only loan collection
		});
	}

	public function down() {
		Schema::table('deliverygroups', function (Blueprint $table) {

		});
	}
};
