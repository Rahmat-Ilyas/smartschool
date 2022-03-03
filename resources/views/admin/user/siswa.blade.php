@extends('admin.layout')
@section('content')
    @php
    $skl = session('identitas_sekolah');
    $siswas = new App\Models\Siswa();
    $kelas_ = new App\Models\Kelas();

    $angkatan = [];
    $get_angkatan = $siswas->select('angkatan')->where('id_identitas_sekolah', $skl->id_identitas_sekolah)->groupBy('angkatan')->orderBy('angkatan', 'desc')->get();
    foreach ($get_angkatan as $sws) {
        $angkatan[] = $sws->angkatan;
    }

    $set_angkatan = request()->get('angkatan') ? request()->get('angkatan') : $angkatan[0];
    $set_kelas = request()->get('kelas') ? request()->get('kelas') : null;
    if ($set_kelas) {
        $siswa = $siswas->where('id_identitas_sekolah', $skl->id_identitas_sekolah)->where('angkatan', $set_angkatan)->where('id_kelas', $set_kelas)->get();
        $class_name = $kelas_->where('id_kelas', $set_kelas)->first()->nama_kelas;
    } else {
        $siswa = $siswas->where('id_identitas_sekolah', $skl->id_identitas_sekolah)->where('angkatan', $set_angkatan)->get();
    }
    
    $kelas = $kelas_->where('id_identitas_sekolah', $skl->id_identitas_sekolah)->get();
    @endphp

    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-baseline flex-wrap mr-5">
                <h5 class="text-dark font-weight-bold my-1 mr-5">Siswa</h5>
                <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Admin Page</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">User (Pengguna)</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Siswa</a>
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
                        <h3 class="card-label">Data Siswa
                            <span class="d-block text-muted pt-2 font-size-sm">Kelola data siswa</span>
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
                            <label><b>Lihat Berdasarkan:</b></label>
                        </div>
                        <div class="col-sm-2">
                            <label>Angkatan</label>
                            <select name="" id="set_angkatan" class="form-control form-control-sm">
                                @foreach ($angkatan as $agk)
                                    <option value="{{ $agk }}">{{ $agk }}</option>
                                @endforeach
                            </select>
                            <script>
                                document.getElementById("set_angkatan").value = "{{ $set_angkatan }}";
                            </script>
                        </div>
                        <div class="col-sm-3">
                            <label>Kelas</label>
                            <select name="" id="set_kelas" class="form-control form-control-sm">
                                <option value="">.::Pilih Kelas::.</option>
                                @foreach ($kelas as $kls)
                                    <option value="{{ $kls->id_kelas }}">{{ $kls->nama_kelas }}</option>
                                @endforeach
                            </select>
                            <script>
                                document.getElementById("set_kelas").value = "{{ $set_kelas }}";
                            </script>
                        </div>
                        <div class="col-sm-3 pt-8">
                            <button class="btn btn-secondary btn-sm"><i class="fa fa-print"></i> Cetak Data</button>
                        </div>
                    </div>
                    <hr>
                    <h4 class="text-center">Data Siswa Angkatan {{ $set_angkatan }} {{ $set_kelas ? $class_name : '' }}</h4>
                    <!--begin: Datatable-->
                    <table class="table table-separate table-head-custom table-checkable mt-2" id="dataTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NIPD</th>
                                <th>NISN</th>
                                <th>Nama Siswa</th>
                                <th>Angkatan</th>
                                <th>Sesi</th>
                                <th>Jurusan</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($siswa as $no => $dta)
                                <tr>
                                    <td>{{ $no + 1 }}</td>
                                    <td>{{ $dta->nipd }}</td>
                                    <td>{{ $dta->nisn }}</td>
                                    <td>{{ $dta->nama }}</td>
                                    <td>{{ $dta->angkatan }}</td>
                                    <td>{{ $dta->id_sesi }}</td>
                                    <td>{{ $dta->jurusan->nama_jurusan }}</td>
                                    <td class="text-{{ $dta->status_siswa == 'Aktif' ? 'success' : 'warning' }}">
                                        {{ $dta->status_siswa }}</td>
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
                                    <input type="hidden" name="id_identitas_sekolah"
                                        value="{{ $skl->id_identitas_sekolah }}">
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

    @foreach ($siswa as $no => $dta)
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
                        action="{{ url('admin/' . $skl->keyword . '/delete/tingkat/' . $dta->id_tingkat) }}">
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
            $('#nav-siswa').addClass('menu-item-active').parents('.menu-item-submenu').addClass(
                'menu-item-active menu-item-open');

            $('#set_angkatan').change(function(e) {
                e.preventDefault();
                var angkatan = $(this).val();
                var kelas = $('#set_kelas').val();

                if (kelas) 
                    location.href = "{{ url('admin/' . $skl->keyword . '/user/siswa?angkatan=') }}" + angkatan + "&kelas=" + kelas;
                else 
                    location.href = "{{ url('admin/' . $skl->keyword . '/user/siswa?angkatan=') }}" + angkatan;
            });

            $('#set_kelas').change(function(e) {
                e.preventDefault();
                var kelas = $(this).val();
                var angkatan = $('#set_angkatan').val();
                if (kelas) 
                    location.href = "{{ url('admin/' . $skl->keyword . '/user/siswa?angkatan=') }}" + angkatan + "&kelas=" + kelas;
                else 
                    location.href = "{{ url('admin/' . $skl->keyword . '/user/siswa?angkatan=') }}" + angkatan;
            });
        })
    </script>
@endsection
