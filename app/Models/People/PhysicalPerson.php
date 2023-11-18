<?php

namespace App\Models\People;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhysicalPerson extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'birth_date',
        'email',
        'cpf',
        'rg',
        'telephone',
        'cep',
        'public_place',
        'nr_public_place',
        'city',
        'state',
        'create_user',
        'update_user'
    ];
}
