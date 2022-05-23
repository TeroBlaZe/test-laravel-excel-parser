<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Row;

class RowsController extends Controller
{
    public function index()
    {
        $rows = Row::all();
        $groupBy = static fn (Row $row) => $row->date->toDateString();

        return response()->json([
            'data' => $rows->groupBy($groupBy),
        ]);
    }
}
