<?php

namespace App\Models\Domain;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeContract extends Model
{
    use HasFactory;

    protected $fillable = [
        'value',
        'description',
        'status'
    ];
}
