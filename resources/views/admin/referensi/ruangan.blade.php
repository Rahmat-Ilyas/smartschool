@extends('admin.layout')
@section('content')
    @php
    $skl = session('identitas_sekolah');
    $ruangan = new App\Models\Ruangan();
    $gedung = new App\Models\Gedung();
    $gedung = $gedung->where('id_identitas_sekolah', $skl->id_identitas_sekolah)->get();
    $ruangan = $ruangan->get_ruangan($skl->id_identitas_sekolah);
    @endphp

    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-baseline flex-wrap mr-5">
                <h5 class="text-dark font-weight-bold my-1 mr-5">Ruangan</h5>
                <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Admin Page</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Referensi</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Ruangan</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom gutter-b">
                <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title">
                        <h3 class="card-label">Data Ruangan
                            <span class="d-block text-muted pt-2 font-size-sm">Kelola data gedung</span>
                        </h3>
                    </div>
                    <div class="card-toolbar">
                        <a href="#" class="btn btn-primary font-weight-bolder" data-toggle="modal"
                            data-target="#modal-add"><i class="la la-plus"></i> Tambahkan
                            Data</a>
                    </div>
                </div>
                <hr class="mb-0">
                <div class="card-body">
                    <!--begin: Datatable-->
                    <table class="table table-separate table-head-custom table-checkable" id="dataTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Gedung</th>
                                <th>Kode Ruangan</th>
                                <th>Nama Ruangan</th>
                                <th>Kapasitas Belajar</th>
                                <th>Kapasitas Ujian</th>
                                <th>Aktif</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ruangan as $no => $dta)
                                <tr>
                                    <td>{{ $no + 1 }}</td>
                                    <td>{{ $dta->gedung->nama_gedung }}</td>
                                    <td>{{ $dta->kode_ruangan }}</td>
                                    <td>{{ $dta->nama_ruangan }}</td>
                                    <td>{{ $dta->kapasitas_belajar }} Orang</td>
                                    <td>{{ $dta->kapasitas_ujian }} Orang</td>
                                    <td>{{ $dta->aktif }}</td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-clean btn-icon" data-toggle="modal"
                                            data-target="#modal-edit{{ $no }}" data-toggle1="tooltip"
                                            title="Edit details">
                                            <i class="la la-edit text-success"></i>
                                        </a>
                                        <a href="#" class="btn btn-sm btn-clean btn-icon" data-toggle="modal"
                                            data-target="#modal-delete{{ $no }}" data-toggle1="tooltip"
                                            title="Delete">
                                            <i class="la la-trash text-danger"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!--end: Datatable-->
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah -->
    <div class="modal fade" id="modal-add" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="modal-add" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-addLabel">Tambah Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <form method="post" action="{{ url('admin/' . $skl->keyword . '/store/ruangan') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="container">
                            <div class="form-group row mb-3">
                                <label class="col-3 col-form-label">Nama Gedung</label>
                                <div class="col-9">
                                    <select class="form-control" name="id_gedung" required>
                                        <option value="">.::Pilih Gedung::.</option>
                                        @foreach ($gedung as $gdng)
                                            <option value="{{ $gdng->id_gedung }}">{{ $gdng->nama_gedung }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="col-3 col-form-label">Kode Ruangan</label>
                                <div class="col-9">
                                    <input class="form-control" type="text" name="kode_ruangan" placeholder="Kode Ruangan.." required />
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="col-3 col-form-label">Nama Ruangan</label>
                                <div class="col-9">
                                    <input class="form-control" type="text" name="nama_ruangan" placeholder="Nama Ruangan.." required />
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="col-3 col-form-label">Kapasitas Belajar (org)</label>
                                <div class="col-9">
                                    <input class="form-control" type="number" name="kapasitas_belajar" placeholder="Kapasitas Belajar.." required />
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="col-3 col-form-label">Kapasitas Ujian (org)</label>
                                <div class="col-9">
                                    <input class="form-control" type="number" name="kapasitas_ujian" placeholder="Kapasitas Ujian.." required />
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="col-3 col-form-label">Keterangan</label>
                                <div class="col-9">
                                    <input class="form-control" type="text" name="keterangan"
                                        placeholder="Keterangan.." />
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="col-3 col-form-label">Aktif</label>
                                <div class="col-9">
                                    <select class="form-control" name="aktif" required>
                                        <option value="Ya">Ya</option>
                                        <option value="Tidak">Tidak</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-primary font-weight-bold"
                            data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-success font-weight-bold">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @foreach ($ruangan as $no => $dta)
        <!-- Modal Edit -->
        <div class="modal fade" id="modal-edit{{ $no }}" data-backdrop="static" tabindex="-1" role="dialog"
            aria-labelledby="modal-edit" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-editLabel">Edit Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <form method="post" action="{{ url('admin/' . $skl->keyword . '/update/ruangan') }}">
                        @csrf
                        <div class="modal-body">
                            <div class="container">
                                <div class="form-group row mb-3">
                                    <label class="col-3 col-form-label">Nama Gedung</label>
                                    <div class="col-9">
                                        <input type="hidden" name="id_ruangan" value="{{ $dta->id_ruangan }}">
                                        <select class="form-control" name="id_gedung" id="id_gedung{{ $no }}"
                                            required>
                                            <option value="">.::Pilih Gedung::.</option>
                                            @foreach ($gedung as $gdng)
                                                <option value="{{ $gdng->id_gedung }}">{{ $gdng->nama_gedung }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <script>
                                            document.getElementById("id_gedung{{ $no }}").value = "{{ $dta->id_gedung }}";
                                        </script>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label class="col-3 col-form-label">Kode Ruangan</label>
                                    <div class="col-9">
                                        <input class="form-control" type="text" value="{{ $dta->kode_ruangan }}"
                                            name="kode_ruangan" placeholder="Kode Ruangan.." required />
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label class="col-3 col-form-label">Nama Ruangan</label>
                                    <div class="col-9">
                                        <input class="form-control" type="text" value="{{ $dta->nama_ruangan }}"
                                            name="nama_ruangan" placeholder="Nama Ruangan.." required />
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label class="col-3 col-form-label">Kapasitas Belajar (org)</label>
                                    <div class="col-9">
                                        <input class="form-control" type="number" value="{{ $dta->kapasitas_belajar }}"
                                            name="kapasitas_belajar" placeholder="Kapasitas Belajar.." required />
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label class="col-3 col-form-label">Kapasitas Ujian (org)</label>
                                    <div class="col-9">
                                        <input class="form-control" type="number" value="{{ $dta->kapasitas_ujian }}"
                                            name="kapasitas_ujian" placeholder="Kapasitas Ujian.." required />
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label class="col-3 col-form-label">Keterangan</label>
                                    <div class="col-9">
                                        <input class="form-control" type="text" value="{{ $dta->keterangan }}"
                                            name="keterangan" placeholder="Keterangan.." />
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label class="col-3 col-form-label">Aktif</label>
                                    <div class="col-9">
                                        <select class="form-control" name="aktif" id="is_aktif{{ $no }}"
                                            required>
                                            <option value="Ya">Ya</option>
                                            <option value="Tidak">Tidak</option>
                                        </select>
                                        <script>
                                            document.getElementById("is_aktif{{ $no }}").value = "{{ $dta->aktif }}";
                                        </script>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-primary font-weight-bold"
                                data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-success font-weight-bold">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Hapus -->
        <div class="modal fade" id="modal-delete{{ $no }}" data-backdrop="static" tabindex="-1"
            role="dialog" aria-labelledby="modal-delete" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-deleteLabel">Hapus Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <form method="post"
                        action="{{ url('admin/' . $skl->keyword . '/delete/ruangan/' . $dta->id_ruangan) }}">
                        @csrf
                        <div class="modal-body">
                            <p>Apa anda yakin untuk hapus Data ini?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-primary font-weight-bold"
                                data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-danger font-weight-bold">Lanjutkan Hapus</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection

@section('javascript')
    <script>
        $(document).ready(function() {
            $('#nav-ruangan').addClass('menu-item-active').parents('.menu-item-submenu').addClass(
                'menu-item-active menu-item-open');
        })
    </script>
@endsection
