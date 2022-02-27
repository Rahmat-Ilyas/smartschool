@extends('admin.layout')
@section('content')
    @php
    $skl = session('identitas_sekolah');
    $tingkat = new App\Models\Tingkat();
    $kurikulum = new App\Models\Kurikulum();
    $raport = new App\Models\Raport();

    $tingkat = $tingkat->where('id_identitas_sekolah', $skl->id_identitas_sekolah)->get();
    @endphp

    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-baseline flex-wrap mr-5">
                <h5 class="text-dark font-weight-bold my-1 mr-5">Tingkat</h5>
                <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Admin Page</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Referensi</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Tingkat</a>
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
                        <h3 class="card-label">Data Tingkat
                            <span class="d-block text-muted pt-2 font-size-sm">Kelola data tingkta</span>
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
                                <th>Kode Tingkat</th>
                                <th>Nama Tingkat</th>
                                <th>Nama Kurikulum</th>
                                <th>Model Report</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tingkat as $no => $dta)
                                <tr>
                                    <td>{{ $no + 1 }}</td>
                                    <td>{{ $dta->kode_tingkat }}</td>
                                    <td>{{ $dta->keterangan }}</td>
                                    <td>{{ $dta->kurikulum->nama_kurikulum }}</td>
                                    <td>{{ $dta->raport->nama_raport }}</td>
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
                <form method="post" action="{{ url('admin/' . $skl->keyword . '/store/tingkat') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="container">
                            <div class="form-group row mb-3">
                                <label class="col-3 col-form-label">Nama Kurikulum</label>
                                <div class="col-9">
                                    <input type="hidden" name="id_identitas_sekolah" value="{{ $skl->id_identitas_sekolah }}">
                                    <select class="form-control" name="kode_kurikulum" required>
                                        @foreach ($kurikulum->all() as $krl)
                                            <option value="{{ $krl->kode_kurikulum }}">{{ $krl->nama_kurikulum }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="col-3 col-form-label">Kode Tingkat</label>
                                <div class="col-9">
                                    <input class="form-control" type="text" name="kode_tingkat"
                                        placeholder="Kode Tingkat.." required />
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="col-3 col-form-label">Nama Tingkat</label>
                                <div class="col-9">
                                    <input class="form-control" type="text" name="keterangan" placeholder="Nama Tingkat.."
                                        required />
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="col-3 col-form-label">Raport</label>
                                <div class="col-9">
                                    <select class="form-control" name="id_raport" required>
                                        <option value="">.::Pilih Raport::.</option>
                                        @foreach ($raport->all() as $rpr)
                                            <option value="{{ $rpr->id_raport }}">{{ $rpr->nama_raport }}</option>
                                        @endforeach
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

    @foreach ($tingkat as $no => $dta)
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
                    <form method="post" action="{{ url('admin/' . $skl->keyword . '/update/tingkat') }}">
                        @csrf
                        <div class="modal-body">
                            <div class="container">
                                <div class="form-group row mb-3">
                                    <label class="col-3 col-form-label">Nama Kurikulum</label>
                                    <div class="col-9">
                                        <input type="hidden" name="id_tingkat" value="{{ $dta->id_tingkat }}">
                                        <select class="form-control" name="kode_kurikulum"
                                            id="kode_kurikulum{{ $no }}" required>
                                            @foreach ($kurikulum->all() as $krl)
                                                <option value="{{ $krl->kode_kurikulum }}">{{ $krl->nama_kurikulum }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <script>
                                            document.getElementById("kode_kurikulum{{ $no }}").value = "{{ $dta->kode_kurikulum }}";
                                        </script>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label class="col-3 col-form-label">Kode Tingkat</label>
                                    <div class="col-9">
                                        <input class="form-control" type="text" value="{{ $dta->kode_tingkat }}"
                                            name="kode_tingkat" placeholder="Kode Tingkat.." required />
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label class="col-3 col-form-label">Nama Tingkat</label>
                                    <div class="col-9">
                                        <input class="form-control" type="text" value="{{ $dta->keterangan }}"
                                            name="keterangan" placeholder="Nama Tingkat.." required />
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label class="col-3 col-form-label">Raport</label>
                                    <div class="col-9">
                                        <select class="form-control" name="id_raport" id="id_raport{{ $no }}"
                                            required>
                                            <option value="">.::Pilih Raport::.</option>
                                            @foreach ($raport->all() as $rpr)
                                                <option value="{{ $rpr->id_raport }}">{{ $rpr->nama_raport }}</option>
                                            @endforeach
                                        </select>
                                        <script>
                                            document.getElementById("id_raport{{ $no }}").value = "{{ $dta->id_raport }}";
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
        <div class="modal fade" id="modal-delete{{ $no }}" data-backdrop="static" tabindex="-1" role="dialog"
            aria-labelledby="modal-delete" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-deleteLabel">Hapus Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <form method="post" action="{{ url('admin/' . $skl->keyword . '/delete/tingkat/'.$dta->id_tingkat) }}">
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
            $('#nav-tingkat').addClass('menu-item-active').parents('.menu-item-submenu').addClass(
                'menu-item-active menu-item-open');
        })
    </script>
@endsection
