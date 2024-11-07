<?php

namespace App\Http\Controllers;

use App\Models\PasienModel;

class PagesController
{

    public function base(){
        return view('dashboard.v_dash');
    }
    // =============================================== //


    public function pasien(){
        $ShowPatien = PasienModel::all();

        return view('manageDokter.v_pasien', compact('ShowPatien'));

    }

}
