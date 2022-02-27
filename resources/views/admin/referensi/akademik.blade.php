@extends('admin.layout')
@section('content')
    @php
    $skl = session('identitas_sekolah');
    $akademik = new App\Models\Akademik();
    $akademik = $akademik
        ->where('id_identitas_sekolah', $skl->id_identitas_sekolah)
        ->orderBy('kode_tahun_akademik', 'asc')
        ->get();
    @endphp

    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-baseline flex-wrap mr-5">
                <h5 class="text-dark font-weight-bold my-1 mr-5">Akademik</h5>
                <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Admin Page</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Referensi</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Akademik</a>
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
                        <h3 class="card-label">Data Tahun Akademik
                            <span class="d-block text-muted pt-2 font-size-sm">Kelola data tahun akademik</span>
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
                    <div class="form-group mb-5" style="margin-top: -10px;">
                        <div class="alert alert-custom alert-primary py-4" role="alert">
                            <div class="alert-icon">
                                <i class="fa fa-info-circle"></i>
                            </div>
                            <div class="alert-text">
                                <b>Format Kode Tahun Harus</b> : Contoh <b>{{ date('Y') }}1</b> artinya
                                <b>{{ date('Y') }}</b> untuk tahun, dan <b>1</b> untuk semester
                            </div>
                        </div>
                        <!--begin: Datatable-->
                        <table class="table table-separate table-head-custom table-checkable" id="dataTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Tahun</th>
                                    <th>Nama Tahun</th>
                                    <th>Keterangan</th>
                                    <th>Jadwal</th>
                                    <th>Aktif</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($akademik as $no => $dta)
                                    <tr>
                                        <td>{{ $no + 1 }}</td>
                                        <td>{{ $dta->kode_tahun_akademik }}</td>
                                        <td>{{ $dta->nama_tahun }}</td>
                                        <td>{{ $dta->keterangan }}</td>
                                        <td class="text-success font-italic">{{ count($dta->jadwal) }} Data</td>
                                        <td>{{ $dta->aktif }}</td>
                                        <td>
                                            <form action="{{ url('admin/' . $skl->keyword . '/update/set_akademik') }}"
                                                method="post">
                                                @csrf
                                                <input type="hidden" name="id_tahun_akademik"
                                                    value="{{ $dta->id_tahun_akademik }}">
                                                <button type="submit" class="btn btn-sm btn-clean btn-icon"
                                                    data-toggle1="tooltip" title="Aktifkan">
                                                    <i
                                                        class="la la-star{{ $dta->aktif == 'Ya' ? '' : '-o' }} text-warning"></i>
                                                </button>
                                                <a href="#" class="btn btn-sm btn-clean btn-icon" data-toggle="modal"
                                                    data-target="#modal-edit{{ $no }}" data-toggle1="tooltip"
                                                    title="Edit details">
                                                    <i class="la la-edit text-success"></i>
                                                </a>
                                            </form>
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
                    <form method="post" action="{{ url('admin/' . $skl->keyword . '/store/akademik') }}">
                        @csrf
                        <div class="modal-body">
                            <div class="container">
                                <div class="form-group row mb-3">
                                    <label class="col-3 col-form-label">Kode Tahun</label>
                                    <div class="col-9">
                                        <input type="hidden" name="id_identitas_sekolah"
                                            value="{{ $skl->id_identitas_sekolah }}">
                                        <input class="form-control" type="number" name="kode_tahun_akademik"
                                            placeholder="Kode Tahun.." required />
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label class="col-3 col-form-label">Nama Tahun</label>
                                    <div class="col-9">
                                        <input class="form-control" type="text" name="nama_tahun"
                                            placeholder="Nama Tahun.." required />
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label class="col-3 col-form-label">Keterangan</label>
                                    <div class="col-9">
                                        <input class="form-control" type="text" name="keterangan"
                                            placeholder="Keterangan.." required />
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

        @foreach ($akademik as $no => $dta)
            <!-- Modal Edit -->
            <div class="modal fade" id="modal-edit{{ $no }}" data-backdrop="static" tabindex="-1"
                role="dialog" aria-labelledby="modal-edit" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modal-editLabel">Edit Data</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i aria-hidden="true" class="ki ki-close"></i>
                            </button>
                        </div>
                        <form method="post" action="{{ url('admin/' . $skl->keyword . '/update/akademik') }}">
                            @csrf
                            <div class="modal-body">
                                <div class="container">
                                    <div class="form-group row mb-3">
                                        <label class="col-3 col-form-label">Kode Tahun</label>
                                        <div class="col-9">
                                            <input type="hidden" name="id_tahun_akademik"
                                                value="{{ $dta->id_tahun_akademik }}">
                                            <input class="form-control" type="number"
                                                value="{{ $dta->kode_tahun_akademik }}" name="kode_tahun_akademik"
                                                placeholder="Kode Tahun.." required />
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <label class="col-3 col-form-label">Nama Tahun</label>
                                        <div class="col-9">
                                            <input class="form-control" type="text" value="{{ $dta->nama_tahun }}"
                                                name="nama_tahun" placeholder="Nama Tahun.." required />
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <label class="col-3 col-form-label">Keterangan</label>
                                        <div class="col-9">
                                            <input class="form-control" type="text" value="{{ $dta->keterangan }}"
                                                name="keterangan" placeholder="Keterangan.." required />
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <label class="col-3 col-form-label">Aktif</label>
                                        <div class="col-9">
                                            <select class="form-control" name="aktif" id="is_aktif{{ $no }}" required>
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
                            action="{{ url('admin/' . $skl->keyword . '/delete/akademik/' . $dta->id_tahun_akademik) }}">
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
                $('#nav-akademik').addClass('menu-item-active').parents('.menu-item-submenu').addClass(
                    'menu-item-active menu-item-open');
            })
        </script>
    @endsection
