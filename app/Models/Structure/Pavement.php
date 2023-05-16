<?php

namespace App\Models\Structure;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pavement extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'status'
    ];
}
