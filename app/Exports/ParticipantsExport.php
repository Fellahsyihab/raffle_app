<?php

namespace App\Exports;

use App\Models\Participant;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ParticipantsExport implements FromQuery, WithHeadings, WithMapping
{
    protected $date;

    public function __construct($date) {
        $this->date = $date;
    }

    public function query() {
        $query = Participant::query();
        if ($this->date) {
            $query->whereDate('created_at', $this->date);
        }
        return $query;
    }

    public function headings(): array {
        return ["Waktu", "Nama Peserta", "Hadiah"];
    }

    public function map($participant): array {
        return [
            $participant->created_at->format('d M Y H:i'),
            $participant->name,
            $participant->prize_won,
        ];
    }
}