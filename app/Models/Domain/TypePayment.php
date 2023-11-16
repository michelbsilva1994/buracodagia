<?php

namespace App\Models\Domain;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypePayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'value',
        'description',
        'status',
        'create_user',
        'update_user'
    ];
}
