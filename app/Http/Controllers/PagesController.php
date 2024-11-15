<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Schadule;
use App\Models\DokterModel;
use App\Models\PasienModel;
use Illuminate\Http\Request;
use App\Models\DepartemenModel;
use App\Models\InventarisModel;
use App\Models\RekamPasienModel;
use App\Models\MasterRekamPasien;
use Illuminate\Support\Facades\DB;
use App\Models\HistoryPasienPeriksa;

class PagesController
{

    public function base(){
        $showDokter = DokterModel::count();
        $showPasien = PasienModel::count();
        $showHistory = HistoryPasienPeriksa::count();
        $countUsersAdminAndSuster = User::whereIn('role', ['admin', 'suster'])->count();
        $total = $showDokter+$countUsersAdminAndSuster;
        $visitsData = HistoryPasienPeriksa::select(
            DB::raw("MONTH(tanggal_periksa) as month"),
            DB::raw("COUNT(*) as count")
        )
        ->groupBy('month')
        ->orderBy('month')
        ->get();
        return view('dashboard.v_dash',compact('visitsData','showDokter','showPasien','showHistory','total'));
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

    public function historyPasienUser(){

        $showHistory = HistoryPasienPeriksa::all();
        return view('manageDokter.v_history',compact('showHistory'));
    }   
 

   
}
