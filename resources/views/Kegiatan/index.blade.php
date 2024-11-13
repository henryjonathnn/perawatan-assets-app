@extends('layouts.app')

@section('content')
    <div class="container-fluid px-4">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1">Detail Aset & Kegiatan</h4>
            </div>
            <button type="button" class="btn btn-success d-flex align-items-center gap-2" data-bs-toggle="modal"
                data-bs-target="#createKegiatanModal">
                <i class="fas fa-plus"></i>
                <span>Tambah Kegiatan</span>
            </button>
        </div>

        <!-- Asset Details Card -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-light py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Informasi Aset</h5>
                <button type="button" class="btn btn-primary btn-sm d-flex align-items-center gap-2" data-bs-toggle="modal"
                    data-bs-target="#editAssetModal">
                    <i class="fas fa-edit"></i>
                    <span>Edit Data Master</span>
                </button>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <!-- Basic Information -->
                    <div class="col-md-6">
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <div class="d-flex flex-column">
                                    <span class="text-muted small">Jenis Aset</span>
                                    <span class="fw-medium">{{ $aset->jenis }}</span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="d-flex flex-column">
                                    <span class="text-muted small">Nama Barang</span>
                                    <span class="fw-medium">{{ $aset->nama_barang }}</span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="d-flex flex-column">
                                    <span class="text-muted small">Serial Number</span>
                                    <span class="fw-medium">{{ $aset->serial_number }}</span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="d-flex flex-column">
                                    <span class="text-muted small">Part Number</span>
                                    <span class="fw-medium">{{ $aset->part_number }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Information -->
                    <div class="col-md-6">
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <div class="d-flex flex-column">
                                    <span class="text-muted small">Pengguna</span>
                                    <span class="fw-medium">{{ $aset->pengguna }}</span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="d-flex flex-column">
                                    <span class="text-muted small">Tahun Kepemilikan</span>
                                    <span class="fw-medium">{{ $aset->tahun_kepemilikan }}</span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="d-flex flex-column">
                                    <span class="text-muted small">Status Kepemilikan</span>
                                    <span class="fw-medium">{{ $aset->kepemilikan->kepemilikan }}</span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="d-flex flex-column">
                                    <span class="text-muted small">Total Kegiatan</span>
                                    <span class="fw-medium">{{ $kegiatan->count() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Specifications -->
                    <div class="col-12">
                        <div class="d-flex flex-column">
                            <span class="text-muted small">Spesifikasi</span>
                            <span class="fw-medium">{{ $aset->spek }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Activities Card -->
        <div class="card shadow-sm">
            <div class="card-header bg-light py-3">
                <h5 class="mb-0">Riwayat Kegiatan</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="border-0 ps-4">No</th>
                                <th class="border-0">Tanggal</th>
                                <th class="border-0">Kegiatan</th>
                                <th class="border-0">Petugas</th>
                                <th class="border-0">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kegiatan as $index => $k)
                                <tr>
                                    <td class="ps-4">{{ $loop->iteration }}</td>
                                    <td>{{ $k->created_at->format('d M Y, H:i') }}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="bg-light rounded p-1">
                                                <i class="fas fa-tools text-primary"></i>
                                            </div>
                                            <div>
                                                @if ($k->masterKegiatan->is_custom)
                                                    <span class="d-block fw-medium">Kegiatan Lainnya</span>
                                                    <small class="text-muted">{{ $k->custom_kegiatan }}</small>
                                                @else
                                                    <span class="fw-medium">{{ $k->masterKegiatan->kegiatan }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="bg-light rounded-circle p-1">
                                                <i class="fas fa-user text-primary"></i>
                                            </div>
                                            <span>{{ $k->user->name }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-success">Selesai</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if ($kegiatan->hasPages())
                    <div class="d-flex justify-content-between align-items-center px-4 py-3 border-top">
                        <div class="text-muted small">
                            Menampilkan {{ $kegiatan->firstItem() ?? 0 }} - {{ $kegiatan->lastItem() ?? 0 }} dari
                            {{ $kegiatan->total() ?? 0 }} kegiatan
                        </div>
                        {{ $kegiatan->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Create Kegiatan Modal -->
    <div class="modal fade" id="createKegiatanModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title">Tambah Kegiatan Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('kegiatan.store', $aset->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="username" name="username" required
                                        placeholder="Username">
                                    <label for="username">Username</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="password" class="form-control" id="password" name="password" required
                                        placeholder="Password">
                                    <label for="password">Password</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <select class="form-select @error('id_master_kegiatan') is-invalid @enderror"
                                        id="id_master_kegiatan" name="id_master_kegiatan" required>
                                        <option value="">Pilih Kegiatan</option>
                                        @foreach ($masterKegiatan as $mKegiatan)
                                            <option value="{{ $mKegiatan->id }}"
                                                data-is-custom="{{ $mKegiatan->is_custom }}">
                                                {{ $mKegiatan->kegiatan }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="id_master_kegiatan">Jenis Kegiatan</label>
                                    @error('id_master_kegiatan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12" id="customKegiatanDiv" style="display: none;">
                                <div class="form-floating">
                                    <textarea class="form-control @error('custom_kegiatan') is-invalid @enderror" id="custom_kegiatan"
                                        name="custom_kegiatan" style="height: 100px" placeholder="Deskripsi Kegiatan"></textarea>
                                    <label for="custom_kegiatan">Deskripsi Kegiatan</label>
                                    @error('custom_kegiatan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i>Batal
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save me-1"></i>Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Asset Modal -->
    <div class="modal fade" id="editAssetModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title">Edit Data Aset</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editAssetForm">
                        <div class="row g-4">
                            <!-- Basic Information -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" name="nama_barang" class="form-control" id="nama_barang"
                                        value="{{ $aset->nama_barang }}" placeholder="Nama Barang">
                                    <label for="nama_barang">Nama Barang</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" name="jenis" class="form-control" id="jenis"
                                        value="{{ $aset->jenis }}" placeholder="Jenis">
                                    <label for="jenis">Jenis</label>
                                </div>
                            </div>

                            <!-- Numbers Section -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" name="serial_number" class="form-control" id="serial_number"
                                        value="{{ $aset->serial_number }}" placeholder="Serial Number">
                                    <label for="serial_number">Serial Number</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" name="part_number" class="form-control" id="part_number"
                                        value="{{ $aset->part_number }}" placeholder="Part Number">
                                    <label for="part_number">Part Number</label>
                                </div>
                            </div>

                            <!-- User Information -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" name="pengguna" class="form-control" id="pengguna"
                                        value="{{ $aset->pengguna }}" placeholder="Pengguna">
                                    <label for="pengguna">Pengguna</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="number" name="tahun_kepemilikan" class="form-control"
                                        id="tahun_kepemilikan" value="{{ $aset->tahun_kepemilikan }}"
                                        placeholder="Tahun Kepemilikan">
                                    <label for="tahun_kepemilikan">Tahun Kepemilikan</label>
                                </div>
                            </div>

                            <!-- Ownership -->
                            <div class="col-md-12">
                                <div class="form-floating">
                                    <select name="id_kepemilikan" class="form-select" id="id_kepemilikan">
                                        @foreach ($kepemilikan as $kepemilikan)
                                            <option value="{{ $kepemilikan->id }}"
                                                {{ $aset->id_kepemilikan == $kepemilikan->id ? 'selected' : '' }}>
                                                {{ $kepemilikan->kepemilikan }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="id_kepemilikan">Kepemilikan</label>
                                </div>
                            </div>

                            <!-- Specifications -->
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea name="spek" class="form-control" id="spek" style="height: 100px" placeholder="Spesifikasi">{{ $aset->spek }}</textarea>
                                    <label for="spek">Spesifikasi</label>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Batal
                    </button>
                    <button type="button" class="btn btn-primary" id="continueToCredentials">
                        <i class="fas fa-arrow-right me-1"></i>Lanjutkan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Credentials Modal -->
    <div class="modal fade" id="credentialsModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title">Verifikasi Kredensial</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="credentialsForm" action="{{ route('aset.update', $aset->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="username" name="username" required
                                        placeholder="Username">
                                    <label for="username">Username</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="password" class="form-control" id="password" name="password" required
                                        placeholder="Password">
                                    <label for="password">Password</label>
                                </div>
                            </div>
                        </div>
                        <!-- Hidden inputs for asset data -->
                        <input type="hidden" name="jenis" id="hidden_jenis">
                        <input type="hidden" name="nama_barang" id="hidden_nama_barang">
                        <!-- Add other hidden fields as needed -->
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i>Batal
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save me-1"></i>Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const masterKegiatanSelect = document.getElementById('id_master_kegiatan');
                const customKegiatanDiv = document.getElementById('customKegiatanDiv');
                const customKegiatanTextarea = document.getElementById('custom_kegiatan');
                const editAssetModal = new bootstrap.Modal(document.getElementById('editAssetModal'));
                const credentialsModal = new bootstrap.Modal(document.getElementById('credentialsModal'));
                const form = document.querySelector('form');

                masterKegiatanSelect.addEventListener('change', function() {
                    const selectedOption = this.options[this.selectedIndex];
                    const isCustom = selectedOption.dataset.isCustom === '1';

                    customKegiatanDiv.style.display = isCustom ? 'block' : 'none';
                    customKegiatanTextarea.required = isCustom;

                    if (!isCustom) {
                        customKegiatanTextarea.value = '';
                    }
                });

                form.addEventListener('submit', function(e) {
                    const selectedOption = masterKegiatanSelect.options[masterKegiatanSelect.selectedIndex];
                    const isCustom = selectedOption.dataset.isCustom === '1';

                    if (isCustom && !customKegiatanTextarea.value.trim()) {
                        e.preventDefault();
                        alert('Silakan isi deskripsi kegiatan untuk opsi Lainnya');
                        customKegiatanTextarea.focus();
                    }
                });

                // Handle continue button click
                document.getElementById('continueToCredentials').addEventListener('click', function() {
                    // Transfer form data to hidden inputs
                    document.getElementById('hidden_jenis').value = document.getElementById('edit_jenis').value;
                    document.getElementById('hidden_nama_barang').value = document.getElementById(
                        'edit_nama_barang').value;
                    // Transfer other fields as needed

                    // Close edit modal and show credentials modal
                    editAssetModal.hide();
                    credentialsModal.show();
                });

                // Handle form submission
                document.getElementById('credentialsForm').addEventListener('submit', async function(e) {
                    e.preventDefault();

                    try {
                        const response = await fetch(this.action, {
                            method: 'POST',
                            body: new FormData(this),
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        });

                        const data = await response.json();

                        if (response.ok) {
                            credentialsModal.hide();
                            window.location.reload(); // Refresh page to show updated data
                        } else {
                            alert(data.message || 'Terjadi kesalahan saat memperbarui data.');
                        }
                    } catch (error) {
                        alert('Terjadi kesalahan saat memperbarui data.');
                    }
                });
            });
        </script>
    @endpush

    @push('styles')
        <style>
            .table> :not(caption)>*>* {
                padding: 1rem 0.75rem;
            }

            .badge {
                font-weight: 500;
                letter-spacing: 0.3px;
                padding: 0.35em 0.65em;
            }

            .pagination {
                margin-bottom: 0;
            }
        </style>
    @endpush
@endsection
