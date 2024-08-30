<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_code',
        'transaction_date',
        'customer_name',
        'total_amount',
        'payment_id',
        'user_id'
    ];

    public function transactionProducts()
    {
        return $this->hasMany(TransactionProduct::class, 'transaction_code_product', 'transaction_code');
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
