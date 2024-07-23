<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddBranchIdColumnToAllTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        // Define the columns to be added
        $columns = [
            'branch_id' => 'unsignedBigInteger',
            'company_id' => 'unsignedBigInteger',
        ];

        // Specify the excluded tables
        $excludedTables = ['countries', 'statuses', 'branches', 'companies', 'permissions', 'time_zones'];
        $excludedTables = [];
        // Get all table names from the database
        $tables = DB::select('SHOW TABLES');

        foreach ($tables as $table) {
            $tableName = reset($table);

            // Check if the table is not in the excluded list
            if (!in_array($tableName, $excludedTables)) {
                Schema::table($tableName, function (Blueprint $table) use ($columns) {
                    foreach ($columns as $columnName => $columnType) {
                        if (!Schema::hasColumn($table->getTable(), $columnName)) {
                            $table->$columnType($columnName)->nullable()->default(1);
                        }
                    }
                });
            }
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('all', function (Blueprint $table) {
            //
        });
    }
}
