<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        return view('client.invoice.index', ['title' => 'Invoices']);
    }

    public function show($id)
    {
        $view_variables = array('title' => "Invoice #${id} - Invoices", 'header1' => 'Invoices', 'header1_route' => 'client.invoice.index', 'header_title' => "Invoice #${id}", 'id' => $id);
        return view('client.invoice.show', $view_variables);
    }

    public function print($id)
    {
        return view('mail.invoice', ['title' => "Invoice #${id} - Invoices", 'id' => $id]);
    }

    public function store(Request $request, $id)
    {
        // Pass data to payment gateway extensions
    }

    public function paid($id)
    {
        $invoice = Invoice::find($id);
        $view_variables = array('title' => "Invoice #${id} - Invoices", 'header1' => 'Invoices', 'header1_route' => 'client.invoice.index', 'header2' => "Invoice #${id}", 'header2_route' => 'client.invoice.show', 'header_title' => "Invoice Paid", 'id' => $id, 'invoice' => $invoice);
        return view('client.invoice.paid', $view_variables);
    }
}
