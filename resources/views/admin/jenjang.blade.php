@php
if (!session('superadmin')) {
    $skl = session('identitas_sekolah');
    header('Location: ' . url('admin/' . $skl->keyword));
    exit();
}

@endphp
<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
    <base href="../../../../">
    <meta charset="utf-8" />
    <title>Pilih Jenjang Sekolah</title>
    <meta name="description" content="Login page example" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Page Custom Styles(used by this page)-->
    <link href="{{ asset('assets/css/pages/login/classic/login-4.css?v=7.0.5') }}" rel="stylesheet" type="text/css" />
    <!--end::Page Custom Styles-->
    <!--begin::Global Theme Styles(used by all pages)-->
    <link href="{{ asset('assets/plugins/global/plugins.bundle.css?v=7.0.5') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/custom/prismjs/prismjs.bundle.css?v=7.0.5') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/css/style.bundle.css?v=7.0.5') }}" rel="stylesheet" type="text/css" />
    <!--end::Global Theme Styles-->
    <!--begin::Layout Themes(used by all pages)-->
    <link href="{{ asset('assets/css/themes/layout/header/base/light.css?v=7.0.5') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/css/themes/layout/header/menu/light.css?v=7.0.5') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/css/themes/layout/brand/dark.css?v=7.0.5') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/themes/layout/aside/dark.css?v=7.0.5') }}" rel="stylesheet" type="text/css" />
    <!--end::Layout Themes-->
    <link rel="shortcut icon" href="{{ asset('assets/media/logos/logo-fav.png') }}" />
</head>
<!--end::Head-->
<!--begin::Body-->

<body>
    @php
        $sekolah = new App\Models\IdentitasSekolah();
        $show = 8;
        $get_skl = $sekolah->paginate($show);
    @endphp
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Subheader-->
        <div class="container mb-4">
            <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
                <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                    <!--begin::Details-->
                    <div class="d-flex align-items-center flex-wrap mr-2">
                        <!--begin::Title-->
                        <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Pilih Jenjang Sekolah</h5>
                        <!--end::Title-->
                        <!--begin::Separator-->
                        <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-5 bg-gray-200"></div>
                        <!--end::Separator-->
                        <!--begin::Search Form-->
                        <div class="d-flex align-items-center" id="kt_subheader_search">
                            <span class="text-dark-50 font-weight-bold" id="kt_subheader_total">Total
                                {{ count($sekolah->get()) }} Sekolah</span>
                            <form class="ml-5">
                                <div class="input-group input-group-sm input-group-solid" style="max-width: 175px">
                                    <input type="text" class="form-control" id="kt_subheader_search_form"
                                        placeholder="Search...">
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="fa fa-search"></i>
                                        </span>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!--end::Search Form-->
                        <div class="d-flex align-items-center ml-30">
                            <label>Sort by Districts</label>
                        </div>
                        <div class="d-flex align-items-center ml-3">
                            <div class="input-group input-group-sm input-group-solid">
                                <select name="" id="" class="form-control">
                                    <option value="">Pilih Kabupaten/Kota</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!--end::Details-->
                    <!--begin::Toolbar-->
                    <div class="d-flex align-items-center">
                        <!--begin::Button-->
                        <a href="#" class=""></a>
                        <!--end::Button-->
                        <!--begin::Button-->
                        <a href="#" class="btn btn-light-primary font-weight-bold ml-2" data-toggle="modal"
                            data-target="#modal-add-unit"><i class="fa fa-plus-circle"></i> Tambah Unit</a>
                        <a href="{{ url('admin/logout') }}"
                            class="btn btn-light-danger font-weight-bold ml-2 pr-2"><i class="fa fa-power-off"></i></a>
                        <!--end::Button-->
                    </div>
                    <!--end::Toolbar-->
                </div>
            </div>
        </div>
        <!--end::Subheader-->
        <!--begin::Entry-->
        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="row">
                    @foreach ($get_skl as $skl)
                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                            <div class="card card-custom gutter-b card-stretch">
                                <div class="card-body">
                                    <div class="align-items-center mb-7">
                                        <div class="text-center">
                                            <div class="flex-shrink-0 mr-4 mt-lg-0 mt-3">
                                                <div class="symbol symbol-lg-80 symbol-circle symbol-primary">
                                                    <span class="symbol-label font-size-h3 font-weight-boldest">
                                                        <i class="fa fa-school fa-lg text-white"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="mb-7 text-center">
                                        <a href="#"
                                            class="text-dark font-weight-bold text-hover-primary font-size-h4 mb-0">{{ strtoupper($skl->nama_sekolah) }}</a><br>
                                        <span class="text-muted font-weight-bold">{{ $skl->alamat_sekolah }}</span>
                                        <hr>
                                    </p>
                                    <div class="mb-7">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="text-dark-75 font-weight-bolder mr-2">NPSN:</span>
                                            <span class="text-muted font-weight-bold">{{ $skl->npsn }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="text-dark-75 font-weight-bolder mr-2">Email:</span>
                                            <a href="#"
                                                class="text-muted text-hover-primary">{{ $skl->email ? $skl->email : '-' }}</a>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-cente my-1">
                                            <span class="text-dark-75 font-weight-bolder mr-2">Telepon:</span>
                                            <a href="#"
                                                class="text-muted text-hover-primary">{{ $skl->no_telpon ? $skl->no_telpon : '-' }}</a>
                                        </div>
                                    </div>
                                    <a href="{{ url('set-sys/' . $skl->id_identitas_sekolah . '') }}"
                                        class="btn btn-block btn-sm btn-success font-weight-bolder text-uppercase py-4">Akses
                                        Sistem</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!--begin::Pagination-->
                <div class="mb-10">
                    @if ($get_skl->hasPages())
                        <hr>
                        <div class="d-flex justify-content-between align-items-center flex-wrap ">
                            <div class="d-flex flex-wrap mr-3">
                                @if ($get_skl->onFirstPage())
                                    <a href="#" class="btn btn-icon btn-sm btn-light-primary mr-2 my-1 disabled">
                                        <i class="ki ki-bold-arrow-back icon-xs"></i>
                                    </a>
                                @else
                                    <a href="{{ $get_skl->previousPageUrl() }}"
                                        class="btn btn-icon btn-sm btn-light-primary mr-2 my-1">
                                        <i class="ki ki-bold-arrow-back icon-xs"></i>
                                    </a>
                                @endif
                                @for ($i = 1; $i <= ceil($get_skl->total() / $show); $i++)
                                    <a href="{{ $get_skl->url($i) }}"
                                        class="btn btn-icon btn-sm border-0 btn-hover-primary {{ $i == $get_skl->currentPage() ? 'active' : '' }} mr-2 my-1">{{ $i }}</a>
                                @endfor

                                @if ($get_skl->hasMorePages())
                                    <a href="{{ $get_skl->nextPageUrl() }}"
                                        class="btn btn-icon btn-sm btn-light-primary mr-2 my-1">
                                        <i class="ki ki-bold-arrow-next icon-xs"></i>
                                    </a>
                                @else
                                    <a href="#" class="btn btn-icon btn-sm btn-light-primary mr-2 my-1 disabled">
                                        <i class="ki ki-bold-arrow-next icon-xs"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
                <!--end::Pagination-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Entry-->
    </div>
    <!--end::Main-->

    <!-- Modal Tambah -->
    <div class="modal fade" id="modal-add-unit" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="modal-add" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-addLabel">Tambah Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <form method="post" action="{{ url('admin/' . $skl->keyword . '/store/sekolah') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="container">
                            <div class="form-group row mb-3">
                                <label class="col-3 col-form-label">Nama Sekolah</label>
                                <div class="col-9">
                                    <input class="form-control" type="text" name="nama_sekolah"
                                        value="{{ old('nama_sekolah') }}" placeholder="Nama Sekolah.." required />
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="col-3 col-form-label">NPSN</label>
                                <div class="col-9">
                                    <input class="form-control" type="text" name="npsn" value="{{ old('npsn') }}"
                                        placeholder="NPSN.." required />
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="col-3 col-form-label">NSS</label>
                                <div class="col-9">
                                    <input class="form-control" type="text" name="nss" value="{{ old('nss') }}"
                                        placeholder="NSS.." required />
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="col-3 col-form-label">Alamat Sekolah</label>
                                <div class="col-9">
                                    <input class="form-control" type="text" name="alamat_sekolah"
                                        value="{{ old('alamat_sekolah') }}" placeholder="Alamat Sekolah.."
                                        required />
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="col-3 col-form-label">Direktori</label>
                                <div class="col-9">
                                    <input class="form-control" type="text" name="keyword" placeholder="Direktori.."
                                        required />
                                    @if ($errors->has('keyword'))
                                        <span class="text-danger">{{ $errors->first('keyword') }}</span>
                                    @endif
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

    <script>
        var HOST_URL = "https://keenthemes.com/metronic/tools/preview";
    </script>
    <!--begin::Global Theme Bundle(used by all pages)-->
    <script src="{{ asset('assets/plugins/global/plugins.bundle.js?v=7.0.5') }}"></script>
    <script src="{{ asset('assets/plugins/custom/prismjs/prismjs.bundle.js?v=7.0.5') }}"></script>
    <script src="{{ asset('assets/js/scripts.bundle.js?v=7.0.5') }}"></script>
    <!--end::Global Theme Bundle-->
    <!--begin::Page Scripts(used by this page)-->
    {{-- <script src="{{ asset('assets/js/pages/custom/login/login-general.js?v=7.0.5') }}"></script> --}}
    <!--end::Page Scripts-->
    <script>
        $(document).ready(function() {
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    toastr.error("{{ $error }}", "Terjadi Kesalahn");
                @endforeach
            @endif

            @if ($errors->has('keyword'))
                $('#modal-add-unit').modal('show');
            @endif
        });
    </script>
</body>
<!--end::Body-->

</html>
