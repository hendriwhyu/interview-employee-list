<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\Employee;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        // Get total number of employees
    $totalEmployees = Employee::count();

    // Get total number of documents across all employees
    $totalDocuments = Document::count(); // Assuming Document is a separate model

    return view('admin.index', compact('totalEmployees', 'totalDocuments'));
    }
}
