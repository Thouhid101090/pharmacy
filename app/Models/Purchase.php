<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'medicine_id',
        'invoice_no',
        'supplier_name',
        // 'purchase_date',
        'quantity',
        'price',
        'total_amount',
        'expiry_date',
    ];

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
}
