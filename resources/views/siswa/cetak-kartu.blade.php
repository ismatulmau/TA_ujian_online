<!DOCTYPE html>
<html>
<head>
    <title>Kartu Ujian</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .kartu-container { 
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            padding: 20px;
        }
        .kartu {
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 10px;
            page-break-inside: avoid;
        }
        .header-kartu {
            text-align: center;
            margin-bottom: 15px;
        }
        .foto-siswa {
            width: 80px;
            height: 100px;
            object-fit: cover;
            border: 1px solid #ccc;
            float: right;
        }
        .clear { clear: both; }
        table { width: 100%; }
        table td { padding: 3px 0; }
        .footer-kartu {
            margin-top: 15px;
            text-align: center;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="kartu-container">
        @foreach($siswas as $siswa)
        <div class="kartu">
            <div class="header-kartu">
                <h3>KARTU PESERTA UJIAN</h3>
                <h4>{{ strtoupper($jenis_ujian) }}</h4>
                <p>Sekolah/Madrasah: [Nama Sekolah]</p>
            </div>
            
            @if($siswa->gambar)
            <img src="{{ storage_path('app/public/' . $siswa->gambar) }}" class="foto-siswa">
            @endif
            
            <table>
                <tr>
                    <td width="35%">Nomor Peserta</td>
                    <td>: {{ $siswa->nomor_ujian }}</td>
                </tr>
                <tr>
                    <td>Nama Peserta</td>
                    <td>: {{ $siswa->nama_siswa }}</td>
                </tr>
                <tr>
                    <td>Kelas</td>
                    <td>: {{ $siswa->kelas->nama_kelas ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Jurusan</td>
                    <td>: {{ $siswa->jurusan }}</td>
                </tr>
                <tr>
                    <td>Jenis Kelamin</td>
                    <td>: {{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                </tr>
                <tr>
                    <td>Ruang Ujian</td>
                    <td>: {{ $siswa->ruang_ujian }}</td>
                </tr>
                <tr>
                    <td>Sesi</td>
                    <td>: {{ $siswa->sesi_ujian }}</td>
                </tr>
            </table>
            
            <div class="clear"></div>
            <div class="footer-kartu">
                <p>Harap membawa kartu ini saat ujian</p>
                <p>Tanda Tangan Peserta: ___________________</p>
            </div>
        </div>
        @endforeach
    </div>
</body>
</html>