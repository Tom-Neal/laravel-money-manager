<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\InvoiceProject
 *
 * @property int $id
 * @property int $invoice_id
 * @property int $project_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceProject newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceProject newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceProject query()
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceProject whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceProject whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceProject whereInvoiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceProject whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceProject whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class InvoiceProject extends Model
{
    use HasFactory;

    protected $table = 'invoice_project';

}
