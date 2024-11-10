<?php
namespace App\Http\Controllers\ManagemenDokter;

use Illuminate\Http\Request;
use App\Models\RekamPasienModel;
use App\Models\MasterRekamPasien;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RekamPasienController extends Controller
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
        $request->validate([
            'keluhan' => 'required|string',
            'diagnoosa' => 'required|string',
            'obat' => 'required|string',
        ]);
        try {
            $patient = RekamPasienModel::create([
                'keluhan' => $request->input('keluhan'),
                'diagnoosa' => $request->input('diagnoosa'),
                'obat' => $request->input('obat'),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data pasien berhasil disimpan.',
                'data' => $patient
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan data pasien: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function selesaiPasien($id, Request $request)
    {
        try {
            // Find the RekamPasienModel record by primary key id
            $rekam = RekamPasienModel::findOrFail($id);
            
            $department = $rekam->dokter->departemen;
            
            // Calculate biaya
            $base_fee = $department->biaya ?? 0;
            $obat_fee = 100000;
            $tindakan_fee = 100000;
            $total_biaya = $base_fee + $obat_fee + $tindakan_fee;
        
            // Save data in MasterRekamPasien
            $masterRekam = new MasterRekamPasien();
            $masterRekam->rekamId = $rekam->id;
            $masterRekam->biaya = $total_biaya;
            $masterRekam->createdBy = Auth::user()->id;
            $masterRekam->save();
        
            // Mark as completed in RekamPasienModel
            $rekam->completed = true;
            $rekam->save();
        
            return response()->json(['success' => true, 'message' => 'Data berhasil disimpan dan pasien ditandai selesai']);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan data: ' . $e->getMessage(),
                'error' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            // Retrieve the patient record by ID
            $patient = RekamPasienModel::findOrFail($id);
    
            // Return the view with the patient data
            return view('manageDokter.c_rekampasien', compact('patient'));
        } catch (\Exception $e) {
            // Handle the error (optional: you can return to a previous page with an error message)
            return redirect()->route('patients.index')->with('error', 'Terjadi kesalahan saat mengakses data pasien: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'keluhan' => 'required|string',
            'diagnoosa' => 'required|string',
            'tindakan' => 'required|string',
            'obat' => 'required|string',
        ]);
        try {
            $patient = RekamPasienModel::findOrFail($id);
            $patient->update([
                'keluhan' => $request->input('keluhan'),
                'diagnoosa' => $request->input('diagnoosa'),
                'tindakan' => $request->input('tindakan'),
                'obat' => $request->input('obat'),
            ]);

            return redirect()->route('view.riwayat')->with('success', 'Data pasien berhasil diperbarui.');
    
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui data pasien: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $patient = RekamPasienModel::findOrFail($id);
            $patient->delete();

            return response()->json([
                'success' => true,
                'message' => 'Data pasien berhasil dihapus.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus data pasien: ' . $e->getMessage()
            ], 500);
        }
    }
}
