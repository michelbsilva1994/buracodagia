<?php

namespace App\Models\Tution;

use App\Models\Contract\MonthlyPayment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LowerMonthlyFee extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount_paid',
        'id_type_payment',
        'type_payment',
        'id_chargeback_low',
        'chargeback_low',
        'dt_payday',
        'dt_chargeback',
        'download_user',
        'chargeback_user',
        'id_monthly_payment'
    ];

    public function monthly_payment(){
        return $this->belongsTo(MonthlyPayment::class, 'id_monthly_payment', 'id');
    }
}
