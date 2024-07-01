<?php

namespace App\Models\Service;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_physical_person',
        'id_store',
        'id_pavement',
        'id_equipment',
        'title',
        'description',
        'contact',
        'dt_opening',
        'dt_process',
        'dt_service',
        'id_status',
        'id_physcal_person_executor',
        'create_user',
        'update_user'
    ];
}
