<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'note', 'delivery_address', 'delivery_time', 'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function images()
    {
        return $this->hasMany(PrescriptionImage::class);
    }

    public function quotations()
    {
        return $this->hasMany(Quotation::class);
    }

    public function quotation()
    {
        return $this->hasOne(Quotation::class);
    }
}