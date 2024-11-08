<?php

namespace App\Http\Controllers\ManagemenDokter;

use App\Http\Controllers\Controller;
use App\Models\DepartemenModel;
use App\Models\DokterModel;
use Illuminate\Http\Request;

class DepartemenModelController extends Controller
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
            $departemen = new DepartemenModel();
            $departemen->nama_departemen = $request->nama_departemen;
            $departemen->keterangan_departemen = $request->keterangan_departemen;
            $departemen->save();

            return response()->json([
                'success' => true,
                'message' => 'Data departemen berhasil ditambahkan',
                'data' => $departemen,
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menambahkan data departemen',
                'error' => $th->getMessage(),
            ], 500);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(DepartemenModel $departemenModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
{
    $dokter = DokterModel::with('departemen')->find($id);

    if ($dokter) {
        return response()->json([
            'success' => true,
            'dokter' => $dokter
        ]);
    } else {
        return response()->json([
            'success' => false,
            'message' => 'Dokter tidak ditemukan.'
        ]);
    }
}


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $departemen = DepartemenModel::findOrFail($id);
            $departemen->nama_departemen = $request->nama_departemen;
            $departemen->keterangan_departemen = $request->keterangan_departemen;
            $departemen->save();

            return response()->json([
                'success' => true,
                'message' => 'Departemen berhasil diperbarui.',
                'data' => $departemen,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui departemen.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $departemen = DepartemenModel::findOrFail($id);
            $departemen->delete();

            return response()->json([
                'success' => true,
                'message' => 'Departemen berhasil dihapus.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus departemen.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
