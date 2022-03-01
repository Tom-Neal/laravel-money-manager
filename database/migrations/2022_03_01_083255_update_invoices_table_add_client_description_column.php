<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('invoices', 'client_description')) {
            Schema::table('invoices', function (Blueprint $table) {
                $table->text('client_description')
                    ->after('email_sent')
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
        if (Schema::hasColumn('invoices', 'client_description')) {
            Schema::table('invoices', function (Blueprint $table) {
                $table->dropColumn('client_description');
            });
        }
    }
};
