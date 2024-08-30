<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_code_product',
        'product_id',
        'quantity',
        'unit_price',
        'total_price'
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_code', 'transaction_code_product');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
