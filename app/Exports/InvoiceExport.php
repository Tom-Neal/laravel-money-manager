<?php

namespace App\Exports;

use App\Models\Invoice;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

use \Maatwebsite\Excel\Writer;
use \Maatwebsite\Excel\Sheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class InvoiceExport implements FromCollection, WithMapping, WithHeadings, WithColumnFormatting, WithEvents, ShouldAutoSize, WithStrictNullComparison
{

    public function collection(): Collection
    {
        return
            Invoice::query()
                ->orderBy('date_sent')
                ->with('client.clientType', 'invoiceStatus')
                ->get();
    }

    public function map($row): array
    {
        return [
            $row->number,
            $row->total_formatted,
            date('d/m/Y', strtotime($row->date_sent)),
            $row->client->clientType->name,
            $row->client->name,
            $row->invoiceStatus->name,
        ];
    }

    public function headings(): array
    {
        return [
            'Number',
            'Total',
            'Date Sent',
            'Type',
            'Client',
            'Status',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_TEXT,
        ];
    }

    public function registerEvents(): array
    {

        Sheet::macro('styleCells', function (Sheet $sheet, string $cellRange, array $style) {
            $sheet->getDelegate()->getStyle($cellRange)->applyFromArray($style);
        });

        Writer::macro('setCreator', function (Writer $writer, string $creator) {
            $writer->getDelegate()->getProperties()->setCreator($creator);
        });

        return [
            BeforeExport::class => function (BeforeExport $event) {
                $event->writer->setCreator(config('app.name'));
            },
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->styleCells(
                    'A1:Z1',
                    [
                        'font' => [
                            'bold' => true
                        ],
                    ]
                );
            },
        ];

    }

}
