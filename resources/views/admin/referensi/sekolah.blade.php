@extends('admin.layout')
@section('content')
    @php
    $skl = session('identitas_sekolah');
    $cek_user = new App\Models\User();
    $sekolah = new App\Models\IdentitasSekolah();
    $kota = new App\Models\Kota();
    
    $cek_user = $cek_user->where('id_identitas_sekolah', $skl->id_identitas_sekolah)->first();
    $dta = $sekolah->where('id_identitas_sekolah', $skl->id_identitas_sekolah)->first();
    $kota = $kota->where('provinsi_id', 27)->get();
    $ex = explode('||', $dta->api_wablas);
    @endphp

    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-baseline flex-wrap mr-5">
                <h5 class="text-dark font-weight-bold my-1 mr-5">Sekolah</h5>
                <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Admin Page</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Referensi</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Sekolah</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <h3 class="card-title">Data Indentitas Sekolah</h3>
                </div>
                <!--begin::Form-->
                <form method="post" action="{{ url('admin/' . $skl->keyword . '/update/sekolah') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="card-body pt-3 pb-2">
                        @if (!$cek_user)
                            <div class="form-group mb-2 mt-0">
                                <div class="alert alert-custom alert-danger py-4" role="alert">
                                    <div class="alert-icon">
                                        <i class="fa fa-info-circle"></i>
                                    </div>
                                    <div class="alert-text">
                                        <b>PENTING</b> - Admin untuk Unit ini belum ada, <a href="{{ url('admin/' . $skl->keyword . '/user/administrator') }}"
                                            class="text-white"><u>Klik disini</u></a> untuk menambahkan, dan Pastikan
                                        semua data dimenu Referensi Dilengkapi!
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-3 col-form-label">Nama Sekolah</label>
                                    <div class="col-9">
                                        <input type="hidden" name="id_identitas_sekolah"
                                            value="{{ $dta->id_identitas_sekolah }}">
                                        <input class="form-control" type="text" value="{{ $dta->nama_sekolah }}"
                                            name="nama_sekolah" placeholder="Nama Sekolah.." />
                                    </div>
                                </div>
                                <div class="form-group row mb-2">
                                    <label class="col-3 col-form-label">NPSN</label>
                                    <div class="col-9">
                                        <input class="form-control" type="number" value="{{ $dta->npsn }}" name="npsn"
                                            placeholder="NPSN.." />
                                    </div>
                                </div>
                                <div class="form-group row mb-2">
                                    <label class="col-3 col-form-label">Alamat Sekolah</label>
                                    <div class="col-9">
                                        <input class="form-control" type="text" value="{{ $dta->alamat_sekolah }}"
                                            name="alamat_sekolah" placeholder="Alamat Sekolah.." />
                                    </div>
                                </div>
                                <div class="form-group row mb-2">
                                    <label class="col-3 col-form-label">Kode Pos</label>
                                    <div class="col-9">
                                        <input class="form-control" type="number" value="{{ $dta->kode_pos }}"
                                            name="kode_pos" placeholder="Kode Pos.." />
                                    </div>
                                </div>
                                <div class="form-group row mb-2">
                                    <label class="col-3 col-form-label">Kelurahan</label>
                                    <div class="col-9">
                                        <input class="form-control" type="text" value="{{ $dta->kelurahan }}"
                                            name="kelurahan" placeholder="Kelurahan.." />
                                    </div>
                                </div>
                                <div class="form-group row mb-2">
                                    <label class="col-3 col-form-label">Kecamatan</label>
                                    <div class="col-9">
                                        <input class="form-control" type="text" value="{{ $dta->kecamatan }}"
                                            name="kecamatan" placeholder="Kecamatan.." />
                                    </div>
                                </div>
                                <div class="form-group row mb-2">
                                    <label class="col-3 col-form-label">Kabupaten/Kota</label>
                                    <div class="col-9">
                                        <select name="kabupaten_kota" id="kabupaten_kota" class="form-control select2" style="width: 100%">
                                            <option value="">.::Pilih Kabupaten/Kota::.</option>
                                            @foreach ($kota as $kta)
                                                <option value="{{ $kta->nama_kota }}">{{ $kta->nama_kota }}</option>
                                            @endforeach
                                        </select>
                                        <script>
                                            document.getElementById("kabupaten_kota").value = "{{ $dta->kabupaten_kota }}";
                                        </script>
                                        {{-- <input class="form-control" type="text" value="{{ $dta->kabupaten_kota }}"
                                            name="kabupaten_kota" placeholder="Kabupaten/Kota.." /> --}}
                                    </div>
                                </div>
                                <div class="form-group row mb-2">
                                    <label class="col-3 col-form-label">Provinsi</label>
                                    <div class="col-9">
                                        <input class="form-control" type="text" value="{{ $dta->provinsi }}"
                                            name="provinsi" placeholder="Provinsi.." />
                                    </div>
                                </div>
                                <div class="form-group row mb-2">
                                    <label class="col-3 col-form-label">Domain Wablas</label>
                                    <div class="col-9">
                                        <input class="form-control" type="url"
                                            value="{{ isset($ex[2]) ? $ex[2] : '' }}" name="domain_web"
                                            placeholder="Domain Wablas.Com.." />
                                    </div>
                                </div>
                                <div class="form-group row mb-2">
                                    <label class="col-3 col-form-label">API Wablas</label>
                                    <div class="col-9">
                                        <input class="form-control" type="text"
                                            value="{{ isset($ex[0]) ? $ex[0] : '' }}" name="api_web"
                                            placeholder="API Wablas.." />
                                        <small class="text-muted">*API Notifikasi untuk tiket dan Kirim Notif WA
                                            PPDB</small>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group row mb-2">
                                    <label class="col-3 col-form-label">Notif WA (Tiket)</label>
                                    <div class="col-9">
                                        <input class="form-control" type="text"
                                            value="{{ isset($ex[1]) ? $ex[1] : '' }}" name="no_wa"
                                            placeholder="Notif WA (Tiket).." />
                                        <small class="text-muted">No Tujuan (WA) untuk menerima Notifikasi Proses
                                            Tiket</small>
                                    </div>
                                </div>
                                <div class="form-group row mb-2">
                                    <label class="col-3 col-form-label">No Telepon</label>
                                    <div class="col-9">
                                        <input class="form-control" type="text" value="{{ $dta->no_telpon }}"
                                            name="no_telpon" placeholder="No Telepon.." />
                                    </div>
                                </div>
                                <div class="form-group row mb-2">
                                    <label class="col-3 col-form-label">Website</label>
                                    <div class="col-9">
                                        <input class="form-control" type="text" value="{{ $dta->website }}"
                                            name="website" placeholder="Website.." />
                                    </div>
                                </div>
                                <div class="form-group row mb-2">
                                    <label class="col-3 col-form-label">Email</label>
                                    <div class="col-9">
                                        <input class="form-control" type="text" value="{{ $dta->email }}" name="email"
                                            placeholder="Email.." />
                                    </div>
                                </div>
                                <div class="form-group row mb-2">
                                    <label class="col-3 col-form-label">Tgl Rapor 1</label>
                                    <div class="col-9">
                                        <input class="form-control" type="text" value="{{ $dta->tanggal_rapor1 }}"
                                            name="tanggal_rapor1" placeholder="Tgl Rapor 1.." />
                                    </div>
                                </div>
                                <div class="form-group row mb-2">
                                    <label class="col-3 col-form-label">Tgl Rapor 2</label>
                                    <div class="col-9">
                                        <input class="form-control" type="text" value="{{ $dta->tanggal_rapor2 }}"
                                            name="tanggal_rapor2" placeholder="Tgl Rapor 2.." />
                                    </div>
                                </div>
                                <div class="form-group row mb-2">
                                    <label class="col-3 col-form-label">Logo 1</label>
                                    <div class="col-9">
                                        <input class="form-control" type="file" name="logo1_" />
                                        <span class="text-danger">Logo 1 Saat ini : <a
                                                href="{{ asset('img/sekolah/' . $dta->logo1) }}"
                                                target="_blank">{{ $dta->logo1 }}</a></span>
                                    </div>
                                </div>
                                <div class="form-group row mb-2">
                                    <label class="col-3 col-form-label">Logo 2</label>
                                    <div class="col-9">
                                        <input class="form-control" type="file" name="logo2_" />
                                        <span class="text-danger">Logo 2 Saat ini : <a
                                                href="{{ asset('img/sekolah/' . $dta->logo2) }}"
                                                target="_blank">{{ $dta->logo2 }}</a></span>
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
                                <button type="button" class="btn btn-warning">Singkronisasi Data</button>
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
            $('#nav-sekolah').addClass('menu-item-active').parents('.menu-item-submenu').addClass(
                'menu-item-active menu-item-open');
        })
    </script>
@endsection
