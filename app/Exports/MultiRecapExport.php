<?php

namespace App\Exports;

use App\Models\UserRecap;
use App\Models\UserRecapQuestion;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MultiRecapExport implements FromCollection, WithHeadings, WithStyles
{
    protected $ids;

    public function __construct($ids)
    {
        $this->ids = $ids;
    }

    public function collection()
    {
        $userRecaps = UserRecap::with('user', 'recap.brand', 'job')
            ->whereIn('id', $this->ids)
            ->whereIn('status', ['approved', 'approved-with-edit'])
            ->get();

        // Build unified question keys (stripped of trailing ? and trimmed) in headings order
        $questionKeys = [];
        foreach ($userRecaps as $recap) {
            $questions = UserRecapQuestion::where('user_recap_id', $recap->id)
                ->orderBy('id', 'asc')
                ->get();

            foreach ($questions as $q) {
                $key = trim($q->recap_question ?: '');
                $key = rtrim($key);
                $keyStripped = rtrim($key, " ?");
                if ($keyStripped === '') continue;
                if (!in_array($keyStripped, $questionKeys)) {
                    $questionKeys[] = $keyStripped;
                }
            }
        }

        $data = [];
        $no = 1;

        foreach ($userRecaps as $userRecap) {
            $shift = $userRecap->job;
            $recap = $userRecap->recap;
            $user = $userRecap->user;

            $eventDate = $shift->date ?? $recap->event_date ?? 'N/A';
            $scheduleStartTime = $shift->shift_start ?? $shift->start_time ?? 'N/A';

            $row = [];
            $row[] = $no++;
            $row[] = $user->name ?? 'N/A';
            $row[] = $recap->brand->title ?? ($shift->brand->title ?? 'N/A');
            $row[] = $eventDate;
            $row[] = $scheduleStartTime;

            // map this recap's answers by stripped question text
            $answersMap = [];
            $questions = UserRecapQuestion::where('user_recap_id', $userRecap->id)
                ->orderBy('id', 'asc')
                ->get();
            foreach ($questions as $q) {
                $k = trim($q->recap_question ?: '');
                $k = rtrim($k);
                $k = rtrim($k, " ?");
                if ($k === '') continue;
                $answersMap[$k] = $q->recap_question_answer ?? '';
            }

            // append answers in the unified question order
            foreach ($questionKeys as $qkey) {
                $row[] = $answersMap[$qkey] ?? '';
            }

            $data[] = $row;
        }

        return collect($data);
    }

    public function headings(): array
    {
        // Build unified headings across all selected recaps
        $userRecaps = UserRecap::whereIn('id', $this->ids)
            ->get();

        $questionKeys = [];
        foreach ($userRecaps as $recap) {
            $questions = UserRecapQuestion::where('user_recap_id', $recap->id)
                ->orderBy('id', 'asc')
                ->get();
            foreach ($questions as $q) {
                $label = trim($q->recap_question ?: '');
                $labelStripped = rtrim($label, " ?");
                if ($labelStripped === '') continue;
                if (!in_array($labelStripped, $questionKeys)) {
                    $questionKeys[] = $labelStripped;
                }
            }
        }

        $headings = [
            'No',
            'User Name',
            'Brand Name',
            'Event Date',
            'Schedule Start Time',
        ];

        foreach ($questionKeys as $label) {
            $out = $label;
            if (!str_ends_with($out, '?')) {
                $out .= ' ?';
            }
            $headings[] = $out;
        }

        return $headings;
    }

    public function styles(Worksheet $sheet)
    {
        $highestColumn = $sheet->getHighestColumn();
        $highestRow = $sheet->getHighestRow();

        $sheet->getStyle("A1:{$highestColumn}1")->getFont()->setBold(true);
        $sheet->getStyle("A1:{$highestColumn}1")->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFD3D3D3');

        $thinBorder = [
            'borders' => [
                'bottom' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];

        $sheet->getStyle("A1:{$highestColumn}1")->applyFromArray($thinBorder);

        if ($highestRow >= 2) {
            $dataBorder = [
                'borders' => [
                    'top' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => 'FF000000'],
                    ],
                    'bottom' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => 'FF000000'],
                    ],
                ],
            ];

            $sheet->getStyle("A2:{$highestColumn}{$highestRow}")->applyFromArray($dataBorder);
        }

        foreach ($sheet->getColumnIterator() as $column) {
            $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
        }

        return [];
    }
}