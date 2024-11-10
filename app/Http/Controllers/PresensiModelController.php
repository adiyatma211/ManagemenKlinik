<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PresensiModel;
use Illuminate\Support\Facades\Auth;

class PresensiModelController extends Controller
{
    // Display the attendance view with a list of records
    public function index()
    {
        $presensiRecords = PresensiModel::where('user_id', Auth::id())->get();
        return view('managePresensi.v_appPresensi', compact('presensiRecords'));
    }

    // Mark entry time
    public function masuk(Request $request)
    {
        PresensiModel::create([
            'user_id' => Auth::id(),
            'masuk' => now(),
        ]);

        return redirect()->route('presensi.index')->with('success', 'Presensi Masuk berhasil!');
    }

    // Mark exit time
    public function keluar(Request $request)
    {
        $presensi = PresensiModel::where('user_id', Auth::id())
            ->whereNull('keluar')
            ->latest('masuk')
            ->first();

        if ($presensi) {
            $presensi->update(['keluar' => now()]);
            return redirect()->route('presensi.index')->with('success', 'Presensi Keluar berhasil!');
        }

        return redirect()->route('presensi.index')->with('error', 'Presensi Masuk belum dilakukan!');
    }
}