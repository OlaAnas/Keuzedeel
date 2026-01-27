<?php

namespace App\Http\Controllers\Admin;

use App\Exports\AdminOverviewExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class ExportToExcelController extends Controller
{
    public function exportUsersExcel()
    {
        return Excel::download(new AdminOverviewExport(), 'admin_overview.xlsx');
    }
}
