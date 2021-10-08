<?php

namespace App\Http\Livewire;

use App\Models\Invoice;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class InvoiceTableRowComponent extends DataTableComponent
{

    public array $perPageAccepted = [10, 25, 50];
    public bool $perPageAll = true;

    public function columns(): array
    {
        return [
            Column::make('Number')
                ->sortable()
                ->searchable()
                ->addClass('table_center table_col_width_5'),
            Column::make('Client'),
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
            Column::make('Copy')
                ->addClass('table_center table_col_width_5'),
            Column::make('Edit')
                ->addClass('table_center table_col_width_5'),
        ];
    }

    public function query(): Builder
    {
        return
            Invoice::query()
                ->orderBy('date_sent', 'desc')
                ->with('client', 'invoiceStatus', 'items');
    }

    public function rowView(): string
    {
        return 'livewire.invoice-table-row-component';
    }

}
