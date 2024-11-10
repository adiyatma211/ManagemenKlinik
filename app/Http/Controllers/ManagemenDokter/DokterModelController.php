<?php

namespace App\Http\Controllers\ManagemenDokter;

use App\Models\DokterModel;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DokterModelController extends Controller
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
             // Create new doctor entry
             $dokter = new DokterModel();
             $dokter->nama_dokter = $request->nama_dokter;
             $dokter->jenis_kelamin = $request->jenis_kelamin;
             $dokter->tanggal_masuk = $request->tanggal_masuk;
             $dokter->departemenId = $request->departemenId;
             $dokter->jadwalId = $request->jadwalId;
             $dokter->status = $request->status;
             $dokter->createdBy = Auth::user()->name;
             $dokter->save();
     
             // Generate email and password for the user
             $name = $request->nama_dokter;
     
             // Remove "dr" prefix if it exists
             $nameWithoutPrefix = preg_replace('/^dr\s*/i', '', $name);
             
             // Get the first part of the name to create the email
             $nameParts = explode(' ', $nameWithoutPrefix);
             $firstName = strtolower($nameParts[0]); // Take the first name and make it lowercase
             $email = $firstName . '@gmail.com';
             $password = '12345678';
     
             // Create a new user entry in the User model
             $user = new User();
             $user->name = $request->nama_dokter;
             $user->email = $email;
             $user->password = Hash::make($password); // Hash the password
             $user->role = 'dokter'; // Assign the role as "dokter"
             $user->save();
     
             return response()->json([
                 'success' => true,
                 'message' => 'Data Dokter berhasil diperbarui',
                 'data' => $dokter,
                 'user' => $user
             ]);
         } catch (\Exception $e) {
             return response()->json([
                 'success' => false,
                 'message' => 'Error adding doctor.',
                 'error' => $e->getMessage()
             ]);
         }
     }
     


    /**
     * Display the specified resource.
     */
    public function show(DokterModel $dokterModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $dokter = DokterModel::findOrFail($id);

            return response()->json(['success' => true,
                'message' => 'Data pasien berhasil Diambil',
                'data' => $dokter]);
        } catch (\Exception $e) {
            return response()->json(['success' => false,
            'message' => 'Terjadi kesalahan saat data tidak ada',
            'error' => $e->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $dokter = DokterModel::findOrFail($id);
            $dokter->nama_dokter = $request->nama_dokter;
            $dokter->jenis_kelamin = $request->jenis_kelamin;
            $dokter->tanggal_masuk = $request->tanggal_masuk;
            $dokter->departemenId = $request->departemenId;
            $dokter->status = $request->status;
            $dokter->jadwalId = $request->jadwalId;
            $dokter->createdBy = Auth::user()->name;
            $dokter->save();

            return response()->json(['success' => true,
                'message' => 'Data Dokter berhasil diperbarui',
                'data' => $dokter]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error updating doctor.', 'error' => $e->getMessage()]);
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $dokter = DokterModel::findOrFail($id);
            $dokter->delete();

            return response()->json(['success' => true, 'message' => 'Dokter berhasil dihapus.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error deleting doctor.', 'error' => $e->getMessage()]);
        }
    }
}
