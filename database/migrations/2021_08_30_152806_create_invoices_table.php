<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('number');
            $table->integer('total')->nullable();
            $table->date('date_sent')->nullable();
            $table->date('date_paid')->nullable();
            $table->date('email_sent')->nullable();
            $table->unsignedBigInteger('invoice_status_id')->default(\App\Models\InvoiceStatus::CREATED);
            $table->foreign('invoice_status_id')->references('id')->on('invoice_statuses')->onDelete('cascade');
            $table->unsignedBigInteger('client_id')->nullable();
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
