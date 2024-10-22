<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    use HasFactory, Auditable;

    protected $fillable = [
        'invoice_id',
        'shipping_cost',
        'tracking_number',
        'carrier',
        'status',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

}
