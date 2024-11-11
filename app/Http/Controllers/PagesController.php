<?php

namespace App\Http\Controllers;

use App\Models\Schadule;
use App\Models\DokterModel;
use App\Models\PasienModel;
use Illuminate\Http\Request;
use App\Models\DepartemenModel;
use App\Models\InventarisModel;
use App\Models\RekamPasienModel;
use App\Models\MasterRekamPasien;

class PagesController
{

    public function base(){
        return view('dashboard.v_dash');
    }
    // =============================================== //

    public function dokter(){
        $ShowDoctor = DokterModel::all();
        $showDepartemen = DepartemenModel::all();
        $schedule = Schadule::all();
        return view('manageDokter.ParameterDokter.v_dokter', compact('ShowDoctor','showDepartemen','schedule'));
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
    // Booking


    public function jadwalDokter(){
        $departemenList = DepartemenModel::all();
        $showDokter = DokterModel::all();
        $schedules = Schadule::all();
        // dd($schedules);
        return view('manageBooking.v_jadwalDokter',compact('departemenList','showDokter','schedules'));
    }

    public function reservasiPasien(){
        $ShowPatien = PasienModel::with('dokter')->get();
        $departemenList = DepartemenModel::all();
        $showDokter = DokterModel::all();
        $schedules = Schadule::all();
        // dd($schedules);
        return view('manageBooking.v_reservasi',compact('departemenList','showDokter','schedules','ShowPatien'));
    }


    public function konfirmKehadiran(){
        $ShowPatien = PasienModel::with('dokter')->get();
        $departemenList = DepartemenModel::all();
        $showDokter = DokterModel::all();
        $schedules = Schadule::all();
        return view('manageBooking.v_konfirmKehadiran',compact('departemenList','showDokter','schedules','ShowPatien'));
    }

    // Pasien
    public function pasienNota(){
        $showNota = MasterRekamPasien::all();
        $ShowPatien = PasienModel::with('dokter')->get();
        $departemenList = DepartemenModel::all();
        $showDokter = DokterModel::all();
        $schedules = Schadule::all();
        return view('managemenPasien.v_nota',compact('departemenList','showDokter','schedules','ShowPatien','showNota'));
    }

    public function report(){
        $inventaris = InventarisModel::all();
        return view('manageInventaris.v_reportAlatMedis', compact('inventaris'));
    }

    // USER LANDING PAGE

    public function pasienLanding(){
        $showNota = MasterRekamPasien::all();
        $ShowPatien = PasienModel::with('dokter')->get();
        $departemenList = DepartemenModel::all();
        $showDokter = DokterModel::all();
        $schedules = Schadule::all();
        // $departemenListBiaya =DepartemenModel::first();
        return view('layouts.lpBase',compact('departemenList','showDokter','schedules','ShowPatien','showNota'));
    }
    public function checkNoRm(Request $request)
{
    // Validate that 'no_rm' is provided
    $request->validate([
        'no_rm' => 'required|string'
    ]);

    // Retrieve the 'no_rm' from the request
    $no_rm = $request->no_rm;

    // Check if a patient with this 'no_rm' exists
    $patient = PasienModel::where('no_rm', $no_rm)->first();

    if ($patient) {
        // If the patient exists, return a response indicating the record exists with patient data
        return response()->json([
            'exists' => true,
            'message' => 'Patient record found',
            'data' => $patient
        ]);
    } else {
        // If no patient record is found, return a response indicating it does not exist
        return response()->json([
            'exists' => false,
            'message' => 'No patient record found with this medical record number'
        ]);
    }
}


}
