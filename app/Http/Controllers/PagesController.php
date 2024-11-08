<?php

namespace App\Http\Controllers;

use App\Models\DepartemenModel;
use App\Models\DokterModel;
use App\Models\PasienModel;
use App\Models\RekamPasienModel;

class PagesController
{

    public function base(){
        return view('dashboard.v_dash');
    }
    // =============================================== //

    public function dokter(){
        $ShowDoctor = DokterModel::all();
        $showDepartemen = DepartemenModel::all();
        return view('manageDokter.ParameterDokter.v_dokter', compact('ShowDoctor','showDepartemen'));
    }
    public function departemen(){

        $ShowDepartemen = DepartemenModel::all();
        return view('manageDokter.parameterDokter.v_parameter', compact('ShowDepartemen'));
    }
    public function pasien(){
        $departemenList = DepartemenModel::all();
        $ShowPatien = PasienModel::with('dokter')->get();
        return view('manageDokter.v_pasien', compact('ShowPatien','departemenList'));
    }

    public function riwayatPasien(){
        // $ShowRekam = RekamPasienModel::all();
        $ShowRekam = RekamPasienModel::whereHas('pasien', function ($query) {
            $query->whereDate('tgl_periksa', today());
        })->get();
        $patientCount = $ShowRekam->count();
      

        return view('manageDokter.v_rekampasien', compact('ShowRekam', 'patientCount'));
    }

    public function updateRiwayat(){

        return view('manageDokter.c_rekampasien');
    }



}
