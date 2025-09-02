<?php
namespace App\Http\Controllers;

use App\Models\Prescription;
use Illuminate\Http\Request;

class UserDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'user.type:user']);
    }

    public function index()
    {
        $prescriptions = Prescription::where('user_id', auth()->id())
            ->with(['images', 'quotation'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.dashboard', compact('prescriptions'));
    }
}