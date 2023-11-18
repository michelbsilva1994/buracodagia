<?php

namespace App\Models\Contract;

use App\Models\People\LegalPerson;
use App\Models\People\PhysicalPerson;
use App\Models\Contract\MonthlyPayment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = [
        'type_person',
        'type_contract',
        'cpf',
        'cnpj',
        'name_contractor',
        'dt_contraction',
        'dt_renovation',
        'dt_finalization',
        'dt_cancellation',
        'dt_signature',
        'id_physical_person',
        'id_legal_person',
        'ds_cancellation_reason',
        'create_user',
        'update_user'
    ];

    public function physicalPerson(){
       return $this->belongsTo(PhysicalPerson::class, 'id_physical_person', 'id');
    }

    public function LegalPerson(){
        return $this->belongsTo(LegalPerson::class, 'id_legal_person', 'id');
    }
}
