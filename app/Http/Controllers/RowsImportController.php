<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RowsImportController extends Controller
{
    public static array $rules = [
        'file' => ['required', 'file', 'mimes:xls,xlsx'],
    ];

    public function __invoke(Request $request)
    {
        $request->validate(self::$rules);

        return $request->file('file');
    }
}
