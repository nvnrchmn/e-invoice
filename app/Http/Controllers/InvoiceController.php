<?php
namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Services\RSAService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class InvoiceController extends Controller
{
    private function generateDataForSigning(string $number, string $client_name, float $amount): string
    {
        return $number . $client_name . number_format($amount, 2, '.', '');
    }
    public function index()
    {
        $invoices = Invoice::latest()->get();
        return view('invoices.index', compact('invoices'));
    }

    public function create()
    {
        return view('invoices.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'number'      => 'required|unique:invoices',
            'client_name' => 'required',
            'description' => 'nullable',
            'amount'      => 'required|numeric',
            'signed_at'   => now(),

        ]);
        // $dataString = $data['number'] . $data['client_name'] . number_format($data['amount'], 2, '.', '');
        $dataString = $this->generateDataForSigning($data['number'], $data['client_name'], $data['amount']);

        // $dataString = $data['number'] . $data['client_name'] . $data['amount']; // ← mungkin string "2.000.000"

        $signature = app(RSAService::class)->sign($dataString);

        $invoice = Invoice::create([
             ...$data,
            'signature'        => $signature,
            'data_for_signing' => $dataString,
        ]);

        return redirect()->route('invoices.show', $invoice->id)->with('success', 'Invoice created!');
    }

    public function show(string $id)
    {
        $invoice = Invoice::findOrFail($id);

        if (empty($invoice->data_for_signing) || empty($invoice->signature)) {
            return back()->withErrors('Invoice belum memiliki data atau tanda tangan RSA.');
        }

        $dataString = $invoice->data_for_signing;
        $isValid    = app(RSAService::class)->verify($dataString, $invoice->signature);

        return view('invoices.show', compact('invoice', 'isValid'));
    }

    public function edit(string $id)
    {
        $invoice = Invoice::findOrFail($id);
        return view('invoices.edit', compact('invoice'));
    }

    public function update(Request $request, string $id)
    {
        $invoice = Invoice::findOrFail($id);

        $data = $request->validate([
            'client_name' => 'required',
            'description' => 'nullable',
            'amount'      => 'required|numeric',
            'signed_at'   => now(),

        ]);

        // $dataString = $invoice->number . $data['client_name'] . $data['amount'];
        $dataString = $this->generateDataForSigning($invoice->number, $data['client_name'], $data['amount']);

        $signature = app(RSAService::class)->sign($dataString);

        $invoice->update([
             ...$data,
            'signature'        => $signature,
            'data_for_signing' => $dataString,
        ]);

        return redirect()->route('invoices.show', $invoice->id)->with('success', 'Invoice updated!');
    }

    public function destroy(string $id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->delete();

        return redirect()->route('invoices.index')->with('success', 'Invoice deleted!');
    }

    public function download($id)
    {
        $invoice = Invoice::findOrFail($id);

        if (empty($invoice->data_for_signing) || empty($invoice->signature)) {
            return back()->withErrors('Invoice belum lengkap untuk proses validasi.');
        }

        // Ambil URL publik dari .env (via config)
        $publicUrl = config('app.ngrok_url', 'http://localhost');
        $verifyUrl = $publicUrl . '/invoices/verify/' . $invoice->id;

        // QR Code pointing to verification URL
        $svg       = QrCode::format('svg')->size(150)->generate($verifyUrl);
        $svgBase64 = 'data:image/svg+xml;base64,' . base64_encode($svg);

        // Verifikasi RSA
        $isValid = app(RSAService::class)->verify(
            $invoice->data_for_signing,
            $invoice->signature
        );

        return Pdf::loadView('invoices.pdf', compact('invoice', 'svgBase64', 'isValid'))
            ->download(str_replace('/', '-', $invoice->number) . '.pdf');
    }

    public function verifyPage($id)
    {
        $invoice = Invoice::findOrFail($id);

        $isValid = app(RSAService::class)->verify(
            $invoice->data_for_signing,
            $invoice->signature
        );

        return view('invoices.verify', compact('invoice', 'isValid'));
    }

}
