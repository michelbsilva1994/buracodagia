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
        'amount_paid',
        'balance_value',
        'id_monthly_status',
        'monthly_status',
        'id_type_cancellation',
        'type_cancellation',
        'download_user',
        'cancellation_user',
        'id_contract',
    ];

    public function contract(){
        return $this->belongsTo(Contract::class, 'id_contract', 'id');
    }
}
