<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'address', 'contact_no', 'dob', 'user_type'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'dob' => 'date',
    ];

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }

    public function quotations()
    {
        return $this->hasMany(Quotation::class, 'pharmacy_id');
    }

    public function isPharmacy()
    {
        return $this->user_type === 'pharmacy';
    }

    public function isUser()
    {
        return $this->user_type === 'user';
    }
}