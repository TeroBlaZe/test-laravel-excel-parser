<?php

declare(strict_types=1);

namespace App\Import;

use App\Models\Row;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\WithValidation;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class RowsImporter implements
    WithEvents,
    SkipsEmptyRows,
    WithHeadingRow,
    WithBatchInserts,
    WithUpserts,
    WithChunkReading,
    ShouldQueue,
    WithValidation,
    ToModel
{
    use RegistersEventListeners;

    public function rules(): array
    {
        return [
            'id' => ['required', 'numeric', 'min:1'],
            'name' => ['required'],
            'date' => ['required'],
        ];
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function batchSize(): int
    {
        return 1000;
    }

    public function uniqueBy()
    {
        return 'id';
    }

    public function model(array $row)
    {
        return new Row([
            'id' => (int) $row['id'],
            'name' => trim((string) $row['name']),
            'date' => Date::excelToDateTimeObject($row['date']),
        ]);
    }
}
