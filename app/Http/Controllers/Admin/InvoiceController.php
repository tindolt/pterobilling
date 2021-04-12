<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;

class InvoiceController extends Controller
{
    public function index()
    {
        return view('admin.invoice.index', ['title' => 'Invoices', 'invoices' => Invoice::all()]);
    }

    public function show($id)
    {
        return view('client.invoice.show', ['title' => "Invoice #${id} - Invoices", 'header1' => 'Invoices', 'header1_route' => 'admin.invoice.index', 'header_title' => "Invoice #${id}", 'id' => $id]);
    }
}
