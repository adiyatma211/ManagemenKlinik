<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestimoniPasien extends Model
{
    protected $guarded=['id'];


    public function pasien()
    {
        return $this->belongsTo(PasienModel::class, 'no_rm');
    }
}
