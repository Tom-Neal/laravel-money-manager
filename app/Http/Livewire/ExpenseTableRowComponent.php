<?php

namespace App\Http\Livewire;

use App\Models\Expense;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class ExpenseTableRowComponent extends DataTableComponent
{

    public array $perPageAccepted = [10, 25, 50];
    public bool $perPageAll = true;

    public function columns(): array
    {
        return [
            Column::make('Description')
                ->sortable()
                ->searchable(),
            Column::make('Price')
                ->addClass('table_col_width_15'),
            Column::make('Price (with VAT)')
                ->addClass('table_col_width_15'),
            Column::make('Date Incurred')
                ->addClass('table_col_width_15'),
            Column::make('Edit')
                ->addClass('table_center table_col_width_5'),
        ];
    }

    public function query(): Builder
    {
        return
            Expense::query();
    }

    public function rowView(): string
    {
        return 'livewire.expense-table-row-component';
    }

}
