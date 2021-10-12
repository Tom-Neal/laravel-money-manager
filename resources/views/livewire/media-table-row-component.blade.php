<td>{{ $row->name }}</td>
<td class="table_center">{{ FileSizeHelper::getFormattedValue($row->size) }}</td>
<td class="table_center">{{ $row->created_at }}</td>
<td class="table_center">
    <a class="btn btn-primary btn-sm" href="{{ url('api/media', $row) }}">
        <i class="fas fa-download text-white" aria-hidden="true"></i>
    </a>
</td>
<td class="table_center">
    <a class="btn btn-danger btn-sm" wire:click="destroyMedia({{ $row->id }})">
        <i class="fas fa-times text-white" aria-hidden="true"></i>
    </a>
</td>