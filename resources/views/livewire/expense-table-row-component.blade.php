<td>{{ $row->description }}</td>
<td>
    {{ $row->price_formatted }}
</td>
<td>
    {{ $row->price_with_vat_formatted }}
</td>
<td>
    {{ date('d/m/Y', strtotime($row->date_incurred)) }}
</td>
<td class="table_center">
    <a class="btn btn-warning btn-sm" href="{{ url('expenses/edit', $row) }}">
        <i class="fas fa-wrench text-white" aria-hidden="true"></i>
    </a>
</td>