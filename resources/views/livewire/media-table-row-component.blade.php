<td>{{ $row->name }}</td>
<td>{{ FileSizeHelper::getFormattedValue($row->size) }}</td>
<td>{{ $row->created_at }}</td>
<td class="table_center">
    <a class="btn btn-primary btn-sm" href="{{ url('media/download', $row) }}">
        <i class="fas fa-download text-white" aria-hidden="true"></i>
    </a>
</td>
<td class="table_center">
    <a class="btn btn-danger btn-sm" wire:click="destroyMedia({{ $row->id }})">
        <i class="fas fa-times text-white" aria-hidden="true"></i>
    </a>
</td>