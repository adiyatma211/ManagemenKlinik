<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasienModel extends Model
{
    protected $primaryKey = 'no_rm'; // Set no_rm as the primary key
    protected $guarded = ['no_rm']; // Prevent mass assignment of no_rm

    public function dokter(){
        return $this->belongsTo(DokterModel::class, 'daftarDokterId' );
    }
}
