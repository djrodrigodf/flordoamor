<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    use HasFactory, Auditable;

    protected $fillable = [
        'invoice_id',
        'product_id',
        'quantity',
        'price',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Setter para o campo `unit_price` (removendo formato antes de salvar).
     */
    public function setPriceAttribute($value)
    {
        $this->attributes['price'] = str_replace(['.', ','], ['', '.'], $value);
    }
}
