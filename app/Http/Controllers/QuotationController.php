<?php
namespace App\Http\Controllers;

use App\Models\Prescription;
use App\Models\Quotation;
use App\Models\QuotationItem;
use App\Mail\QuotationCreated;
use App\Mail\QuotationResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class QuotationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Prescription $prescription)
    {
        $this->authorize('createQuotation', $prescription);
        
        $prescription->load(['user', 'images']);
        return view('quotations.create', compact('prescription'));
    }

    public function store(Request $request, Prescription $prescription)
    {
        $this->authorize('createQuotation', $prescription);

        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.drug_name' => 'required|string',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0.01',
        ]);

        try {
            DB::beginTransaction();

            $totalAmount = 0;
            $items = [];

            foreach ($request->items as $item) {
                $totalPrice = $item['quantity'] * $item['unit_price'];
                $totalAmount += $totalPrice;
                
                $items[] = [
                    'drug_name' => $item['drug_name'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'total_price' => $totalPrice,
                ];
            }

            // Create quotation
            $quotation = Quotation::create([
                'prescription_id' => $prescription->id,
                'pharmacy_id' => auth()->id(),
                'total_amount' => $totalAmount,
            ]);

            // Create quotation items
            foreach ($items as $item) {
                $item['quotation_id'] = $quotation->id;
                QuotationItem::create($item);
            }

            // Update prescription status
            $prescription->update(['status' => 'quoted']);

            DB::commit();

            // Send email notification
            Mail::to($prescription->user->email)->send(new QuotationCreated($quotation));

            return redirect()->route('pharmacy.dashboard')->with('success', 'Quotation created and sent successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to create quotation. Please try again.');
        }
    }

    public function show(Quotation $quotation)
    {
        $this->authorize('view', $quotation);
        
        $quotation->load(['prescription.user', 'pharmacy', 'items']);
        return view('quotations.show', compact('quotation'));
    }

    public function respond(Request $request, Quotation $quotation)
    {
        $this->authorize('respond', $quotation);

        $request->validate([
            'action' => 'required|in:accept,reject',
        ]);

        try {
            $status = $request->action === 'accept' ? 'accepted' : 'rejected';
            
            $quotation->update(['status' => $status]);
            $quotation->prescription->update(['status' => $status]);

            // Send email notification to pharmacy
            Mail::to($quotation->pharmacy->email)->send(new QuotationResponse($quotation, $request->action));

            $message = $request->action === 'accept' ? 'Quotation accepted successfully!' : 'Quotation rejected successfully!';
            return redirect()->route('user.dashboard')->with('success', $message);
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to respond to quotation. Please try again.');
        }
    }
}