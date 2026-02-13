<?php

namespace App\Exports;

use App\Models\UserRecap;
use App\Models\UserRecapQuestion;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RecapExport implements FromCollection, WithHeadings, WithStyles
{
    protected $userRecapId;

    public function __construct($userRecapId)
    {
        $this->userRecapId = $userRecapId;
    }

    public function collection()
    {
        $userRecap = UserRecap::find($this->userRecapId);
        
        if (!$userRecap) {
            return collect([]);
        }

        // Get all user recap questions (answers submitted by user)
        $recapQuestions = UserRecapQuestion::where('user_recap_id', $this->userRecapId)
            ->orderBy('id', 'asc')
            ->get();

        $data = [];

        // Get job/shift details
        $shift = $userRecap->job; // Job model stores shift date and shift_start/shift_end
        $recap = $userRecap->recap;
        $user = $userRecap->user;

        // Determine event date: prefer job/shift date, fallback to recap event_date
        $eventDate = $shift->date ?? $recap->event_date ?? 'N/A';
        // Determine schedule start time: prefer shift_start, fall back to shift_start-like fields
        $scheduleStartTime = $shift->shift_start ?? $shift->start_time ?? 'N/A';

        $row = [];
        // Row number (single recap export -> 1)
        $row[] = 1;
        $row[] = $user->name ?? 'N/A';
        $row[] = $recap->brand->title ?? ($shift->brand->title ?? 'N/A');
        $row[] = $eventDate;
        $row[] = $scheduleStartTime;

        // Add answers for each question (preserve order)
        foreach ($recapQuestions as $question) {
            $row[] = $question->recap_question_answer ?? '';
        }

        $data[] = $row;

        return collect($data);
    }

    public function headings(): array
    {
        $userRecap = UserRecap::find($this->userRecapId);
        
        if (!$userRecap) {
            return [];
        }

        // Get all user recap questions to build dynamic headings
        $recapQuestions = UserRecapQuestion::where('user_recap_id', $this->userRecapId)
            ->orderBy('id', 'asc')
            ->get();

        $headings = [
            'No',
            'User Name',
            'Brand Name',
            'Event Date',
            'Schedule Start Time',
        ];

        // Use actual question text for headings; append '?' as requested
        foreach ($recapQuestions as $index => $question) {
            $label = $question->recap_question ?? ('Q' . ($index + 1));
            // Ensure heading ends with a question mark
            $label = rtrim($label);
            if (!str_ends_with($label, '?')) {
                $label .= ' ?';
            }
            $headings[] = $label;
        }

        return $headings;
    }

    public function styles(Worksheet $sheet)
    {
        // Determine used range
        $highestColumn = $sheet->getHighestColumn();
        $highestRow = $sheet->getHighestRow();

        // Style header row (row 1): bold, gray fill, bottom border
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

        // Style data rows: top and bottom thin borders between rows
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

        // Auto-adjust column widths
        foreach ($sheet->getColumnIterator() as $column) {
            $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
        }

        return [];
    }
}
