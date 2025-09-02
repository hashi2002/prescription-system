<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrescriptionImage extends Model
{
    use HasFactory;

    protected $fillable = ['prescription_id', 'image_path'];

    public function prescription()
    {
        return $this->belongsTo(Prescription::class);
    }
}