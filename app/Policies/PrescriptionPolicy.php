<?php
namespace App\Policies;

use App\Models\Prescription;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PrescriptionPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Prescription $prescription)
    {
        return $user->id === $prescription->user_id || $user->isPharmacy();
    }

    public function createQuotation(User $user, Prescription $prescription)
    {
        return $user->isPharmacy() && !$prescription->quotations()->where('pharmacy_id', $user->id)->exists();
    }
}