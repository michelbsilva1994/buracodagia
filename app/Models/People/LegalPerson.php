<?php

namespace App\Models\People;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LegalPerson extends Model
{
    use HasFactory;

    protected $fillable = [
        'corporate_name',
        'fantasy_name',
        'email',
        'telephone',
        'cnpj',
        'cep',
        'public_place',
        'nr_public_place',
        'city',
        'state'
    ];
}
