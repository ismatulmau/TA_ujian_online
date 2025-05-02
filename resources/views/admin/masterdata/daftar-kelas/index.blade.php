@extends('layouts.app')

@section('page-header')
<div class="page-header">
  <h4 class="page-title">Daftar Kelas</h4>
  <ul class="breadcrumbs">
    <li class="nav-home"><a href="{{ route('admin.dashboard') }}"><i class="icon-home"></i></a></li>
    <li class="separator"><i class="icon-arrow-right"></i></li>
    <li class="nav-item"><a href="{{ route('kelas.index') }}">Daftar Kelas</a></li>
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
        <h4 class="card-title mb-0">Daftar Kelas</h4>
        <div class="d-flex gap-2">
          <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalImportKelas">
            <i class="fas fa-file-import"></i> Import Excel
          </button>
          <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahKelas">
            <i class="fa fa-plus"></i> Tambah Kelas
          </button>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table id="table" class="table table-striped table-hover">
            <thead>
              <tr>
                <th>No</th>
                <th>Kode Kelas</th>
                <th>Level</th>
                <th>Jurusan</th>
                <th>Nama Kelas</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach($kelas as $index => $kls)
              <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $kls->kode_kelas }}</td>
                <td>{{ $kls->level }}</td>
                <td>{{ $kls->jurusan ?? '-' }}</td>
                <td>{{ $kls->nama_kelas }}</td>
                <td>
                  <a href="{{ route('kelas.edit', $kls->kode_kelas) }}" class="btn btn-sm btn-warning">Edit</a>
                  <form action="{{ route('kelas.destroy', $kls->kode_kelas) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus kelas ini?')">Hapus</button>
                  </form>
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

<!-- Modal Import Excel -->
<div class="modal fade" id="modalImportKelas" tabindex="-1" aria-labelledby="modalImportKelasLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="modalImportKelasLabel">Import Data Kelas</h5>
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
              <li>Download template <a href="{{ asset('templates/template_import_kelas.xlsx') }}">disini</a></li>
              <li>Kolom wajib: kode_kelas, level, jurusan, nama_kelas</li>
              <li>Level harus X, XI, atau XII</li>
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
<!-- Modal Tambah Kelas -->
<div class="modal fade" id="modalTambahKelas" tabindex="-1" aria-labelledby="modalTambahKelasLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form action="{{ route('kelas.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalTambahKelasLabel">Tambah Kelas</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label for="kode_kelas" class="form-label">Kode Kelas</label>
              <input type="text" class="form-control" name="kode_kelas" required>
            </div>
            <div class="col-md-6">
              <label for="level" class="form-label">Level</label>
              <select class="form-select" name="level" required>
                <option value="">-- Pilih --</option>
                <option value="X">X</option>
                <option value="XI">XI</option>
                <option value="XII">XII</option>
              </select>
            </div>
            <div class="col-md-6">
              <label for="jurusan" class="form-label">Jurusan</label>
              <input type="text" class="form-control" name="jurusan" required maxlength="8">
            </div>
            <div class="col-md-6">
              <label for="nama_kelas" class="form-label">Nama Kelas</label>
              <input type="text" class="form-control" name="nama_kelas" required>
            </div>
            <!-- Tambahkan field lain sesuai kebutuhan -->
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
@endsection