<?php

namespace App\Http\Livewire;

use App\Models\{Client, Invoice};
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class ClientInvoiceTableRowComponent extends DataTableComponent
{

    public Client $client;
    public array $perPageAccepted = [5, 10, 20];
    public bool $perPageAll = true;
    protected $listeners = ['storeInvoice' => 'query'];

    public function columns(): array
    {
        return [
            Column::make('Number')
                ->sortable()
                ->searchable()
                ->addClass('table_center table_col_width_5'),
            Column::make('First Item'),
            Column::make('Date Sent')
                ->sortable()
                ->addClass('table_center table_col_width_10'),
            Column::make('Latest Payment')
                ->addClass('table_center table_col_width_10'),
            Column::make('Total')
                ->sortable()
                ->addClass('table_center table_col_width_5'),
            Column::make('Status')
                ->addClass('table_center table_col_width_10'),
            Column::make('PDF')
                ->addClass('table_center table_col_width_5'),
            Column::make('Send')
                ->addClass('table_center table_col_width_5'),
            Column::make('Copy'
            )->addClass('table_center table_col_width_5'),
            Column::make('Edit'
            )->addClass('table_center table_col_width_5'),
        ];
    }

    public function query(): Builder
    {
        return
            Invoice::query()
                ->where('client_id', $this->client->id)
                ->orderBy('date_sent', 'desc')
                ->with('invoiceStatus', 'items');
    }

    public function rowView(): string
    {
        return 'livewire.invoice-table-row-component';
    }

}
