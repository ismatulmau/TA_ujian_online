<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Siswa;
use App\Models\Kelas;

class SiswaController extends Controller
{
    public function index()
    {
        $kelas = Kelas::all(); // Ambil semua data kelas
        $siswas = Siswa::with('kelas')->get();
        return view('admin.masterdata.daftar-siswa.index', compact('siswas', 'kelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_siswa' => 'required|max:50',
            'nomor_ujian' => 'required|string|max:255|unique:siswas',
            'jenis_ujian' => 'required|in:UTS,UAS',
            'level' => 'required|in:X,XI,XII',
            'jurusan' => 'required|string|max:50',
            'kode_kelas' => 'required|exists:kelas,kode_kelas',
            'nomor_induk' => 'required|string|unique:siswas',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'jenis_kelamin' => 'required|in:L,P',
            'password' => 'required|min:6|max:8',
            'sesi_ujian' => 'required|string',
            'ruang_ujian' => 'required|string',
            'agama' => 'required|string',
        ],  [
            'nama_siswa.required' => 'Nama siswa harus diisi',
            'nama_siswa.max' => 'Nama siswa maksimal 50 karakter',
            'nomor_ujian.required' => 'Nomor ujian harus diisi',
            'nomor_ujian.max' => 'Nomor ujian maksimal 255 karakter',
            'jenis_ujian.required' => 'Jenis ujian harus diisi',
            'level.required' => 'Level harus diisi',
            'jurusan.required' => 'Jurusan harus diisi',
            'jurusan.max' => 'Jurusan maksimal 50 karakter',
            'kode_kelas.required' => 'Kode kelas harus diisi',
            'kode_kelas.exists' => 'Kode kelas tidak ditemukan',
            'nomor_induk.required' => 'Nomor induk harus diisi',
            'gambar.string' => 'gambar harus berupa teks (path)',
            'jenis_kelamin.required' => 'Jenis kelamin harus diisi',
            'password.required' => 'Password harus diisi',
            'password.max' => 'Password maksimal 8 karakter',
            'sesi_ujian.required' => 'Sesi ujian harus diisi',
            'ruang_ujian.required' => 'Ruang ujian harus diisi',
            'agama.required' => 'Agama harus diisi',
        ]);

        // Handle upload gambar
    $gambarPath = null;
    if ($request->hasFile('gambar')) {
        $gambarPath = $request->file('gambar')->store('siswa_images', 'public');
    }

    Siswa::create([
        'nama_siswa' => $request->nama_siswa,
        'nomor_ujian' => $request->nomor_ujian,
        'jenis_ujian' => $request->jenis_ujian,
        'level' => $request->level,
        'jurusan' => $request->jurusan,
        'kode_kelas' => $request->kode_kelas,
        'nomor_induk' => $request->nomor_induk,
        'gambar' => $gambarPath, // Gunakan variabel $gambarPath bukan $request->gambar
        'jenis_kelamin' => $request->jenis_kelamin,
        'password' => Hash::make($request->password),
        'sesi_ujian' => $request->sesi_ujian,
        'ruang_ujian' => $request->ruang_ujian,
        'agama' => $request->agama,
    ]);

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil disimpan.');
    }

    public function edit($id_siswa)
    {
        $siswa = Siswa::findOrFail($id_siswa);
        $kelas = Kelas::all();
        return view('admin.masterdata.daftar-siswa.edit_siswa', compact('siswa', 'kelas'));
    }

    public function update(Request $request, $id_siswa)
    {
        $siswa = Siswa::findOrFail($id_siswa);
    
        $request->validate([
            'nama_siswa' => 'required|max:50',
            'nomor_ujian' => 'required|string|max:255|unique:siswas,nomor_ujian,'.$id_siswa.',id_siswa',
            'jenis_ujian' => 'required|in:UTS,UAS',
            'level' => 'required|in:X,XI,XII',
            'jurusan' => 'required|string|max:15',
            'kode_kelas' => 'required|exists:kelas,kode_kelas',
            'nomor_induk' => 'required|string|unique:siswas,nomor_induk,'.$id_siswa.',id_siswa',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'jenis_kelamin' => 'required|in:L,P',
            'password' => 'nullable|min:6|max:8',
            'sesi_ujian' => 'required|string',
            'ruang_ujian' => 'required|string',
            'agama' => 'required|string',
        ]);
    
        $data = [
            'nama_siswa' => $request->nama_siswa,
            'nomor_ujian' => $request->nomor_ujian,
            'jenis_ujian' => $request->jenis_ujian,
            'level' => $request->level,
            'jurusan' => $request->jurusan,
            'kode_kelas' => $request->kode_kelas,
            'nomor_induk' => $request->nomor_induk,
            'jenis_kelamin' => $request->jenis_kelamin,
            'sesi_ujian' => $request->sesi_ujian,
            'ruang_ujian' => $request->ruang_ujian,
            'agama' => $request->agama,
        ];
    
        // Handle password jika diisi
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }
    
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($siswa->gambar && Storage::disk('public')->exists($siswa->gambar)) {
                Storage::disk('public')->delete($siswa->gambar);
            }
            
            // Simpan gambar baru dan tambahkan ke array data
            $data['gambar'] = $request->file('gambar')->store('siswa_images', 'public');
        }
    
        $siswa->update($data);
    
        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy($id_siswa)
    {
        $siswa = Siswa::findOrFail($id_siswa);
        $siswa->delete();

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil dihapus.');
    }

    public function cetakKartu(Request $request)
{
    $request->validate([
        'jurusan' => 'required',
        'kelas' => 'required',
        'jenis_ujian' => 'required'
    ]);

    $siswas = Siswa::where('jurusan', $request->jurusan)
                 ->where('level', $request->kelas)
                 ->get();

    if ($siswas->isEmpty()) {
        return back()->with('error', 'Tidak ada data siswa untuk kriteria tersebut');
    }

    $pdf = Pdf::loadView('siswa.cetak-kartu', [
        'siswas' => $siswas,
        'jenis_ujian' => $request->jenis_ujian
    ]);

    return $pdf->stream('kartu-ujian-'.now()->format('Ymd').'.pdf');
}
}
