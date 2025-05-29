<?php

namespace App\Http\Controllers;

use App\Models\RentPayment;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RentPaymentController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $payments = RentPayment::whereHas('rentalContract', function ($query) use ($request) {
            $query->where('tenant_id', $request->user()->id);
        })->get();
        return response()->json($payments);
    }

    public function show($id)
    {
        $payment = RentPayment::findOrFail($id);
        return response()->json($payment);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'rental_contract_id' => 'required|exists:rental_contracts,id',
            'due_date' => 'required|date',
            'payment_date' => 'nullable|date',
            'amount' => 'required|numeric',
            'status' => 'required|in:pending,paid,late',
        ]);

        $payment = RentPayment::create([
            'rental_contract_id' => $request->rental_contract_id,
            'due_date' => $request->due_date,
            'payment_date' => $request->payment_date,
            'amount' => $request->amount,
            'status' => $request->status,
        ]);

        return response()->json($payment, 201);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $payment = RentPayment::findOrFail($id);

        $request->validate([
            'rental_contract_id' => 'required|exists:rental_contracts,id',
            'due_date' => 'required|date',
            'payment_date' => 'nullable|date',
            'amount' => 'required|numeric',
            'status' => 'required|in:pending,paid,late',
        ]);

        $payment->update([
            'rental_contract_id' => $request->rental_contract_id,
            'due_date' => $request->due_date,
            'payment_date' => $request->payment_date,
            'amount' => $request->amount,
            'status' => $request->status,
        ]);

        return response()->json($payment);
    }

    public function destroy($id): JsonResponse
    {
        $payment = RentPayment::findOrFail($id);
        $payment->delete();
        return response()->json(null, 204);
    }
    public function generateReceipt(RentPayment $rentPayment): Response
    {
        // Vérifier si le paiement est marqué comme payé
        if ($rentPayment->status !== 'paid') {
            abort(403, 'Impossible de générer un reçu pour un paiement non effectué');
        }

        $pdf = Pdf::loadView('pdf.rent-receipt', [
            'payment' => $rentPayment,
        ]);

        return $pdf->stream('recu-' . $rentPayment->payment_reference . '.pdf');
    }
}
