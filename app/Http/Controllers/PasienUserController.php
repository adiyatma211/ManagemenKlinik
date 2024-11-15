<?php

namespace App\Http\Controllers;

use App\Models\PasienModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PasienUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $patient = PasienModel::create([
                'nama_pasien' => $request->nama_pasien,
                'alamat' => $request->alamat_pasien,
                'jenis_kelamin' => $request->jenis_kelamin_pasien,
                'no_telp' => $request->telepon,
                'tgllahir' => $request->tgllahir,     
                'tgl_periksa' => $request->tgl_periksa,
                'departemen' => $request->departemen, // Menggunakan `departemen`
                'daftarDokterId' => $request->daftarDokterId, // Menggunakan `daftarDokterId`
                'createdBy' => Auth::user()->name,
            ]);
        
            return response()->json([
                'success' => true,
                'message' => 'Data pasien berhasil disimpan',
                'data' => $patient,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan data pasien',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $no_rm)
    {
        $patient = PasienModel::findOrFail($no_rm);

        if (!$patient) {
            return response()->json([
                'success' => false,
                'message' => 'Data pasien tidak ditemukan',
            ], 404);
        }

        try {
            $patient->update([
                'nama_pasien' => $request->nama_pasien,
                'alamat' => $request->alamat_pasien,
                'jenis_kelamin' => $request->jenis_kelamin_pasien,
                'no_telp' => $request->telepon,
                'tgllahir' => $request->tgllahir,
                'umur' => $request->umur,
                'tgl_masuk' => $request->tgl_masuk,
                'tgl_periksa' => $request->tgl_periksa,
                'departemen' => $request->departemen, // Menggunakan `departemen`
                'daftarDokterId' => $request->daftarDokterId, // Menggunakan `daftarDokterId`
            ]);

            // dd($patient);
            return response()->json([
                'success' => true,
                'message' => 'Data pasien berhasil diperbarui',
                'data' => $patient,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui data pasien',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
