<?php
namespace App\Policies;

use App\Models\Quotation;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class QuotationPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Quotation $quotation)
    {
        return $user->id === $quotation->prescription->user_id || $user->id === $quotation->pharmacy_id;
    }

    public function respond(User $user, Quotation $quotation)
    {
        return $user->id === $quotation->prescription->user_id && $quotation->status === 'sent';
    }
}