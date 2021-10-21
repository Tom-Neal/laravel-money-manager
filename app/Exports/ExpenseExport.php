<?php

namespace App\Exports;

use App\Models\Expense;
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

class ExpenseExport implements FromCollection, WithMapping, WithHeadings, WithColumnFormatting, WithEvents, ShouldAutoSize, WithStrictNullComparison
{

    public function collection(): Collection
    {
        return
            Expense::query()
            ->oldest('date_incurred')
            ->get();
    }

    public function map($row): array
    {
        return [
            $row->description,
            $row->price_formatted,
            $row->price_with_vat_formatted,
            date('d/m/Y', strtotime($row->date_incurred)),
            ucfirst($row->category)
        ];
    }

    public function headings(): array
    {
        return [
            'Description',
            'Price',
            'Price (with VAT)',
            'Date Incurred',
            'Type',
        ];
    }

    public function columnFormats(): array
    {
        return [];
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
