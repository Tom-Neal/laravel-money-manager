<?php

namespace App\Http\Livewire;

use App\Models\Invoice;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaTableRowComponent extends DataTableComponent
{

    public array $perPageAccepted = [20, 50, 100];
    public bool $perPageAll = true;
    protected $listeners = ['storeMedia' => 'query'];

    public function columns(): array
    {
        return [
            Column::make('FileName')
                ->sortable()
                ->searchable(),
            Column::make('Size')
                ->addClass('table_center table_col_width_10'),
            Column::make('Uploaded')
                ->addClass('table_center table_col_width_15'),
            Column::make('Download')
                ->addClass('table_center table_col_width_5'),
            Column::make('Delete')
                ->addClass('table_center table_col_width_5'),
        ];
    }

    public function query(): Builder
    {
        return
            Media::query()
                ->where('model_type', 'App\Models\User')
                ->where('model_id', auth()->user()->id)
                ->latest();
    }

    public function rowView(): string
    {
        return 'livewire.media-table-row-component';
    }

    public function destroyMedia(Media $media)
    {
        $media->delete();
        $this->dispatchBrowserEvent(
            'notify', ['type' => 'danger', 'message' => 'File Deleted']
        );
    }

}
