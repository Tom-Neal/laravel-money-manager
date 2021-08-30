<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceStatus extends Model
{

    protected $table = 'invoice_statuses';
    public $timestamps = false;

    public const CREATED = 1;
    public const SENT = 2;
    public const PART_PAID = 3;
    public const PAID = 4;

}
