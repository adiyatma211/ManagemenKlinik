<?php

namespace App\Models;

use App\Models\DokterModel;
use App\Models\PasienModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RekamPasienModel extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function dokter(){
        return $this->belongsTo(DokterModel::class, 'dokterId');
    }
    public function pasien(){
        return $this->belongsTo(PasienModel::class,'pasienId');
    }
}
