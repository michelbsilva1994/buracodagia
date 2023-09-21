<?php

namespace App\Models\Contract;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'due_date',
        'dt_payday',
        'dt_cancellation',
        'fine_value',
        'interest_amount',
        'discount_value',
        'total_payable',
        'id_type_payment',
        'type_payment',
        'id_contract',
        'id_type_cancellation',
        'type_cancellation'
    ];

    public function contract(){
        return $this->belongsTo(Contract::class, 'id_contract', 'id');
    }
}
