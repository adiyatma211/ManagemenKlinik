<?php

namespace App\Http\Controllers;

use App\Models\DokterModel;
use App\Models\PasienModel;
use Illuminate\Http\Request;
use App\Models\DepartemenModel;
use App\Models\TestimoniPasien;
use Illuminate\Support\Facades\DB;
use App\Models\HistoryPasienPeriksa;
use Illuminate\Support\Facades\Validator;

class UserLandingPageController extends Controller
{
    public function UserHome(){
        $testimonials = TestimoniPasien::all(); // Fetch all testimonials
        $showDokter = DokterModel::all();
        $departemenList = DepartemenModel::all();
        return view('pasienLanding.formUser',compact('showDokter','departemenList','testimonials'));
    }


    public function getDoctorsByDepartmentUser($departemenId)
    {
        $doctors = DokterModel::where('departemenId', $departemenId)->get(['id', 'nama_dokter']);
        return response()->json($doctors);
    }

    public function edit($no_rm)
    {
        try {
            $patient = PasienModel::findOrFail($no_rm);
            return response()->json([
                'success' => true,
                'patient' => $patient,
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data pasien tidak ditemukan',
            ], 404);
            }
    }

    public function update(Request $request, $no_rm)
    {
        $patient = PasienModel::findOrFail($no_rm);
    
        // Daftar field yang perlu dicek
        $fieldsToCheck = [
            'nama_pasien' => 'nama_pasien',
            'alamat_pasien' => 'alamat_pasien',
            'telepon' => 'no_telp',
            'tgllahir' => 'tgllahir',
            'umur' => 'umur',
            'tgl_periksa' => 'tgl_masuk',
            'departemen' => 'departemen',
            'daftarDokterId' => 'daftarDokterId'
        ];
    
        // Ambil data dari request berdasarkan field yang perlu dicek
        $requestData = $request->only(array_keys($fieldsToCheck));
    
        // Ambil data dari database berdasarkan field yang perlu dicek
        $dbData = $patient->only(array_values($fieldsToCheck));
    
        // Bandingkan data request dengan data database
        $dataUpdate = [];
        foreach ($fieldsToCheck as $requestField => $dbField) {
            if ($requestData[$requestField] !== $dbData[$dbField]) {
                $dataUpdate[$dbField] = $requestData[$requestField];
            }
        }
    
        // Lakukan update jika ada data yang berubah
        if (!empty($dataUpdate)) {
            $patient->update($dataUpdate);
    
            // Insert ke tabel HistoryPasienPeriksa setelah update berhasil
            HistoryPasienPeriksa::create([
                'no_rm' => $patient->no_rm,
                'tanggal_periksa' => $request->tgl_periksa,
                'departemen' => $request->departemen,
                'dokter_id' => $request->daftarDokterId,
                'catatan' => $request->catatan ?? null // Catatan dapat diisi jika ada input catatan, atau null jika tidak ada
            ]);
    
            // Ambil data terbaru pasien setelah update
            $updatedPatient = PasienModel::find($no_rm);
    
            return response()->json([
                'success' => true,
                'message' => 'Data pasien berhasil diupdate dan riwayat pemeriksaan dicatat.',
                'data' => $updatedPatient,
            ]);
        }
    
        return response()->json([
            'success' => true,
            'message' => 'Tidak ada perubahan pada data pasien.',
            'data' => $patient,
        ]);
    }

    public function store(Request $request)
{
    // Validasi data request
    $request->validate([
        'nama_pasien' => 'required|string|max:255',
        'alamat' => 'required|string',
        'telepon' => 'required|string',
        'tgllahir' => 'required|date',
        'umur' => 'required|integer',
        'tgl_periksa' => 'required|date',
        'departemen' => 'required|string',
        'dokter_id' => 'required|exists:dokter_models,id',
        'jenis_kelamin' => 'required|in:Laki-Laki,Perempuan' // Tambahkan validasi jenis_kelamin
    ]);

    try {
        // Mulai transaksi database
        DB::beginTransaction();

        // Buat data pasien baru
        $patient = PasienModel::create([
            'nama_pasien' => $request->nama_pasien,
            'alamat' => $request->alamat,
            'no_telp' => $request->telepon,
            'tgllahir' => $request->tgllahir,
            'umur' => $request->umur,
            'tgl_masuk' => $request->tgl_periksa,
            'tgl_periksa' => $request->tgl_periksa,
            'departemen' => $request->departemen,
            'daftarDokterId' => $request->dokter_id,
            'jenis_kelamin' => $request->jenis_kelamin // Tambahkan jenis_kelamin
        ]);
        // dd($patient);
        // Masukkan ke tabel HistoryPasienPeriksa
        HistoryPasienPeriksa::create([
            'no_rm' => $patient->no_rm,
            'tanggal_periksa' => $request->tgl_periksa,
            'departemen' => $request->departemen,
            'dokter_id' => $request->dokter_id,
            'catatan' => $request->catatan ?? null
        ]);

        // Commit transaksi jika semua operasi berhasil
        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Pasien baru berhasil didaftarkan dan riwayat pemeriksaan dicatat.',
            'data' => $patient
        ]);
        
    } catch (\Exception $e) {
        // Rollback transaksi jika terjadi error
        DB::rollBack();

        return response()->json([
            'success' => false,
            'message' => 'Gagal mendaftarkan pasien baru. Terjadi kesalahan pada server.',
            'error' => $e->getMessage() // Hapus ini pada production untuk alasan keamanan
        ], 500);
    }
}



    public function storeTestimoni(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'no_rm' => 'required|exists:pasien_models,no_rm', // Pastikan no_rm ada di tabel pasien
            'nama_pasien' => 'required|string', // Pastikan no_rm ada di tabel pasien
            'testimoni' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        // Jika validasi gagal, kembalikan response error
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            // Simpan testimoni baru ke database
            $testimoni = TestimoniPasien::create([
                'no_rm' => $request->no_rm,
                'nama_pasien' => $request->nama_pasien,
                'testimoni' => $request->testimoni,
                'rating' => $request->rating,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Testimoni berhasil disimpan',
                'data' => $testimoni,
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan testimoni',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getAll()
    {
        $testimonials = TestimoniPasien::all(); // Fetch all testimonials
        return response()->json([
            'success' => true,
            'testimonials' => $testimonials
        ]);
    }
}
