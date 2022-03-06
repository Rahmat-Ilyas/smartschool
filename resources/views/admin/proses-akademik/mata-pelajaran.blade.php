@extends('admin.layout')
@section('content')
    @php
    $skl = session('identitas_sekolah');
    $mapel = new App\Models\Mapel();
    $tingkat_ = new App\Models\Tingkat();
    $tingkat = $tingkat_->where('id_identitas_sekolah', $skl->id_identitas_sekolah)->get();
    $tingkat_first = $tingkat_->where('id_identitas_sekolah', $skl->id_identitas_sekolah)->first();
    $set_tingkat = request()->get('tingkat') ? request()->get('tingkat') : $tingkat_first->id_tingkat;

    $mapel = $mapel->where('id_identitas_sekolah', $skl->id_identitas_sekolah)->where('id_tingkat', $set_tingkat)->orderBy('urutan', 'asc')->get();
    @endphp

    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-baseline flex-wrap mr-5">
                <h5 class="text-dark font-weight-bold my-1 mr-5">Mata Pelajaran</h5>
                <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Admin Page</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Proses Akademik</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Mata Pelajaran</a>
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
                        <h3 class="card-label">Data Mata Pelajaran
                            <span class="d-block text-muted pt-2 font-size-sm">Kelola data mata pelajaran</span>
                        </h3>
                    </div>
                    <div class="card-toolbar">
                        <div class="dropdown mr-2">
                            <button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenuButton"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="la la-file-excel"></i> Import Data
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="#">Download Format</a>
                                <a class="dropdown-item" href="#">Pilih & Upload File</a>
                            </div>
                        </div>
                        <a href="#" class="btn btn-primary font-weight-bolder" data-toggle="modal"
                            data-target="#modal-add"><i class="la la-plus"></i> Tambahkan
                            Data</a>
                    </div>
                </div>
                <hr class="mb-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-2 pt-5">
                            <label><b>Lihat Berdasarkan Tingkat:</b></label>
                        </div>
                        <div class="col-sm-2">
                            <label>Pilih Tingkat</label>
                            <select name="" id="set_tingkat" class="form-control form-control-sm">
                                @foreach ($tingkat as $tgkt)
                                    <option value="{{ $tgkt->id_tingkat }}">{{ $tgkt->keterangan }}</option>
                                @endforeach
                            </select>
                            <script>
                                document.getElementById("set_tingkat").value = "{{ $set_tingkat }}";
                            </script>
                        </div>
                    </div>
                    <hr>
                    {{-- <h4 class="text-center">Data Siswa Angkatan {{ $set_angkatan }} {{ $set_kelas ? $class_name : '' }}</h4> --}}

                    <!--begin: Datatable-->
                    <table class="table table-separate table-head-custom table-checkable" id="dataTable">
                        <thead>
                            <tr>
                                <th width="1">No</th>
                                <th>Kode</th>
                                <th>Nama Mapel</th>
                                <th>Jurusan</th>
                                <th>Kelompok</th>
                                <th>KKM</th>
                                <th>Urut</th>
                                <th width=120>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($mapel as $no => $dta)
                                <tr>
                                    <td>{{ $no + 1 }}</td>
                                    <td>{{ $dta->kode_pelajaran }}</td>
                                    <td>
                                        {{ $dta->namamatapelajaran }}
                                        <spann class="text-success font-italic">{{ $dta->karakter ? '('.$dta->karakter.')' : '' }}</spann>
                                        <spann class="text-danger font-italic">{{ $dta->sesi == 1 ? '(Paralel)' : '' }}</spann>
                                    </td>
                                    <td>{{ $dta->jurusan->kode_jurusan }}</td>
                                    <td>
                                        {{ $dta->kelompok_mapel($dta->id_kelompok_mata_pelajaran) ? $dta->kelompok_mapel($dta->id_kelompok_mata_pelajaran)->nama_kelompok_mata_pelajaran : '-' }}
                                    </td>
                                    <td>{{ $dta->kkm }}</td>
                                    <td>{{ $dta->urutan }}</td>
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
                <form method="post" action="{{ url('admin/' . $skl->keyword . '/store/jenis_ptk') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="container">
                            <div class="form-group row mb-3">
                                <label class="col-3 col-form-label">Nama PTK</label>
                                <div class="col-9">
                                    <input type="hidden" name="id_identitas_sekolah" value="{{ $skl->id_identitas_sekolah }}">
                                    <input class="form-control" type="text" name="jenis_ptk" placeholder="Nama PTK.."
                                        required />
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="col-3 col-form-label">Keterangan</label>
                                <div class="col-9">
                                    <input class="form-control" type="text" name="keterangan" placeholder="Keterangan.." />
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

    @foreach ($mapel as $no => $dta)
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
                    <form method="post" action="{{ url('admin/' . $skl->keyword . '/update/jenis_ptk') }}">
                        @csrf
                        <div class="modal-body">
                            <div class="container">
                                <div class="form-group row mb-3">
                                    <label class="col-3 col-form-label">Nama PTK</label>
                                    <div class="col-9">
                                        <input type="hidden" name="id_jenis_ptk" value="{{ $dta->id_jenis_ptk }}">
                                        <input class="form-control" type="text" value="{{ $dta->jenis_ptk }}"
                                            name="jenis_ptk" placeholder="Nama PTK.." required />
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label class="col-3 col-form-label">Keterangan</label>
                                    <div class="col-9">
                                        <input class="form-control" type="text" value="{{ $dta->keterangan }}"
                                            name="keterangan" placeholder="Keterangan.." />
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
                    <form method="post"
                        action="{{ url('admin/' . $skl->keyword . '/delete/jenis_ptk/' . $dta->id_jenis_ptk) }}">
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
            $('#nav-mata-pelajaran').addClass('menu-item-active').parents('.menu-item-submenu').addClass(
                'menu-item-active menu-item-open');

            $('#set_tingkat').change(function(e) {
                e.preventDefault();
                var tingkat = $(this).val();
                location.href = "{{ url('admin/' . $skl->keyword . '/proses-akademik/mata-pelajaran?tingkat=') }}" + tingkat;
            });
        })
    </script>
@endsection
