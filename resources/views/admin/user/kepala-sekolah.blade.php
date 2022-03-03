@extends('admin.layout')
@section('content')
    @php
    $skl = session('identitas_sekolah');
    $user = new App\Models\User();
    $dta = $user->where('id_identitas_sekolah', $skl->id_identitas_sekolah)->where('level', 'kepala')->first();
    @endphp

    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-baseline flex-wrap mr-5">
                <h5 class="text-dark font-weight-bold my-1 mr-5">Kepala Sekolah</h5>
                <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Admin Page</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">User (Pengguna)</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Kepala Sekolah</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <h3 class="card-title">Data Kepala Sekolah</h3>
                </div>
                <!--begin::Form-->
                <form method="post" action="{{ url('admin/' . $skl->keyword . '/update/sekolah') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="card-body pt-3 pb-2">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group row mb-2">
                                    <label class="col-3 col-form-label">Username</label>
                                    <div class="col-9">
                                        <input type="hidden" name="id_identitas_sekolah" value="{{ $skl->id_identitas_sekolah }}">
                                        <input class="form-control" type="text" value="{{ $dta->username }}"
                                            name="username" placeholder="Username.." />
                                        <small class="text-italic text-danger"><b>Penting!</b> - Pastikan Username ini sama dengan NIY / NIP Kepala Sekolah Pada Data Guru</small>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label class="col-3 col-form-label">Nama Lengkap</label>
                                    <div class="col-9">
                                        <input class="form-control" type="text" value="{{ $dta->nama_lengkap }}" name="nama_lengkap"
                                            placeholder="Nama Lengkap.." />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end: Code-->
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-success mr-2">Update Data</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        $(document).ready(function() {
            $('#nav-kelompok-mapel').addClass('menu-item-active').parents('.menu-item-submenu').addClass(
                'menu-item-active menu-item-open');
        })
    </script>
@endsection
