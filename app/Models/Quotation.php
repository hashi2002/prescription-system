<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    use HasFactory;

    protected $fillable = [
        'prescription_id', 'pharmacy_id', 'total_amount', 'status'
    ];

    protected $casts = [
        'total_amount' => 'decimal:2'
    ];

    public function prescription()
    {
        return $this->belongsTo(Prescription::class);
    }

    public function pharmacy()
    {
        return $this->belongsTo(User::class, 'pharmacy_id');
    }

    public function items()
    {
        return $this->hasMany(QuotationItem::class);
    }
}