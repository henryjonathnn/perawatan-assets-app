<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <p><strong>Nama Barang:</strong> {{ $aset->nama_barang ?? '-' }}</p>
            <p><strong>Jenis:</strong> {{ $aset->jenis ?? '-' }}</p>
            <p><strong>Serial Number:</strong> {{ $aset->serial_number ?? '-' }}</p>
            <p><strong>Part Number:</strong> {{ $aset->part_number ?? '-' }}</p>
        </div>
        <div class="col-md-6">
            <p><strong>Pengguna:</strong> {{ $aset->pengguna ?? '-' }}</p>
            <p><strong>Tahun:</strong> {{ $aset->tahun_kepemilikan ?? '-' }}</p>
            <p><strong>Kepemilikan:</strong> {{ $aset->kepemilikan->kepemilikan ?? '-' }}</p>
            {{-- ->format('d/m/Y H:i') --}}
            <p><strong>Tanggal Dibuat:</strong> {{ $aset->created_at ?? $aset->updated_at ?? '-'}}</p>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-12">
            <strong>Spesifikasi:</strong>
            <p>{{ $aset->spek ?? '-' }}</p>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-12">
            <h6>Riwayat Kegiatan</h6>
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Kegiatan</th>
                            <th>Petugas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($aset->kegiatan as $kegiatan)
                        <tr>
                            <td>{{ $kegiatan->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $kegiatan->kegiatan }}</td>
                            <td>{{ $kegiatan->user->name }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>