<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoryPasienPeriksa extends Model
{
    protected $guarded=['id'];

    public function dokter(){
        return $this->belongsTo(DokterModel::class, 'dokter_id');
    }
    public function pasien(){
        return $this->belongsTo(PasienModel::class,'no_rm');
    }
    public function departemen()
    {
        return $this->belongsTo(DepartemenModel::class, 'departemen');
    }

   
}
