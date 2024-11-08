<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterRekamPasien extends Model
{
    protected $guarded=['id'];

    
    public function dokter(){
        return $this->belongsTo(DokterModel::class, 'dokterId');
    }
    public function pasien(){
        return $this->belongsTo(PasienModel::class,'pasienId');
    }
    
}
