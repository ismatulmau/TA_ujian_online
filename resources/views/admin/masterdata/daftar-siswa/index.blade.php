@extends('layouts.app')

@section('page-header')
<div class="page-header">
  <h4 class="page-title">Daftar Siswa</h4>
  <ul class="breadcrumbs">
    <li class="nav-home"><a href="{{ route('admin.dashboard') }}"><i class="icon-home"></i></a></li>
    <li class="separator"><i class="icon-arrow-right"></i></li>
    <li class="nav-item"><a href="{{ route('siswa.index') }}">Daftar Siswa</a></li>
  </ul>
</div>
@endsection

@section('content')
@if($errors->any())
<div class="alert alert-danger">
  <ul>
    @foreach($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
  </ul>
</div>
@endif

@if(session('success'))
<div class="alert alert-success">
  {{ session('success') }}
</div>
@endif
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title">Daftar Siswa</h4>
        <div class="d-flex gap-2">
    <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalImportSiswa">
        <i class="fas fa-file-import"></i> Import Excel
    </button>
    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahSiswa">
        <i class="fa fa-plus"></i> Tambah Siswa
    </button>
    <!-- Tombol Cetak Kartu Ujian -->
    <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#modalCetakKartu">
        <i class="fas fa-id-card"></i> Cetak Kartu Ujian
    </button>
</div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table id="table" class="table table-striped table-hover">
            <thead>
              <tr>
                <th>No</th>
                <th>Foto</th>
                <th>Nomor Peserta</th>
                <th>Nama Peserta</th>
                <th>Kelas</th>
                <th>Level</th>
                <th>Jenis Kelamin</th>
                <th>Ruang Ujian</th>
                <th>Agama</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach($siswas as $index => $siswa)
              <tr>
                <td>{{ $index + 1 }}</td>
                <td>
                  @if($siswa->gambar)
                  <img src="{{ asset('storage/' . $siswa->gambar) }}" alt="Gambar Siswa" class="rounded-circle" width="40" height="40">
                  @else
                  <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                    <i class="fa fa-user text-white"></i>
                  </div>
                  @endif
                </td>
                <td>
                  <div>{{ $siswa->nomor_ujian }}</div>
                  <small class="text-muted">Sesi: {{ $siswa->sesi_ujian }}</small>
                </td>
                <td>{{ $siswa->nama_siswa }}</td>
                <td>
                  <div>{{ $siswa->kelas->nama_kelas ?? '-' }}</div>
                  <small class="text-muted">Jurusan: {{ $siswa->jurusan }}</small>
                </td>
                <td>{{ $siswa->level }}</td>
                <td>{{ $siswa->jenis_kelamin }}</td>
                <td>{{ $siswa->ruang_ujian }}</td>
                <td>{{ $siswa->agama }}</td>
                <td>
                  <div class="d-flex gap-1">
                    <a href="{{ route('siswa.edit', $siswa->id_siswa) }}" class="btn btn-sm btn-warning">
                      <i class="fa fa-edit"></i>
                    </a>
                    <form action="{{ route('siswa.destroy', $siswa->id_siswa) }}" method="POST" style="display:inline;">
                      @csrf
                      @method('DELETE')
                      <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus siswa ini?')">
                        <i class="fa fa-trash"></i>
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Import Excel Siswa -->
<div class="modal fade" id="modalImportSiswa" tabindex="-1" aria-labelledby="modalImportSiswaLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="modalImportSiswaLabel">Import Data Siswa</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="file" class="form-label">Pilih File Excel</label>
            <input type="file" class="form-control" name="file" id="file" required accept=".xlsx, .xls, .csv">
            <small class="text-muted">Format file harus Excel (.xlsx, .xls) atau CSV</small>
          </div>
          <div class="alert alert-info">
            <strong>Petunjuk:</strong>
            <ul class="mb-0">
              <li>Download template <a href="{{ asset('templates/template_import_siswa.xlsx') }}">disini</a></li>
              <li>Kolom wajib: nama_siswa, nomor_ujian, level, jurusan, kode_kelas, jenis_ujian, nomor_induk, gambar, password, jenis_kelamin, sesi_ujian, ruang_ujian, agama</li>
              <li>Format jenis kelamin: L (Laki-laki) atau P (Perempuan)</li>
              <li>Level harus X, XI, atau XII</li>
              <li>Password default: password123 (jika tidak diisi)</li>
            </ul>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Import Data</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Tambah Siswa -->
<div class="modal fade" id="modalTambahSiswa" tabindex="-1" aria-labelledby="modalTambahSiswaLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form action="{{ route('siswa.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalTambahSiswaLabel">Tambah Siswa</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
          <div class="row g-3">
            <!-- Kolom yang sudah ada -->
            <div class="col-md-6">
              <label for="nama_siswa" class="form-label">Nama Siswa</label>
              <input type="text" class="form-control" name="nama_siswa" required>
            </div>
            <div class="col-md-6">
              <label for="nomor_ujian" class="form-label">Nomor Ujian</label>
              <input type="text" class="form-control" name="nomor_ujian" required>
            </div>
            <div class="col-md-6">
              <label for="nomor_induk" class="form-label">Nomor Induk</label>
              <input type="text" class="form-control" name="nomor_induk" required>
            </div>
            <div class="col-md-6">
              <label for="kode_kelas" class="form-label">Kelas</label>
              <select class="form-select" name="kode_kelas" required>
                <option value="">-- Pilih Kelas --</option>
                @foreach($kelas as $kls)
                <option value="{{ $kls->kode_kelas }}">{{ $kls->nama_kelas }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-6">
              <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
              <select class="form-select" name="jenis_kelamin" required>
                <option value="">-- Pilih --</option>
                <option value="L">Laki-laki</option>
                <option value="P">Perempuan</option>
              </select>
            </div>
            <div class="col-md-6">
              <label for="password" class="form-label">Password</label>
              <input type="text" class="form-control" name="password" required maxlength="8">
            </div>
            <div class="col-md-6">
              <label for="agama" class="form-label">Agama</label>
              <input type="text" class="form-control" name="agama" required>
            </div>

            <!-- Kolom baru yang ditambahkan -->
            <div class="col-md-6">
              <label for="level" class="form-label">Level</label>
              <select class="form-select" name="level" required>
                <option value="">-- Pilih Level --</option>
                <option value="X">X</option>
                <option value="XI">XI</option>
                <option value="XII">XII</option>
              </select>
            </div>

            <div class="col-md-6">
              <label for="jurusan" class="form-label">Jurusan</label>
              <input type="text" class="form-control" name="jurusan" required>
            </div>

            <div class="col-md-6">
              <label for="jenis_ujian" class="form-label">Jenis Ujian</label>
              <select class="form-select" name="jenis_ujian" required>
                <option value="">-- Pilih Jenis Ujian --</option>
                <option value="UTS">UTS</option>
                <option value="UAS">UAS</option>
              </select>
            </div>

            <div class="col-md-6">
              <label for="sesi_ujian" class="form-label">Sesi Ujian</label>
              <input type="text" class="form-control" name="sesi_ujian" required>
            </div>

            <div class="col-md-6">
              <label for="ruang_ujian" class="form-label">Ruang Ujian</label>
              <input type="text" class="form-control" name="ruang_ujian" required>
            </div>

            <div class="col-md-6">
              <label for="gambar" class="form-label">Foto Siswa</label>
              <input type="file" class="form-control" name="gambar">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Modal Cetak Kartu Ujian -->
<div class="modal fade" id="modalCetakKartu" tabindex="-1" aria-labelledby="modalCetakKartuLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('siswa.cetak-kartu') }}" method="GET" target="_blank">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCetakKartuLabel">Filter Cetak Kartu Ujian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="jurusan" class="form-label">Jurusan</label>
                        <select class="form-select" id="jurusan" name="jurusan" required>
                            <option value="">-- Pilih Jurusan --</option>
                            <option value="IPA">IPA</option>
                            <option value="IPS">IPS</option>
                            <option value="Bahasa">Bahasa</option>
                            <!-- Tambahkan jurusan lainnya -->
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="kelas" class="form-label">Kelas</label>
                        <select class="form-select" id="kelas" name="kelas" required>
                            <option value="">-- Pilih Kelas --</option>
                            @foreach(['X', 'XI', 'XII'] as $level)
                                <option value="{{ $level }}">{{ $level }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="jenis_ujian" class="form-label">Jenis Ujian</label>
                        <select class="form-select" id="jenis_ujian" name="jenis_ujian" required>
                            <option value="">-- Pilih Jenis Ujian --</option>
                            <option value="UTS">UTS</option>
                            <option value="UAS">UAS</option>
                            <option value="UN">UN</option>
                            <option value="USBN">USBN</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-print"></i> Cetak Kartu
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


</div>
@endsection