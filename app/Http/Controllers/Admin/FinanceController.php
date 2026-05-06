<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FinanceController extends Controller
{
    public function invoices() { return view('admin.finance.invoices'); }
    public function receipt() { return view('admin.finance.invoices'); }
    public function payments() { return view('admin.finance.invoices'); }
    public function insurance() { return view('admin.finance.invoices'); }
    public function tax() { return view('admin.finance.invoices'); }
}
