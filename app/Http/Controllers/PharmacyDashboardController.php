<?php
namespace App\Http\Controllers;

use App\Models\Prescription;
use Illuminate\Http\Request;

class PharmacyDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'pharmacy']);
    }

    public function index()
    {
        $prescriptions = Prescription::with(['user', 'images', 'quotations' => function($query) {
                $query->where('pharmacy_id', auth()->id());
            }])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pharmacy.dashboard', compact('prescriptions'));
    }
}