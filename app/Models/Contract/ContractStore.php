<?php

namespace App\Models\Contract;

use App\Models\Structure\Store;
use App\Models\Contract\Contract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractStore extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_store',
        'id_contract',
        'store_price'
    ];

    public function store(){
        return $this->hasMany(Store::class, 'id_store', 'id');
    }

    public function contract(){
        return $this->hasMany(Contract::class, 'id_contract', 'id');
    }
}
