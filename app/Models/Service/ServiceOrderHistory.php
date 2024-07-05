<?php

namespace App\Models\Service;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceOrderHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_type_history',
        'ds_type_history',
        'history',
        'dt_creation',
        'dt_release',
        'id_physical_person',
        'create_user',
        'update_user',
        'id_service_order'
    ];
}
