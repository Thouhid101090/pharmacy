<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
        'medicine_id',
        'quantity',
    ];

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }

    // Increase stock when purchase happens
    public static function increaseStock($medicine_id, $qty)
    {
        $stock = self::firstOrCreate(
            ['medicine_id' => $medicine_id],
            ['quantity' => 0]
        );

        $stock->quantity += $qty;
        $stock->save();
    }

    // Decrease stock when sale happens
    public static function decreaseStock($medicine_id, $qty)
    {
        $stock = self::where('medicine_id', $medicine_id)->first();

        if (!$stock || $stock->quantity < $qty) {
            throw new \Exception('Insufficient stock for this sale');
        }

        $stock->quantity -= $qty;
        $stock->save();
    }
}
