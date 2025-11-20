<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_no',
        'medicine_id',
        'quantity',
        'selling_price',
        'total_price',
    ];

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
    // Get latest purchase price
public function getPurchasePriceAttribute()
{
    $purchase = \App\Models\Purchase::where('medicine_id', $this->medicine_id)
                ->orderBy('id', 'desc')
                ->first();

    return $purchase ? $purchase->price : 0;
}

// Profit = (selling_price - purchase_price) * quantity
public function getProfitAttribute()
{
    return ($this->selling_price - $this->purchase_price) * $this->quantity;
}
}
