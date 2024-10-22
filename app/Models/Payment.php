<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory, Auditable;

    protected $fillable = [
        'invoice_id',
        'payment_method',
        'amount',
        'status',
    ];

    /**
     * Relacionamento com Invoice (fatura).
     */
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
