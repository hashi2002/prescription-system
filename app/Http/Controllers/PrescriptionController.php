<?php
namespace App\Http\Controllers;

use App\Models\Prescription;
use App\Models\PrescriptionImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PrescriptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
        return view('prescriptions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'delivery_address' => 'required|string',
            'delivery_time' => 'required|string',
            'note' => 'nullable|string',
            'images' => 'required|array|min:1|max:5',
            'images.*' => 'required|image|mimes:jpeg,jpg,png|max:5120', // 5MB
        ]);

        try {
            // Create prescription
            $prescription = Prescription::create([
                'user_id' => auth()->id(),
                'note' => $request->note,
                'delivery_address' => $request->delivery_address,
                'delivery_time' => $request->delivery_time,
            ]);

            // Handle image uploads
            foreach ($request->file('images') as $index => $image) {
                $filename = 'prescription_' . $prescription->id . '_' . ($index + 1) . '_' . time() . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('prescriptions', $filename, 'public');

                PrescriptionImage::create([
                    'prescription_id' => $prescription->id,
                    'image_path' => $path,
                ]);
            }

            return redirect()->route('user.dashboard')->with('success', 'Prescription uploaded successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to upload prescription. Please try again.');
        }
    }

    public function show(Prescription $prescription)
    {
        $this->authorize('view', $prescription);
        
        $prescription->load(['user', 'images']);
        return view('prescriptions.show', compact('prescription'));
    }
}