@extends('admin.layout')
@section('content')
    @php
    $skl = session('identitas_sekolah');
    $kelas = new App\Models\Kelas();
    $tingkat = new App\Models\Tingkat();
    $guru = new App\Models\Guru();
    $jurusan = new App\Models\Jurusan();
    $ruangan = new App\Models\Ruangan();

    $kelas = $kelas->where('id_identitas_sekolah', $skl->id_identitas_sekolah)->get();
    $tingkat = $tingkat->where('id_identitas_sekolah', $skl->id_identitas_sekolah)->get();
    $guru = $guru->where('id_identitas_sekolah', $skl->id_identitas_sekolah)->get();
    $jurusan = $jurusan->where('id_identitas_sekolah', $skl->id_identitas_sekolah)->get();
    $ruangan = $ruangan->get_ruangan($skl->id_identitas_sekolah);
    @endphp

    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-baseline flex-wrap mr-5">
                <h5 class="text-dark font-weight-bold my-1 mr-5">Jurusan</h5>
                <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Admin Page</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Referensi</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Jurusan</a>
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
                        <h3 class="card-label">Data Jurusan
                            <span class="d-block text-muted pt-2 font-size-sm">Kelola data jurusan</span>
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
                    <!--begin: Datatable-->
                    <table class="table table-separate table-head-custom table-checkable" id="dataTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Kelas</th>
                                <th>Nama Kelas</th>
                                <th>Wali Kelas</th>
                                <th>Jurusan</th>
                                <th>Ruangan</th>
                                <th>Siswa</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kelas as $no => $dta)
                                <tr>
                                    <td>{{ $no + 1 }}</td>
                                    <td>{{ $dta->kode_kelas }}</td>
                                    <td>{{ $dta->nama_kelas }}</td>
                                    <td>{{ $dta->guru->nama_guru }}</td>
                                    <td>{{ $dta->jurusan->nama_jurusan }}</td>
                                    <td>{{ $dta->ruangan->nama_ruangan }}</td>
                                    <td>{{ count($dta->siswa) }} Siswa</td>
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
                <form method="post" action="{{ url('admin/' . $skl->keyword . '/store/kelas') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="container">
                            <div class="form-group row mb-3">
                                <label class="col-3 col-form-label">Kode Kelas</label>
                                <div class="col-9">
                                    <input type="hidden" name="id_identitas_sekolah"
                                        value="{{ $skl->id_identitas_sekolah }}">
                                    <input class="form-control" type="text" name="kode_kelas" placeholder="Kode Kelas.." required />
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="col-3 col-form-label">Tingkat</label>
                                <div class="col-9">
                                    <select class="form-control" name="id_tingkat">
                                        @foreach ($tingkat as $tgkt)
                                            <option value="{{ $tgkt->id_tingkat }}">{{ $tgkt->kode_tingkat }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="col-3 col-form-label">Wali Kelas</label>
                                <div class="col-9">
                                    <select class="form-control select2" style="width: 100%;" name="id_guru" required>
                                        <option value="0">.::Pilih Wali Kelas::.</option>
                                        @foreach ($guru as $gru)
                                            <option value="{{ $gru->id_guru }}">{{ $gru->nama_guru }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="col-3 col-form-label">Jurusan</label>
                                <div class="col-9">
                                    <select class="form-control" name="id_jurusan">
                                        @foreach ($jurusan as $tgkt)
                                            <option value="{{ $tgkt->id_jurusan }}">{{ $tgkt->kode_jurusan }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="col-3 col-form-label">Ruangan</label>
                                <div class="col-9">
                                    <select class="form-control select2" style="width: 100%;" name="id_ruangan" required>
                                        <option value="0">.::Pilih Ruangan::.</option>
                                        @foreach ($ruangan as $gru)
                                            <option value="{{ $gru->id_ruangan }}">{{ $gru->nama_ruangan }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="col-3 col-form-label">Nama Kelas</label>
                                <div class="col-9">
                                    <input class="form-control" type="text" name="nama_kelas" placeholder="Nama Kelas.."
                                        required />
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="col-3 col-form-label">Aktif</label>
                                <div class="col-9">
                                    <select class="form-control" name="aktif">
                                        <option value="Ya">Ya</option>
                                        <option value="Tidak">Tidak</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="col-3 col-form-label">Nilai</label>
                                <div class="col-9">
                                    <select class="form-control" name="nilai">
                                        <option value="aktif">Aktif</option>
                                        <option value="nonaktif">Non Aktif</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="col-3 col-form-label">Daftar Ulang</label>
                                <div class="col-9">
                                    <select class="form-control" name="daftar_ulang">
                                        <option value="Y">Aktif</option>
                                        <option value="N">Non Aktif</option>
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

    @foreach ($kelas as $no => $dta)
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
                    <form method="post" action="{{ url('admin/' . $skl->keyword . '/update/kelas') }}">
                        @csrf
                        <div class="modal-body">
                            <div class="container">
                                <div class="form-group row mb-3">
                                    <label class="col-3 col-form-label">Kode Kelas</label>
                                    <div class="col-9">
                                        <input type="hidden" name="id_kelas" value="{{ $dta->id_kelas }}">
                                        <input class="form-control" type="text" value="{{ $dta->kode_kelas }}"
                                            name="kode_kelas" placeholder="Kode Kelas.." required />
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label class="col-3 col-form-label">Tingkat</label>
                                    <div class="col-9">
                                        <select class="form-control" name="id_tingkat"
                                            id="id_tingkat{{ $no }}">
                                            @foreach ($tingkat as $tgkt)
                                                <option value="{{ $tgkt->id_tingkat }}">{{ $tgkt->kode_tingkat }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <script>
                                            document.getElementById("id_tingkat{{ $no }}").value = "{{ $dta->id_tingkat }}";
                                        </script>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label class="col-3 col-form-label">Wali Kelas</label>
                                    <div class="col-9">
                                        <select class="form-control select2" style="width: 100%;" name="id_guru"
                                            id="id_guru{{ $no }}" required>
                                            <option value="0">.::Pilih Wali Kelas::.</option>
                                            @foreach ($guru as $gru)
                                                <option value="{{ $gru->id_guru }}">{{ $gru->nama_guru }}</option>
                                            @endforeach
                                        </select>
                                        <script>
                                            document.getElementById("id_guru{{ $no }}").value = "{{ $dta->id_guru }}";
                                        </script>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label class="col-3 col-form-label">Jurusan</label>
                                    <div class="col-9">
                                        <select class="form-control" name="id_jurusan"
                                            id="id_jurusan{{ $no }}">
                                            @foreach ($jurusan as $tgkt)
                                                <option value="{{ $tgkt->id_jurusan }}">{{ $tgkt->kode_jurusan }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <script>
                                            document.getElementById("id_jurusan{{ $no }}").value = "{{ $dta->id_jurusan }}";
                                        </script>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label class="col-3 col-form-label">Ruangan</label>
                                    <div class="col-9">
                                        <select class="form-control select2" style="width: 100%;" name="id_ruangan"
                                            id="id_ruangan{{ $no }}" required>
                                            <option value="0">.::Pilih Ruangan::.</option>
                                            @foreach ($ruangan as $gru)
                                                <option value="{{ $gru->id_ruangan }}">{{ $gru->nama_ruangan }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <script>
                                            document.getElementById("id_ruangan{{ $no }}").value = "{{ $dta->id_ruangan }}";
                                        </script>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label class="col-3 col-form-label">Nama Kelas</label>
                                    <div class="col-9">
                                        <input class="form-control" type="text" value="{{ $dta->nama_kelas }}"
                                            name="nama_kelas" placeholder="Nama Kelas.." required />
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
                                <div class="form-group row mb-3">
                                    <label class="col-3 col-form-label">Nilai</label>
                                    <div class="col-9">
                                        <select class="form-control" name="nilai" id="is_nilai{{ $no }}"
                                            required>
                                            <option value="aktif">Aktif</option>
                                            <option value="nonaktif">Non Aktif</option>
                                        </select>
                                        <script>
                                            document.getElementById("is_nilai{{ $no }}").value = "{{ $dta->nilai }}";
                                        </script>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label class="col-3 col-form-label">Daftar Ulang</label>
                                    <div class="col-9">
                                        <select class="form-control" name="daftar_ulang"
                                            id="daftar_ulang{{ $no }}" required>
                                            <option value="Y">Aktif</option>
                                            <option value="N">Non Aktif</option>
                                        </select>
                                        <script>
                                            document.getElementById("daftar_ulang{{ $no }}").value = "{{ $dta->daftar_ulang }}";
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
                    <form method="post" action="{{ url('admin/' . $skl->keyword . '/delete/kelas/' . $dta->id_kelas) }}">
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
            $('.select2').select2();
            $('#nav-kelas').addClass('menu-item-active').parents('.menu-item-submenu').addClass(
                'menu-item-active menu-item-open');
        })
    </script>
@endsection
