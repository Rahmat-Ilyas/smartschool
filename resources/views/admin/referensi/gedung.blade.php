@extends('admin.layout')
@section('content')
    @php
    $skl = session('identitas_sekolah');
    $gedung = new App\Models\Gedung();
    $gedung = $gedung->where('id_identitas_sekolah', $skl->id_identitas_sekolah)->get();
    @endphp

    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-baseline flex-wrap mr-5">
                <h5 class="text-dark font-weight-bold my-1 mr-5">Gedung</h5>
                <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Admin Page</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Referensi</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Gedung</a>
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
                        <h3 class="card-label">Data Gedung
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
                                <th>Kode Gedung</th>
                                <th>Nama Gedung</th>
                                <th>Jumlah Lantai</th>
                                <th>Panjang</th>
                                <th>Tinggi</th>
                                <th>Lebar</th>
                                <th>Aktif</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($gedung as $no => $dta)
                                <tr>
                                    <td>{{ $no + 1 }}</td>
                                    <td>{{ $dta->kode_gedung }}</td>
                                    <td>{{ $dta->nama_gedung }}</td>
                                    <td>{{ $dta->jumlah_lantai }} Lantai</td>
                                    <td>{{ $dta->panjang }} Meter</td>
                                    <td>{{ $dta->tinggi }} Meter</td>
                                    <td>{{ $dta->lebar }} Meter</td>
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
                <form method="post" action="{{ url('admin/' . $skl->keyword . '/store/gedung') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="container">
                                <div class="form-group row mb-3">
                                    <label class="col-3 col-form-label">Kode Gedung</label>
                                    <div class="col-9">
                                        <input type="hidden" name="id_identitas_sekolah" value="{{ $skl->id_identitas_sekolah }}">
                                        <input class="form-control" type="text" name="kode_gedung" placeholder="Kode Gedung.." required />
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label class="col-3 col-form-label">Nama Gedung</label>
                                    <div class="col-9">
                                        <input class="form-control" type="text" name="nama_gedung" placeholder="Nama Gedung.." required />
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label class="col-3 col-form-label">Jumlah Lantai</label>
                                    <div class="col-9">
                                        <input class="form-control" type="number" name="jumlah_lantai" placeholder="Jumlah Lantai.." required />
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label class="col-3 col-form-label">Panjang (meter)</label>
                                    <div class="col-9">
                                        <input class="form-control" type="number" name="panjang" placeholder="Panjang.." required />
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label class="col-3 col-form-label">Tinggi (meter)</label>
                                    <div class="col-9">
                                        <input class="form-control" type="number" name="tinggi" placeholder="Tinggi.." required />
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label class="col-3 col-form-label">Lebar (meter)</label>
                                    <div class="col-9">
                                        <input class="form-control" type="number" name="lebar" placeholder="Lebar.." required />
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label class="col-3 col-form-label">Keterangan</label>
                                    <div class="col-9">
                                        <input class="form-control" type="text" name="keterangan" placeholder="Keterangan.." />
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label class="col-3 col-form-label">Aktif</label>
                                    <div class="col-9">
                                        <select class="form-control" name="aktif" required>
                                            <option value="Y">Ya</option>
                                            <option value="N">Tidak</option>
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

    @foreach ($gedung as $no => $dta)
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
                    <form method="post" action="{{ url('admin/' . $skl->keyword . '/update/gedung') }}">
                        @csrf
                        <div class="modal-body">
                            <div class="container">
                                <div class="form-group row mb-3">
                                    <label class="col-3 col-form-label">Kode Gedung</label>
                                    <div class="col-9">
                                        <input type="hidden" name="id_gedung" value="{{ $dta->id_gedung }}">
                                        <input class="form-control" type="text" value="{{ $dta->kode_gedung }}"
                                            name="kode_gedung" placeholder="Kode Gedung.." required />
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label class="col-3 col-form-label">Nama Gedung</label>
                                    <div class="col-9">
                                        <input class="form-control" type="text" value="{{ $dta->nama_gedung }}"
                                            name="nama_gedung" placeholder="Nama Gedung.." required />
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label class="col-3 col-form-label">Jumlah Lantai</label>
                                    <div class="col-9">
                                        <input class="form-control" type="number" value="{{ $dta->jumlah_lantai }}"
                                            name="jumlah_lantai" placeholder="Jumlah Lantai.." required />
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label class="col-3 col-form-label">Panjang (meter)</label>
                                    <div class="col-9">
                                        <input class="form-control" type="number" value="{{ $dta->panjang }}"
                                            name="panjang" placeholder="Panjang.." required />
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label class="col-3 col-form-label">Tinggi (meter)</label>
                                    <div class="col-9">
                                        <input class="form-control" type="number" value="{{ $dta->tinggi }}"
                                            name="tinggi" placeholder="Tinggi.." required />
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label class="col-3 col-form-label">Lebar (meter)</label>
                                    <div class="col-9">
                                        <input class="form-control" type="number" value="{{ $dta->lebar }}"
                                            name="lebar" placeholder="Lebar.." required />
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
                                            <option value="Y">Ya</option>
                                            <option value="N">Tidak</option>
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
                    <form method="post" action="{{ url('admin/' . $skl->keyword . '/delete/gedung/'.$dta->id_gedung) }}">
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
            $('#nav-gedung').addClass('menu-item-active').parents('.menu-item-submenu').addClass(
                'menu-item-active menu-item-open');
        })
    </script>
@endsection
