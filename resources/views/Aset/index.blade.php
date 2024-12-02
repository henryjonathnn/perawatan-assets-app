@extends('layouts.app')

@section('content')
    <style>
        .form-floating {
            position: relative;
        }

        .input-icon {
            position: absolute;
            top: 50%;
            right: 10px;
            /* Adjust to position icon */
            transform: translateY(-50%);
            color: #007bff;
            /* Change to your preferred color */
        }

        .form-control {
            padding-right: 30px;
            /* Make space for the icon */
        }
    </style>
    <div class="container-fluid px-4">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1">Manajemen Aset</h4>
            </div>
            <button type="button" class="btn btn-primary d-flex align-items-center gap-2" data-bs-toggle="modal"
                data-bs-target="#createAsetModal">
                <i class="fas fa-plus"></i>
                <span>Tambah Aset</span>
            </button>
        </div>
        <!-- Search and Filter Card -->

        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <div class="row g-3">
                    <!-- Search Input Group -->
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" class="form-control border-start-0 ps-0" id="searchInput"
                                placeholder="Cari aset...">
                            <button class="btn btn-primary" type="button" data-bs-toggle="collapse"
                                data-bs-target="#filterOptions">
                                <i class="fas fa-filter me-1"></i> Filter
                            </button>
                        </div>
                    </div>

                    <!-- Filter Collapse Section -->
                    <div class="col-12 collapse" id="filterOptions">
                        <div class="card card-body border-0 bg-light">
                            <div class="row g-3">
                                <div class="col-12">
                                    <h6 class="mb-2">Cari berdasarkan:</h6>
                                    <div class="d-flex gap-3 flex-wrap">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="searchById" checked>
                                            <label class="form-check-label" for="searchById">
                                                ID
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="searchByNama">
                                            <label class="form-check-label" for="searchByNama">
                                                Nama Barang
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="searchByJenis">
                                            <label class="form-check-label" for="searchByJenis">
                                                Jenis
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="searchByNomor">
                                            <label class="form-check-label" for="searchByNomor">
                                                Nomor Aset
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Assets List Card -->
        <div class="card shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr class="text-left">
                                <div class="mt-4 ms-3">
                                    <button type="button" id="printSelected" class="btn btn-primary" disabled>
                                        <i class="fas fa-print me-2"></i>Cetak QR Code Terpilih
                                    </button>
                                </div>
                                <th class="border-0 ps-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="selectAll">
                                    </div>
                                </th>
                                <th class="border-0 ps-4">No</th>
                                <th class="border-0">Nomor Aset</th>
                                <th class="border-0">Jenis</th>
                                <th class="border-0">Nama Barang</th>
                                <th class="border-0">Pengguna</th>
                                <th class="border-0 rounded-end text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($aset as $index => $item)
                                <tr class="text-left">
                                    <td class="ps-4">
                                        <div class="form-check">
                                            <input class="form-check-input aset-checkbox" type="checkbox"
                                                value="{{ $item->id }}" name="selected_asets[]">
                                        </div>
                                    </td>
                                    <td class="ps-4">
                                        <span class="fw-medium">{{ $loop->iteration ?? '-' }}</span>
                                    </td>
                                    <td>
                                        <div>
                                            <span class="d-block fw-medium">{{ $item->nomor_aset ?? '-' }}</span>
                                            <small class="text-muted">ID: {{ Str::afterLast($item->id, '-') }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark">{{ $item->jenis->jenis ?? '-' }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="bg-light rounded p-1">
                                                <i class="fas fa-box text-primary"></i>
                                            </div>
                                            <div>
                                                <span class="d-block fw-medium">{{ $item->nama_barang }}</span>
                                                <small class="text-muted">SN: {{ $item->serial_number }}</small>
                                                <small class="text-muted">PN: {{ $item->part_number }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="bg-light rounded-circle p-1">
                                                <i class="fas fa-user text-primary"></i>
                                            </div>
                                            <span>{{ $item->pengguna ?? '-' }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-1">
                                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#detailAsetModal" data-aset-id="{{ $item->id }}"
                                                onclick="loadAsetDetail('{{ $item->id }}')">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-warning text-white"
                                                data-bs-toggle="modal" data-bs-target="#editAsetModal"
                                                data-aset-id="{{ $item->id }}"
                                                onclick="loadAsetEdit('{{ $item->id }}')">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-info text-white"
                                                onclick="loadBarcode('{{ $item->id }}')">
                                                <i class="fas fa-qrcode"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center px-4 py-3 border-top">
                    <div class="text-muted small">
                        Menampilkan {{ $aset->firstItem() ?? 0 }} - {{ $aset->lastItem() ?? 0 }} dari
                        {{ $aset->total() ?? 0 }} aset
                    </div>

                    @if ($aset->hasPages())
                        <nav class="d-flex justify-content-end">
                            <ul class="pagination mb-0">
                                {{-- Previous Page Link --}}
                                @if ($aset->onFirstPage())
                                    <li class="page-item disabled">
                                        <span class="page-link">&laquo;</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $aset->previousPageUrl() }}"
                                            rel="prev">&laquo;</a>
                                    </li>
                                @endif

                                {{-- Pagination Elements --}}
                                @foreach ($aset->getUrlRange(1, $aset->lastPage()) as $page => $url)
                                    @if ($page == $aset->currentPage())
                                        <li class="page-item active">
                                            <span class="page-link">{{ $page }}</span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                        </li>
                                    @endif
                                @endforeach

                                {{-- Next Page Link --}}
                                @if ($aset->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $aset->nextPageUrl() }}"
                                            rel="next">&raquo;</a>
                                    </li>
                                @else
                                    <li class="page-item disabled">
                                        <span class="page-link">&raquo;</span>
                                    </li>
                                @endif
                            </ul>
                        </nav>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Create Modal -->
    <div class="modal fade" id="createAsetModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title">Tambah Aset Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('aset.store') }}" method="POST" class="p-4" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row g-4">
                            <!-- Basic Information -->
                            <div class="col-12">
                                <h6 class="text-primary mb-3">Informasi Dasar</h6>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" name="nama_barang" class="form-control"
                                                id="createNamaBarang" placeholder="Nama Barang">
                                            <label for="createNamaBarang">Nama Barang</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <select name="id_master_jenis" class="form-select" id="createJenis">
                                                <option value="">Pilih Jenis</option>
                                                @foreach ($jenis as $j)
                                                    <option value="{{ $j->id }}">
                                                        {{ $j->jenis }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <label for="createJenis">Jenis</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Numbers Section -->
                            <div class="col-12">
                                <h6 class="text-primary mb-3">Nomor Identifikasi</h6>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <div class="form-floating">
                                            <input type="text" name="nomor_aset" class="form-control"
                                                id="createNomorAset" placeholder="Nomor Aset">
                                            <label for="createNomorAset">Nomor Aset</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-floating">
                                            <input type="text" name="serial_number" class="form-control"
                                                id="createSerialNumber" placeholder="Serial Number">
                                            <label for="createSerialNumber">Serial Number</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-floating">
                                            <input type="text" name="part_number" class="form-control"
                                                id="createPartNumber" placeholder="Part Number">
                                            <label for="createPartNumber">Part Number</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Specifications & Status -->
                            <div class="col-12">
                                <h6 class="text-primary mb-3">Spesifikasi & Status</h6>
                                <div class="row g-3">
                                    <div class="col-md-8">
                                        <div class="form-floating">
                                            <textarea name="spek" class="form-control" id="createSpek" style="height: 100px" placeholder="Spesifikasi"></textarea>
                                            <label for="createSpek">Spesifikasi</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-floating">
                                            <select name="status" class="form-select" id="createStatus">
                                                <option value="">Pilih Status</option>
                                                <option value="baik">Baik</option>
                                                <option value="kurang_layak">Kurang Layak</option>
                                                <option value="rusak">Rusak</option>
                                            </select>
                                            <label for="createStatus">Status</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Additional Info -->
                            <div class="col-12">
                                <h6 class="text-primary mb-3">Informasi Tambahan</h6>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <div class="form-floating">
                                            <input type="number" id="createTahun" name="tahun_kepemilikan"
                                                class="form-control" data-bs-toggle="modal"
                                                data-bs-target="#yearSelectorModal" value="{{ now()->year }}" readonly>
                                            <label for="createTahun">Tahun Kepemilikan</label>
                                        </div>
                                    </div>
                                    {{-- <button class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#yearSelectorModal">
                                        Pilih Tahun
                                    </button> --}}

                                    <div class="col-md-4">
                                        <div class="form-floating">
                                            <input type="text" name="pengguna" class="form-control"
                                                id="createPengguna" placeholder="Pengguna">
                                            <label for="createPengguna">Pengguna</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-floating">
                                            <select name="id_kepemilikan" class="form-select" id="createKepemilikan">
                                                <option value="">Pilih Kepemilikan</option>
                                                @foreach ($kepemilikan as $k)
                                                    <option value="{{ $k->id }}">
                                                        {{ $k->kepemilikan }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <label for="createKepemilikan">Kepemilikan</label>
                                        </div>
                                    </div>
                                    <div class="row g-3 mt-2">
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input type="text" name="lokasi" id="createLokasi"
                                                    placeholder="lokasi" class="form-control">
                                                <label for="createLokasi">Lokasi</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input type="file" name="foto_aset" id="createFotoAset"
                                                    class="form-control" accept="image/*">
                                                <label for="createFotoAset">Foto Aset</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Buat</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <div class="modal fade" id="yearSelectorModal" tabindex="-1" aria-labelledby="yearSelectorModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="yearSelectorModalLabel">Pilih Tahun</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <button class="btn btn-outline-secondary" id="prevYearRange">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <span id="yearRange" class="fw-bold"></span>
                        <button class="btn btn-outline-secondary" id="nextYearRange">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                    <div class="row g-2" id="yearGrid"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Modal -->
    <div class="modal fade" id="detailAsetModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Aset</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="detailAsetContent">
                    <!-- Content will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    <!-- Photo View Modal -->
    <div class="modal fade" id="photoViewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center p-0">
                    <img src="" id="modalPhotoPreview" alt="Foto Kegiatan" class="img-fluid">
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editAsetModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Aset</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="editAsetContent">
                    <!-- Content will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    <!-- Barcode Modal -->
    <div class="modal fade" id="barcodeModal" tabindex="-1">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">QR Code Aset</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center" id="barcodeContent">
                    <!-- QR Code akan dimuat di sini -->
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            class YearSelectorModal {
                constructor() {
                    this.yearGrid = document.getElementById("yearGrid");
                    this.yearRange = document.getElementById("yearRange");
                    this.startYear = 2017;
                    this.endYear = 2032;
                    this.selectedYear = new Date().getFullYear();
                    this.targetInput = null;
                    this.currentModalInstance = null;
                    this.parentModalId = null;

                    this.initialize();
                }

                initialize() {
                    // Initialize navigation buttons
                    document.getElementById("prevYearRange").addEventListener("click", () => {
                        this.startYear -= 16;
                        this.endYear -= 16;
                        this.generateYearGrid();
                    });

                    document.getElementById("nextYearRange").addEventListener("click", () => {
                        this.startYear += 16;
                        this.endYear += 16;
                        this.generateYearGrid();
                    });

                    // Initialize year selector modal events
                    const yearSelectorModal = document.getElementById('yearSelectorModal');
                    yearSelectorModal.addEventListener('show.bs.modal', (event) => {
                        const button = event.relatedTarget;
                        const input = button.closest('.form-floating').querySelector('input');
                        if (input) {
                            this.targetInput = input;
                            this.selectedYear = parseInt(input.value) || new Date().getFullYear();
                            // Store the parent modal ID
                            this.parentModalId = input.id === 'createTahun' ? 'createAsetModal' : 'editAsetModal';
                            this.generateYearGrid();
                        }
                    });

                    // Store modal reference when it's opened
                    yearSelectorModal.addEventListener('shown.bs.modal', () => {
                        this.currentModalInstance = bootstrap.Modal.getInstance(yearSelectorModal);
                    });

                    // Setup year inputs
                    this.setupYearInputs();
                }

                setupYearInputs() {
                    const yearInputs = [{
                            id: 'createTahun',
                            modalId: 'createAsetModal'
                        },
                        {
                            id: 'editTahun',
                            modalId: 'editAsetModal'
                        }
                    ];

                    yearInputs.forEach(({
                        id,
                        modalId
                    }) => {
                        const input = document.getElementById(id);
                        if (input) {
                            input.readOnly = true;
                            const wrapper = input.closest('.form-floating');

                            const selectYearBtn = document.createElement('button');
                            selectYearBtn.type = 'button';
                            selectYearBtn.className =
                                'btn btn-link position-absolute end-0 top-50 translate-middle-y text-decoration-none';
                            selectYearBtn.innerHTML = '<i class="fas fa-calendar"></i>';
                            selectYearBtn.setAttribute('data-bs-toggle', 'modal');
                            selectYearBtn.setAttribute('data-bs-target', '#yearSelectorModal');

                            if (wrapper) {
                                wrapper.style.position = 'relative';
                                wrapper.appendChild(selectYearBtn);
                            }
                        }
                    });
                }

                generateYearGrid() {
                    this.yearGrid.innerHTML = '';
                    for (let year = this.startYear; year <= this.endYear; year++) {
                        const yearButton = document.createElement('div');
                        yearButton.classList.add('col-3');

                        const button = document.createElement('button');
                        button.type = 'button';
                        button.classList.add('btn', 'btn-outline-primary', 'w-100', 'mb-2');
                        button.textContent = year;

                        if (year === this.selectedYear) {
                            button.classList.remove('btn-outline-primary');
                            button.classList.add('btn-primary', 'text-white');
                        }

                        button.addEventListener('click', () => this.handleYearSelection(year));
                        yearButton.appendChild(button);
                        this.yearGrid.appendChild(yearButton);
                    }
                    this.yearRange.textContent = `${this.startYear} - ${this.endYear}`;
                }

                handleYearSelection(year) {
                    if (this.targetInput) {
                        this.targetInput.value = year;

                        // Close the year selector modal
                        if (this.currentModalInstance) {
                            this.currentModalInstance.hide();
                        }

                        // Show the parent modal after a short delay
                        setTimeout(() => {
                            if (this.parentModalId) {
                                const parentModal = document.getElementById(this.parentModalId);
                                if (parentModal) {
                                    const parentModalInstance = bootstrap.Modal.getInstance(parentModal);
                                    if (!parentModalInstance) {
                                        // If modal instance doesn't exist, create new one
                                        new bootstrap.Modal(parentModal).show();
                                    } else {
                                        // If modal instance exists, show it
                                        parentModalInstance.show();
                                    }
                                }
                            }
                        }, 150); // Small delay to ensure smooth transition
                    }
                }
            }


            // Main initialization
            document.addEventListener('DOMContentLoaded', function() {
                const elements = {
                    selectAll: document.getElementById('selectAll'),
                    asetCheckboxes: document.querySelectorAll('.aset-checkbox'),
                    printSelected: document.getElementById('printSelected'),
                    photoViewModal: document.getElementById('photoViewModal'),
                    modalPhotoPreview: document.getElementById('modalPhotoPreview'),
                    detailAsetModal: document.getElementById('detailAsetModal'),
                    photoPreview: document.getElementById('photoPreview'),
                    createModal: document.getElementById('createKegiatanModal'),
                    imagePreview: document.querySelector('#imagePreview'),
                    fileInput: document.querySelector('#foto')
                };

                const searchInput = document.getElementById('searchInput');
                const searchById = document.getElementById('searchById');
                const searchByNama = document.getElementById('searchByNama');
                const searchByJenis = document.getElementById('searchByJenis');
                const searchByNomor = document.getElementById('searchByNomor');
                const tableRows = document.querySelectorAll('table tbody tr');

                function filterTable() {
                    const searchTerm = searchInput.value.toLowerCase();

                    tableRows.forEach(row => {
                        let showRow = false;

                        if (searchTerm === '') {
                            showRow = true;
                        } else {
                            // Check ID (only the part after the last '-')
                            if (searchById.checked) {
                                const idCell = row.querySelector('td:nth-child(3)');
                                const idText = idCell.querySelector('small').textContent;
                                const idNumber = idText.split('ID: ')[1];
                                if (idNumber.toLowerCase().includes(searchTerm)) {
                                    showRow = true;
                                }
                            }

                            // Check Nama Barang
                            if (searchByNama.checked) {
                                const namaCell = row.querySelector('td:nth-child(5)');
                                const namaText = namaCell.querySelector('.fw-medium').textContent;
                                if (namaText.toLowerCase().includes(searchTerm)) {
                                    showRow = true;
                                }
                            }

                            // Check Jenis
                            if (searchByJenis.checked) {
                                const jenisCell = row.querySelector('td:nth-child(4)');
                                const jenisText = jenisCell.textContent;
                                if (jenisText.toLowerCase().includes(searchTerm)) {
                                    showRow = true;
                                }
                            }

                            // Check Nomor Aset
                            if (searchByNomor.checked) {
                                const nomorCell = row.querySelector('td:nth-child(3)');
                                const nomorText = nomorCell.querySelector('.fw-medium').textContent;
                                if (nomorText.toLowerCase().includes(searchTerm)) {
                                    showRow = true;
                                }
                            }
                        }

                        row.style.display = showRow ? '' : 'none';
                    });
                }

                // Add event listeners
                searchInput.addEventListener('input', filterTable);
                searchById.addEventListener('change', filterTable);
                searchByNama.addEventListener('change', filterTable);
                searchByJenis.addEventListener('change', filterTable);
                searchByNomor.addEventListener('change', filterTable);

                // Ensure at least one checkbox is checked
                function updateCheckboxStates() {
                    const checkboxes = [searchById, searchByNama, searchByJenis, searchByNomor];
                    const checkedCount = checkboxes.filter(cb => cb.checked).length;

                    checkboxes.forEach(checkbox => {
                        checkbox.disabled = checkbox.checked && checkedCount === 1;
                    });
                }

                [searchById, searchByNama, searchByJenis, searchByNomor].forEach(checkbox => {
                    checkbox.addEventListener('change', updateCheckboxStates);
                });

                // Initial call
                updateCheckboxStates();


                // Initialize year selector
                // const yearSelector = new YearSelectorModal();
                new YearSelectorModal();

                const editModal = document.getElementById('editAsetModal');
                if (editModal) {
                    editModal.addEventListener('show.bs.modal', function() {
                        // Pastikan input tahun di modal edit sudah disetup
                        const editYearInput = document.getElementById('editTahun');
                        if (editYearInput) {
                            yearSelector.setupYearInputForElement(editYearInput, 'editAsetModal');
                        }
                    });
                }

                // Update both create and edit form year inputs to be readonly and trigger year selector
                const yearInputs = ['createTahun', 'editTahun'];
                yearInputs.forEach(inputId => {
                    const input = document.getElementById(inputId);
                    if (input) {
                        input.readOnly = true;
                        const wrapper = input.closest('.form-floating');

                        // Create button to trigger year selector
                        const selectYearBtn = document.createElement('button');
                        selectYearBtn.type = 'button';
                        selectYearBtn.className =
                            'btn btn-link position-absolute end-0 top-50 translate-middle-y text-decoration-none';
                        selectYearBtn.innerHTML = '<i class="fas fa-calendar"></i>';
                        selectYearBtn.setAttribute('data-bs-toggle', 'modal');
                        selectYearBtn.setAttribute('data-bs-target', '#yearSelectorModal');
                        selectYearBtn.setAttribute('data-target-input', inputId);
                        selectYearBtn.setAttribute('data-target-modal', inputId === 'createTahun' ?
                            'createAsetModal' : 'editAsetModal');

                        wrapper.style.position = 'relative';
                        wrapper.appendChild(selectYearBtn);
                    }
                });

                // Initialize other handlers (e.g., photo handling, checkbox handling)
                initializePhotoHandlers();
                initializeCheckboxHandlers();
                initializeModalHandlers();
            });

            // Photo handling functions
            function initializePhotoHandlers() {
                // Global click handler for photo viewing
                document.addEventListener('click', function(e) {
                    const photoButton = e.target.closest('.view-photo');
                    if (!photoButton) return;

                    e.preventDefault();
                    showPhotoModal(photoButton.dataset.photo);
                });

                // Photo modal events
                const photoViewModal = document.getElementById('photoViewModal');
                photoViewModal.addEventListener('hidden.bs.modal', function() {
                    document.getElementById('modalPhotoPreview').src = '';
                });

                // Nested modal handling
                photoViewModal.addEventListener('show.bs.modal', function() {
                    document.getElementById('detailAsetModal').style.opacity = 1;
                });

                photoViewModal.addEventListener('hidden.bs.modal', function() {
                    document.getElementById('detailAsetModal').style.opacity = 1;
                    document.getElementById('photoPreview').src = '';
                });
            }

            // Checkbox handling functions
            function initializeCheckboxHandlers() {
                const selectAll = document.getElementById('selectAll');
                const asetCheckboxes = document.querySelectorAll('.aset-checkbox');
                const printSelected = document.getElementById('printSelected');

                // Select All checkbox handler
                selectAll.addEventListener('change', function() {
                    asetCheckboxes.forEach(checkbox => {
                        checkbox.checked = this.checked;
                    });
                    updatePrintButtonState();
                });

                // Individual checkboxes handler
                asetCheckboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        const allChecked = Array.from(asetCheckboxes).every(cb => cb.checked);
                        const anyChecked = Array.from(asetCheckboxes).some(cb => cb.checked);
                        selectAll.checked = allChecked;
                        updatePrintButtonState();
                    });
                });

                // Print button handler
                if (printSelected) {
                    printSelected.addEventListener('click', handlePrintSelected);
                }
            }

            // Modal handling functions
            function initializeModalHandlers() {
                const createModal = document.getElementById('createKegiatanModal');
                if (createModal) {
                    createModal.addEventListener('hidden.bs.modal', resetModalForm);
                }
            }

            // Utility functions
            function showPhotoModal(photoUrl) {
                const modalImg = document.getElementById('modalPhotoPreview');
                modalImg.src = photoUrl;
                const photoModal = new bootstrap.Modal(document.getElementById('photoViewModal'));
                photoModal.show();
            }

            function updatePrintButtonState() {
                const asetCheckboxes = document.querySelectorAll('.aset-checkbox');
                const printSelected = document.getElementById('printSelected');
                const checkedBoxes = Array.from(asetCheckboxes).filter(cb => cb.checked);
                if (printSelected) {
                    printSelected.disabled = checkedBoxes.length === 0;
                }
            }

            function handlePrintSelected(e) {
                e.preventDefault();
                const asetCheckboxes = document.querySelectorAll('.aset-checkbox');
                const selectedAsets = Array.from(asetCheckboxes)
                    .filter(cb => cb.checked)
                    .map(cb => cb.value);

                if (selectedAsets.length === 0) {
                    alert('Pilih minimal satu aset untuk dicetak');
                    return;
                }

                // Create form for printing
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '/aset/print-multiple'; // Pastikan URL ini sesuai dengan route Anda
                form.target = '_blank'; // Buka di tab baru

                // Add CSRF token
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = document.querySelector('meta[name="csrf-token"]').content;
                form.appendChild(csrfInput);

                // Add selected assets
                selectedAsets.forEach(asetId => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'selected_asets[]';
                    input.value = asetId;
                    form.appendChild(input);
                });

                // Submit form
                document.body.appendChild(form);
                form.submit();
                document.body.removeChild(form);
            }

            function resetModalForm() {
                const preview = document.querySelector('#imagePreview');
                const previewImg = preview.querySelector('img');
                const fileInput = document.querySelector('#foto');

                previewImg.src = '';
                preview.classList.add('d-none');
                fileInput.value = '';
            }

            // Image preview function
            function previewImage(input) {
                const preview = document.querySelector('#imagePreview');
                const previewImg = preview.querySelector('img');

                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImg.src = e.target.result;
                        preview.classList.remove('d-none');
                    }
                    reader.readAsDataURL(input.files[0]);
                } else {
                    previewImg.src = '';
                    preview.classList.add('d-none');
                }
            }

            // AJAX loading functions
            async function loadAsetDetail(id) {
                try {
                    const response = await fetch(`/aset/${id}/detail`);
                    const html = await response.text();
                    document.getElementById('detailAsetContent').innerHTML = html;
                } catch (error) {
                    console.error('Error loading asset detail:', error);
                }
            }

            async function loadAsetEdit(id) {
                try {
                    const response = await fetch(`/aset/${id}/edit`);
                    const html = await response.text();
                    document.getElementById('editAsetContent').innerHTML = html;
                } catch (error) {
                    console.error('Error loading asset edit:', error);
                }
            }

            async function loadBarcode(id) {
                try {
                    const response = await fetch(`/aset/${id}/barcode`);
                    const html = await response.text();
                    document.getElementById('barcodeContent').innerHTML = html;

                    const modal = new bootstrap.Modal(document.getElementById('barcodeModal'));
                    modal.show();

                    const printButton = document.getElementById('printQRButton');
                    if (printButton) {
                        printButton.addEventListener('click', () => window.print());
                    }
                } catch (error) {
                    console.error('Error loading barcode:', error);
                }
            }
        </script>
    @endpush

    @push('styles')
        <style>
            /* Custom Styles */
            .table> :not(caption)>*>* {
                padding: 1rem 0.75rem;
            }

            .badge {
                font-weight: 500;
                letter-spacing: 0.3px;
                padding: 0.35em 0.65em;
            }

            .pagination {
                display: flex;
                padding-left: 0;
                list-style: none;
                gap: 0.25rem;
            }

            .page-link {
                position: relative;
                display: block;
                padding: 0.5rem 0.75rem;
                margin-left: -1px;
                line-height: 1.25;
                color: #4b5563;
                background-color: #fff;
                border: 1px solid #e5e7eb;
                border-radius: 6px;
                text-decoration: none;
                transition: all 0.2s ease-in-out;
            }

            .page-link:hover {
                z-index: 2;
                color: #1f2937;
                background-color: #f3f4f6;
                border-color: #e5e7eb;
            }

            .page-item.active .page-link {
                z-index: 3;
                color: #fff;
                background-color: #0d6efd;
                border-color: #0d6efd;
            }

            .page-item.disabled .page-link {
                color: #9ca3af;
                pointer-events: none;
                background-color: #f9fafb;
                border-color: #e5e7eb;
            }

            /* Responsive adjustments */
            @media (max-width: 576px) {
                .d-flex.justify-content-between.align-items-center {
                    flex-direction: column;
                    gap: 1rem;
                }

                .text-muted.small {
                    text-align: center;
                    margin-bottom: 0.5rem;
                }

                .pagination {
                    justify-content: center;
                    flex-wrap: wrap;
                }
            }

            .form-check-input:checked {
                background-color: #0d6efd;
                border-color: #0d6efd;
            }

            .form-floating button.btn-link {
                padding: 0.375rem 0.75rem;
                z-index: 4;
            }

            .form-floating button.btn-link:hover {
                color: var(--bs-primary);
            }

            #yearGrid button {
                transition: all 0.2s;
            }

            #yearGrid button:hover:not(.btn-primary) {
                transform: scale(1.05);
            }

            .filter-options {
                transition: all 0.3s ease-in-out;
            }

            .form-check-input:checked {
                background-color: #0d6efd;
                border-color: #0d6efd;
            }

            .form-check-input:disabled {
                opacity: 0.5;
                cursor: not-allowed;
            }
        </style>
    @endpush
@endsection
