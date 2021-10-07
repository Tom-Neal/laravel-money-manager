<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateInvoicesTableAddBusinessIdColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('invoices', 'business_id')) {
            Schema::table('invoices', function (Blueprint $table) {
                $table->unsignedBigInteger('business_id')
                    ->after('invoice_status_id')
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
        if (Schema::hasColumn('invoices', 'business_id')) {
            Schema::table('invoices', function (Blueprint $table) {
                $table->dropColumn('business_id');
            });
        }
    }
}
