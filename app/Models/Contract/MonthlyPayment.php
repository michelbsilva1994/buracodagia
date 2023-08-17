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
        'total_payable',
        'id_contract'
    ];

    public function contract(){
        return $this->hasMany(Contract::class, 'id_contract', 'id_contract');
    }
}
