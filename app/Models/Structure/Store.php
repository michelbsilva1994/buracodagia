<?php

namespace App\Models\Structure;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'status',
        'type',
        'description',
        'id_pavement',
        'create_user',
        'update_user'
    ];

    public function pavement(){
        return $this->belongsTo(Pavement::class, 'id_pavement', 'id');
    }
}
