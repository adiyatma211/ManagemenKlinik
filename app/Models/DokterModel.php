<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DokterModel extends Model
{
    protected $guarded=['id'];

    public function departemen()
    {
        return $this->belongsTo(DepartemenModel::class, 'departemenId');
    }


}
