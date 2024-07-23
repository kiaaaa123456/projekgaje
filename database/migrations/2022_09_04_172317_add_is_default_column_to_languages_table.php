<?php

use App\Models\Settings\Language;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class AddIsDefaultColumnToLanguagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $default_column = 0;
        Schema::table('languages', function ($table) use ($default_column) {
            if (!Schema::hasColumn('languages', 'is_default')) {
                $table->boolean('is_default')->default(0)->nullable();
                $default_column = 1;
            }
        });

        \Log::info('default column is ' . $default_column);
        if ($default_column) {
            $language = Language::find(19);
            $language->is_default = true;
            $language->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //remove column from languages
        Schema::table('languages', function ($table) {
            $table->dropColumn('is_default');
        });
    }
}
