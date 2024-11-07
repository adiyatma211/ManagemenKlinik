<?php

namespace App\Http\Controllers\ManagemenDokter;
use App\Models\PasienModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PasienModelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

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
                'umur' => $request->umur,
                'tgl_masuk' => $request->tgl_masuk,
                'tgl_periksa' => $request->tgl_periksa,
                'departemen' => $request->departemen,
                'daftarDokter' => $request->daftarDokter,
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
    public function show(PasienModel $pasienModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($no_rm)
    {
        $patient = PasienModel::findOrFail($no_rm);

        if ($patient) {
            return response()->json([
                'success' => true,
                'patient' => $patient,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data pasien tidak ditemukan',
            ], 404);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $no_rm)
    {
        // Find the patient by their primary key, no_rm
        $patient = PasienModel::findOrFail($no_rm);


        // Check if the patient exists
        if (!$patient) {
            return response()->json([
                'success' => false,
                'message' => 'Data pasien tidak ditemukan',
                'data' => null,
            ], 404);
        }

        try {
            // Update the patient's data
            $patient->update([
                'nama_pasien' => $request->nama_pasien,
                'alamat' => $request->alamat_pasien,
                'jenis_kelamin' => $request->jenis_kelamin_pasien,
                'no_telp' => $request->telepon,
                'tgllahir' => $request->tgllahir,
                'umur' => $request->umur,
                'tgl_masuk' => $request->tgl_masuk,
                'tgl_periksa' => $request->tgl_periksa,
                'departemen' => $request->departemen,
                'daftarDokter' => $request->daftarDokter,
                'updatedBy' => Auth::user()->name,
            ]);

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
    public function destroy($no_rm)
    {
        try {
            $patient = PasienModel::findOrFail($no_rm);
            // Check if the patient exists
            if (!$patient) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data pasien tidak ditemukan',
                    'data' => null,
                ], 404);
            }

            // Delete the patient record
            $patient->delete();

            // Return a success response
            return response()->json([
                'success' => true,
                'message' => 'Data pasien berhasil dihapus',
            ], 200);

        } catch (\Exception $e) {
            // Handle any exceptions that occur during deletion
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus data pasien',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

}
