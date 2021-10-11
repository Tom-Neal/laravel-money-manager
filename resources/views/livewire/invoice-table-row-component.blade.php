<td class="table_center">{{ $row->number }}</td>
@if(!isset($client))
    <td>
        {{ $row->client->name ?? $row->business->name ?? '' }}
    </td>
@endif
<td>{{ $row->firstItem->description ?? '' }}</td>
<td class="table_center">{{ $row->date_sent }}</td>
<td class="table_center">{{ $row->lastPayment->date_paid ?? '' }}</td>
<td class="table_center">{{ $row->total_formatted }}</td>
<td class="table_center">
    <span class="fw-bold w-50 py-2 badge bg-{{ $row->invoiceStatus->colour }}">
        {{ $row->invoiceStatus->name }}
    </span>
</td>
<td class="table_center">
    @if($row->downloadCheck())
        <a class="btn btn-primary btn-sm" href="{{ url('invoices/download/preview', $row) }}" target="_blank">
            <i class="fas fa-eye text-white" aria-hidden="true"></i>
        </a>
    @else
        <span>-</span>
    @endif
</td>
<td class="table_center">
    @if($row->downloadCheck())
        <a class="btn btn-primary btn-sm" href="{{ url('invoices/download', $row) }}">
            <i class="fas fa-download text-white" aria-hidden="true"></i>
        </a>
    @else
        <span>-</span>
    @endif
</td>
@if(isset($client))
    <td class="table_center">
        @if($row->downloadCheck() && $client->email)
            <a class="btn btn-info btn-sm" href="{{ url('invoices/mails', $row) }}">
                <i class="fas fa-envelope text-white" aria-hidden="true"></i>
            </a>
        @else
            <span>-</span>
        @endif
    </td>
@endif
<td class="table_center">
    <a class="btn btn-secondary btn-sm" href="{{ url('invoices/copy', $row) }}">
        <i class="fas fa-copy text-white" aria-hidden="true"></i>
    </a>
</td>
<td class="table_center">
    <a class="btn btn-warning btn-sm" href="{{ url('invoices/edit', $row) }}">
        <i class="fas fa-wrench text-white" aria-hidden="true"></i>
    </a>
</td>