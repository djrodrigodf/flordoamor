<?php

namespace App\Models;

use App\Traits\Auditable;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use Auditable, HasFactory;

    public $table = 'products';

    public static $searchable = [
        'name',
        'category',
        'size',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'description',
        'category',
        'size',
        'stock_quantity',
        'unit_price',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * Função para serializar datas corretamente no formato esperado.
     */
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    /**
     * Getter para o campo `unit_price` (formatando para duas casas decimais).
     */
    public function getUnitPriceAttribute($value)
    {
        return number_format($value, 2, ',', '.');
    }

    /**
     * Setter para o campo `unit_price` (removendo formato antes de salvar).
     */
    public function setUnitPriceAttribute($value)
    {
        $this->attributes['unit_price'] = str_replace(['.', ','], ['', '.'], $value);
    }

    /**
     * Getter para o campo `stock_quantity` (retorna como um número inteiro).
     */
    public function getStockQuantityAttribute($value)
    {
        return intval($value);
    }
}
