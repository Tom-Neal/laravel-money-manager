<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSettingsTableAddBankColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('settings', 'bank_name')) {
            Schema::table('settings', function (Blueprint $table) {
                $table->string('bank_name')
                    ->after('phone')
                    ->nullable();
            });
        }
        if (!Schema::hasColumn('settings', 'bank_account_number')) {
            Schema::table('settings', function (Blueprint $table) {
                $table->string('bank_account_number')
                    ->after('bank_name')
                    ->nullable();
            });
        }
        if (!Schema::hasColumn('settings', 'bank_sort_code')) {
            Schema::table('settings', function (Blueprint $table) {
                $table->string('bank_sort_code')
                    ->after('bank_account_number')
                    ->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('settings', 'bank_sort_code')) {
            Schema::table('settings', function (Blueprint $table) {
                $table->dropColumn('bank_sort_code');
            });
        }
        if (Schema::hasColumn('settings', 'bank_account_number')) {
            Schema::table('settings', function (Blueprint $table) {
                $table->dropColumn('bank_account_number');
            });
        }
        if (Schema::hasColumn('settings', 'bank_name')) {
            Schema::table('settings', function (Blueprint $table) {
                $table->dropColumn('bank_name');
            });
        }
    }
}
