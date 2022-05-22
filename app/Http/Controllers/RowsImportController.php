<?php

namespace App\Http\Controllers;

use App\Import\RowsImporter;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class RowsImportController extends Controller
{
    public static array $rules = [
        'file' => ['required', 'file', 'mimes:xls,xlsx'],
    ];

    public function __invoke(Request $request)
    {
        $request->validate(self::$rules);

        Excel::import(new RowsImporter(), $request->file('file'));
    }
}
