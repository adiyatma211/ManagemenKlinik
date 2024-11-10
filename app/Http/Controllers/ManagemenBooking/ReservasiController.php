<?php

namespace App\Http\Controllers\ManagemenBooking;


use App\Models\PasienModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\RekamPasienModel;

class ReservasiController extends Controller
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
    public function saveOrUpdatePatient(Request $request)
{
    $data = $request->all();
    // dd($data);
    // Cek jika `no_rm` ada di dalam data request
    if (!empty($data['no_rm'])) {
        // Cari pasien berdasarkan `no_rm`
        $patient = PasienModel::where('no_rm', $data['no_rm'])->first();
    } else {
        $patient = null;
    }

    if ($patient) {
        // Update data pasien jika ditemukan
        $patient->update([
            'nama_pasien' => $data['nama_pasien'],
            'alamat' => $data['alamat'],
            'jenis_kelamin' => $data['jenis_kelamin'],
            'no_telp' => $data['telepon'],
            'tgllahir' => $data['tgllahir'],
            'umur' => $data['umur'],
            'departemen' => $data['departemen'],
            'daftarDokterId' => $data['daftarDokterId'],
            'tgl_periksa' => $data['tgl_periksa']
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Patient record updated successfully.',
            'patient' => $patient
        ]);
    } else {
        // Insert data baru jika tidak ditemukan `no_rm`
        $patient = PasienModel::create([
            'nama_pasien' => $data['nama_pasien'],
            'alamat' => $data['alamat'],
            'jenis_kelamin' => $data['jenis_kelamin'],
            'no_telp' => $data['telepon'],
            'tgllahir' => $data['tgllahir'],
            'umur' => $data['umur'],
            'departemen' => $data['departemen'],
            'daftarDokterId' => $data['daftarDokterId'],
            'tgl_periksa' => $data['tgl_periksa']
        ]);

        return response()->json([
            'success' => true,
            'message' => 'New patient record created successfully.',
            'patient' => $patient
        ]);
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($no_rm)
{
    // Find the patient by `no_rm`
    $patient = PasienModel::where('no_rm', $no_rm)->first();

    if ($patient) {
        // Delete the patient record
        $patient->delete();

        return response()->json([
            'success' => true,
            'message' => 'Patient record deleted successfully.'
        ]);
    } else {
        return response()->json([
            'success' => false,
            'message' => 'Patient not found.'
        ]);
    }
}

    public function getPatientByNoRm($no_rm)
    {
        $patient = PasienModel::where('no_rm', $no_rm)->first();

        if ($patient) {
            return response()->json([
                'success' => true,
                'patient' => $patient,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Patient not found.'
            ]);
        }
    }



public function konfirmasi($no_rm)
{
    try {
        // Find the patient record based on no_rm
        $patient = PasienModel::where('no_rm', $no_rm)->first();

        if (!$patient) {
            return response()->json([
                'success' => false,
                'message' => 'Patient not found.'
            ], 404);
        }

        // Update the RekamPasien table
        RekamPasienModel::updateOrCreate(
            ['pasienId' => $patient->no_rm], // Condition to check if a record exists
            ['dokterId' => $patient->daftarDokterId] // Fields to update
        );

        // Update the PasienModel to set konfirmasi to 1
        $patient->update(['konfirmasi' => 1]);

        return response()->json([
            'success' => true,
            'message' => 'Confirmation successful.',
        ]);

    } catch (\Throwable $th) {
        // Handle any exception
        return response()->json([
            'success' => false,
            'message' => 'An error occurred during confirmation.',
            'error' => $th->getMessage()
        ], 500);
    }
}


}
