<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClaveDinamica extends Model
{
    protected $table= 'clavedinamica';

    protected $primaryKey='id';

    public $timestamps=false;

    protected $fillable =[
        'clave',
        'accion',
        'dispositivo',
        'creacion',
        'utilizacion',
        'responsable',
        'users_id'
    ];
}
