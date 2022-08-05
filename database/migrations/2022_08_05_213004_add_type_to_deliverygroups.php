<?php
use Illuminate\Database\Migrations\Migration;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeToDeliveryGroups extends Migration{
	public function up() {
		Schema::table('deliverygroups', function (Blueprint $table) {
            $table->integer('type')->default(0)->after('delivery_time'); // 0 => contains delivery, 1 => only loan collection
		});
	}

	public function down() {
		Schema::table('deliverygroups', function (Blueprint $table) {

		});
	}
};
