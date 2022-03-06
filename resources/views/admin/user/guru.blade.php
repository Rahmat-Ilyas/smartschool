@extends('admin.layout')
@section('content')
    @php
    $skl = session('identitas_sekolah');
    $gurus = new App\Models\Guru();
    $modul = new App\Models\Modul();

    $guru = $gurus->where('id_identitas_sekolah', $skl->id_identitas_sekolah)->get();
    $modul = $modul->where('publish', 'Y')->where('status', 'user')->orderBy('id_modul', 'desc')->get();
    @endphp

    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-baseline flex-wrap mr-5">
                <h5 class="text-dark font-weight-bold my-1 mr-5">Guru</h5>
                <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Admin Page</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">User (Pengguna)</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Guru</a>
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
                        <h3 class="card-label">Data Guru
                            <span class="d-block text-muted pt-2 font-size-sm">Kelola data guru</span>
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
                                <th>NIP</th>
                                <th>Nama Lengkap</th>
                                <th>Email</th>
                                <th>Member</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($guru as $no => $dta)
                            @php
                            if ($dta->member($dta->id_guru)) {
                                if ($dta->member($dta->id_guru)->aktif_sampai > date('Y-m-d H:i:s')) {
                                    $t1 = strtotime(date('Y-m-d H:i:s'));
                                    $t2 = strtotime($dta->member($dta->id_guru)->aktif_sampai);
                                    $sisa =  $t2-$t1;
                                    $sisa = $sisa / 60 / 60 / 24;
                                    $member = '<span class="text-success font-italic">'.ceil($sisa).' Hari Lagi</span>';
                                }
                                else
                                $member = '<span class="text-danger font-italic">Non-Aktif</span>';
                            } else $member = '-'
                            @endphp
                                <tr>
                                    <td>{{ $no + 1 }}</td>
                                    <td>{{ $dta->nip }}</td>
                                    <td>{{ $dta->nama_guru }}</td>
                                    <td>{{ $dta->email }}</td>
                                    <td>{!! $member !!}</td>
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
                <form method="post" action="{{ url('admin/' . $skl->keyword . '/store/administrator') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="container">
                            <div class="form-group row mb-3">
                                <label class="col-3 col-form-label">Username</label>
                                <div class="col-9">
                                    <input type="hidden" name="id_identitas_sekolah"
                                        value="{{ $skl->id_identitas_sekolah }}">
                                    <input class="form-control" type="text" name="username" placeholder="Username.." value="{{ old('username') }}" required />
                                    @if ($errors->has('username'))
                                        <span class="text-danger">{{ $errors->first('username') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="col-3 col-form-label">Password</label>
                                <div class="col-9">
                                    <input class="form-control" type="password" value="" name="password"
                                        placeholder="Password.." value="{{ old('password') }}" required />
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="col-3 col-form-label">Nama Lengkap</label>
                                <div class="col-9">
                                    <input class="form-control" type="text" value="" name="nama_lengkap"
                                        placeholder="Nama Lengkap.." value="{{ old('nama_lengkap') }}" required />
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="col-3 col-form-label">Alamat Email</label>
                                <div class="col-9">
                                    <input class="form-control" type="email" name="email" placeholder="Alamat Email.." value="{{ old('email') }}" />
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="col-3 col-form-label">Telepon</label>
                                <div class="col-9">
                                    <input class="form-control" type="number" name="no_telpon" placeholder="Telepon.." value="{{ old('no_telpon') }}" />
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="col-3 col-form-label">Foto</label>
                                <div class="col-9">
                                    <input class="form-control" type="file" name="foto_" />
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

    @foreach ($guru as $no => $dta)
        <!-- Modal Edit -->
        <div class="modal fade" id="modal-edit{{ $no }}" data-backdrop="static" role="dialog"
            aria-labelledby="modal-edit" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-editLabel">Edit Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <form method="post" action="{{ url('admin/' . $skl->keyword . '/update/administrator') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="container">
                                <div class="form-group row mb-3">
                                    <label class="col-3 col-form-label">Username</label>
                                    <div class="col-9">
                                        <input type="hidden" name="id_user" value="{{ $dta->id_user }}">
                                        <input type="hidden" name="level" value="{{ $dta->level }}">
                                        <input class="form-control" readonly type="text" value="{{ $dta->username }}"
                                            name="username" placeholder="Username.." required />
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label class="col-3 col-form-label">Password</label>
                                    <div class="col-9">
                                        <input class="form-control" type="password" value="" name="password"
                                            placeholder="Password.." />
                                        <small class="font-italic text-muted">Biarkan Kosong Jika Tidak diganti!</small>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label class="col-3 col-form-label">Alamat Email</label>
                                    <div class="col-9">
                                        <input class="form-control" type="email" value="{{ $dta->email }}" name="email"
                                            placeholder="Alamat Email.." />
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label class="col-3 col-form-label">Telepon</label>
                                    <div class="col-9">
                                        <input class="form-control" type="number" value="{{ $dta->no_telpon }}"
                                            name="no_telpon" placeholder="Telepon.." />
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label class="col-3 col-form-label">Foto</label>
                                    <div class="col-9">
                                        <input class="form-control" type="file" name="foto_" />
                                        <input type="hidden" name="foto" value="{{ $dta->foto }}" />
                                        <small class="font-italic text-danger">Foto saat ini: <a href="{{ asset('img/admin/' . $dta->foto) }}"target="_blank">{{ $dta->foto }}</a></small>
                                    </div>
                                </div>
                                @if ($dta->level != 'admin')
                                    <div class="form-group row mb-3">
                                        <label class="col-3 col-form-label">Hak Akses</label>
                                        <div class="col-9">
                                            <select class="form-control select-modul" id="id_modul{{ $no }}"
                                                name="akses[]" multiple data-placeholder="Tambahkan hak akses">
                                                @foreach ($modul as $mdl)
                                                    <option value="{{ $mdl->id_modul }}">{{ $mdl->nama_modul }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endif
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
                        action="{{ url('admin/' . $skl->keyword . '/delete/administrator/' . $dta->id_user) }}">
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
            $('#nav-guru').addClass('menu-item-active').parents('.menu-item-submenu').addClass(
                'menu-item-active menu-item-open');

            $('.select-modul').select2({
                placeholder: "Tambahkan hak akses",
                width: '100%',
            });
        })
    </script>
@endsection
