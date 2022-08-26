<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGroupToPermissions extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        $tableNames = config('permission.table_names');
        if (empty($tableNames)) {
            throw new \Exception('Error: config/permission.php not loaded. Run [php artisan config:clear] and try again.');
        }
        Schema::table('permissions', function (Blueprint $table) {
            $table->string('group')->required()->after('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('permissions', function (Blueprint $table) {
            //
        });
    }
}
