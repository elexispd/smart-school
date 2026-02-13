<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PaymentReportExport implements FromCollection, WithHeadings, WithMapping
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data;
    }

    public function headings(): array
    {
        return [
            'S/N',
            'Student Name',
            'Admission Number',
            'Class',
            'Fee Category',
            'Total Fee',
            'Amount Paid',
            'Balance',
            'Status',
            'Last Payment Date',
        ];
    }

    public function map($row): array
    {
        static $index = 0;
        $index++;
        
        return [
            $index,
            $row->student_name,
            $row->admission_number,
            $row->class_name,
            $row->fee_category,
            number_format($row->total_fee, 2),
            number_format($row->amount_paid, 2),
            number_format($row->balance, 2),
            $row->status,
            $row->last_payment_date ? $row->last_payment_date->format('M d, Y') : 'N/A',
        ];
    }
}
