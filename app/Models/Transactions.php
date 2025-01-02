<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transactions extends Model
{
    protected $fillable = [
        'services_id',
        'item_id',
        'quantity',
        'subtotal',
        'price',
    ];
    
    public function item()
    {
        return $this->belongsTo(Items::class, 'item_id');
    }

    public function services()
    {
        return $this->belongsTo(Services::class, 'services_id', 'services_id');
    }
    // Optional: Mutator untuk menghitung subtotal otomatis
    public function setQuantityAttribute($value)
    {
        $this->attributes['quantity'] = $value;
        $this->attributes['subtotal'] = $value * $this->item->price;
    }
}