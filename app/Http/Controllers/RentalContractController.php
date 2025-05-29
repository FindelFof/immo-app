<?php

namespace App\Http\Controllers;

use App\Models\RentalContract;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RentalContractController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $contracts = RentalContract::where('tenant_id', $request->user()->id)->get();
        return response()->json($contracts);
    }

    public function show($id): JsonResponse
    {
        $contract = RentalContract::findOrFail($id);
        return response()->json($contract);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'property_id' => 'required|exists:properties,id',
            'tenant_id' => 'required|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'monthly_rent' => 'required|numeric',
            'deposit' => 'required|numeric',
            'status' => 'required|in:active,terminated,expired',
        ]);

        $contract = RentalContract::create([
            'property_id' => $request->property_id,
            'tenant_id' => $request->tenant_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'monthly_rent' => $request->monthly_rent,
            'deposit' => $request->deposit,
            'status' => $request->status,
        ]);

        return response()->json($contract, 201);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $contract = RentalContract::findOrFail($id);

        $request->validate([
            'property_id' => 'required|exists:properties,id',
            'tenant_id' => 'required|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'monthly_rent' => 'required|numeric',
            'deposit' => 'required|numeric',
            'status' => 'required|in:active,terminated,expired',
        ]);

        $contract->update([
            'property_id' => $request->property_id,
            'tenant_id' => $request->tenant_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'monthly_rent' => $request->monthly_rent,
            'deposit' => $request->deposit,
            'status' => $request->status,
        ]);

        return response()->json($contract);
    }

    public function destroy($id): JsonResponse
    {
        $contract = RentalContract::findOrFail($id);
        $contract->delete();
        return response()->json(null, 204);
    }
    public function generatePdf(RentalContract $rentalContract): Response
    {
        $pdf = Pdf::loadView('pdf.rental-contract', [
            'contract' => $rentalContract,
        ]);

        return $pdf->stream('contrat-' . $rentalContract->contract_number . '.pdf');
    }
}
