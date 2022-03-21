<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\IdentitasSekolah;
use App\Models\Akademik;
use App\Models\Gedung;
use App\Models\User;
use App\Models\Ruangan;
use App\Models\Tingkat;
use App\Models\JenisPtk;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Kepegawaian;
use App\Models\UserModul;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function home()
    {
        return view('admin/home');
    }

    public function setSysView()
    {
        return view('admin/jenjang');
    }

    public function setSys($id)
    {
        $sekolah = IdentitasSekolah::where('id_identitas_sekolah', $id)->first();
        session(['identitas_sekolah' => $sekolah]);

        return redirect('admin/' . $sekolah->keyword . '/');
    }

    public function page($key, $page)
    {
        return view('admin/' . $page);
    }

    public function pagedir($key, $dir = NULL, $page)
    {
        return view('admin/' . $dir . '/' . $page);
    }

    public function store(Request $request, $key, $target)
    {
        if ($target == 'sekolah') {
            $this->validate($request, [
                'keyword' => 'unique:rb_identitas_sekolah|alpha_dash',
            ]);

            $data = $request->all();
            $data['id_jenjang'] = '5';
            $skl = IdentitasSekolah::create($data);
            session(['identitas_sekolah' => $skl]);

            return redirect('admin/' . $skl->keyword . '/referensi/sekolah')->with('success', 'Unit baru berhasil ditambahkan');
        } else if ($target == 'tingkat') {
            $data = $request->all();
            Tingkat::create($data);

            return back()->with('success', 'Data tingkat berhasil ditambahkan');
        } else if ($target == 'akademik') {
            if ($request->aktif == 'Ya') {
                Akademik::where('id_identitas_sekolah', $request->id_identitas_sekolah)->update([
                    'Aktif' => 'Tidak'
                ]);
            }

            $data = $request->all();
            Akademik::create($data);

            return back()->with('success', 'Data tahun akademik berhasil ditambahkan');
        } else if ($target == 'gedung') {
            $data = $request->all();
            $data['keterangan'] = $request->keterangan ? $request->keterangan : '';
            Gedung::create($data);

            return back()->with('success', 'Data gedung berhasil ditambahkan');
        } else if ($target == 'ruangan') {
            $data = $request->all();
            $data['keterangan'] = $request->keterangan ? $request->keterangan : '';
            $data['kode_gedung'] = '';
            Ruangan::create($data);

            return back()->with('success', 'Data ruangan berhasil ditambahkan');
        } else if ($target == 'jenis_ptk') {
            $data = $request->all();
            $data['keterangan'] = $request->keterangan ? $request->keterangan : '';
            JenisPtk::create($data);

            return back()->with('success', 'Data Jenis PTK berhasil ditambahkan');
        } else if ($target == 'kepegawaian') {
            $data = $request->all();
            $data['keterangan'] = $request->keterangan ? $request->keterangan : '';
            Kepegawaian::create($data);

            return back()->with('success', 'Data Status Kepegawaian berhasil ditambahkan');
        } else if ($target == 'jurusan') {
            $data = $request->all();
            $data['nama_jurusan_en'] = $request->nama_jurusan_en ? $request->nama_jurusan_en : '';
            $data['bidang_keahlian'] = $request->bidang_keahlian ? $request->bidang_keahlian : '';
            $data['kompetensi_umum'] = $request->kompetensi_umum ? $request->kompetensi_umum : '';
            $data['kompetensi_khusus'] = $request->kompetensi_khusus ? $request->kompetensi_khusus : '';
            $data['keterangan'] = $request->keterangan ? $request->keterangan : '';
            Jurusan::create($data);

            return back()->with('success', 'Data Jurusan berhasil ditambahkan');
        } else if ($target == 'kelas') {
            $this->validate($request, [
                'kode_kelas' => 'max:10',
                'nama_kelas' => 'max:20',
            ]);

            $data = $request->all();
            Kelas::create($data);

            return back()->with('success', 'Data Kelas berhasil ditambahkan');
        } else if ($target == 'administrator') {
            $this->validate($request, [
                'username' => 'unique:rb_users|alpha_dash',
            ]);

            if ($request->foto_) {
                $file = $request->file('foto_');
                $nama_file = $request->level . '-' . $request->id_identitas_sekolah . '-' . date('ymdhis') . '.' . $file->getClientOriginalExtension();
                $request['foto'] = $nama_file;
                $file->move(public_path('img/admin'), $nama_file);
            } else {
                $request['foto'] = '';
            }
            $request['password'] = hash("sha512", md5($request->password));
            $request['jabatan'] = '';
            $request['aktif'] = 'Y';
            $data = $request->except(['foto_', 'akses']);
            $user =  User::create($data);

            if ($request->akses) {
                foreach ($request->akses as $aks) {
                    UserModul::create([
                        'id_user' => $user->id_user,
                        'id_modul' => $aks,
                        'level' => $request->level,
                    ]);
                }
            }

            return back()->with('success', 'Data Akses Admin berhasil ditambahkan');
        }
    }

    public function update(Request $request, $key, $target)
    {
        if ($target == 'sekolah') {
            $get_data = IdentitasSekolah::where('id_identitas_sekolah', $request->id_identitas_sekolah)->first();
            $except = ['_token', 'id_identitas_sekolah', 'domain_web', 'api_web', 'no_wa', 'logo1_', 'logo2_'];
            $request['api_wablas'] = $request->api_web . '||' . $request->no_wa . '||' . $request->domain_web;

            if ($request->logo1_) {
                $file = $request->file('logo1_');
                $nama_file = 'logo1-' . $request->id_identitas_sekolah . '.' . $file->getClientOriginalExtension();
                $request['logo1'] = $nama_file;
                $file->move(public_path('img/sekolah'), $nama_file);
            }

            if ($request->logo2_) {
                $file = $request->file('logo2_');
                $nama_file = 'logo2-' . $request->id_identitas_sekolah . '.' . $file->getClientOriginalExtension();
                $request['logo2'] = $nama_file;
                $file->move(public_path('img/sekolah'), $nama_file);
            }

            foreach ($request->except($except) as $keys => $data) {
                $get_data->$keys = $data;
            }

            $get_data->save();

            return back()->with('success', 'Data identitas sekolah berhasil di update');
        } else if ($target == 'tingkat') {
            $get_data = Tingkat::where('id_tingkat', $request->id_tingkat)->first();
            $except = ['_token', 'id_tingkat'];

            foreach ($request->except($except) as $keys => $data) {
                $get_data->$keys = $data;
            }
            $get_data->save();

            return back()->with('success', 'Data tingkat berhasil di update');
        } else if ($target == 'set_akademik') {
            $get = Akademik::where('id_tahun_akademik', $request->id_tahun_akademik)->first();
            Akademik::where('id_identitas_sekolah', $get->id_identitas_sekolah)->update([
                'Aktif' => 'Tidak'
            ]);

            $get_data = Akademik::where('id_tahun_akademik', $request->id_tahun_akademik)->first();
            $get_data->aktif = 'Ya';
            $get_data->save();

            return back()->with('success', 'Tahun Akademik berhasil diaktifkan');
        } else if ($target == 'akademik') {
            $except = ['_token', 'id_tahun_akademik'];
            if ($request->aktif == 'Ya') {
                $get = Akademik::where('id_tahun_akademik', $request->id_tahun_akademik)->first();
                Akademik::where('id_identitas_sekolah', $get->id_identitas_sekolah)->update([
                    'Aktif' => 'Tidak'
                ]);
            }

            $get_data = Akademik::where('id_tahun_akademik', $request->id_tahun_akademik)->first();

            foreach ($request->except($except) as $keys => $data) {
                $get_data->$keys = $data;
            }
            $get_data->save();
            return back()->with('success', 'Data Tahun Akademik berhasil diupdate');
        } else if ($target == 'gedung') {
            $get_data = Gedung::where('id_gedung', $request->id_gedung)->first();
            $except = ['_token', 'id_gedung'];
            $request['keterangan'] = $request->keterangan ? $request->keterangan : '';

            foreach ($request->except($except) as $keys => $data) {
                $get_data->$keys = $data;
            }
            $get_data->save();

            return back()->with('success', 'Data gedung berhasil di update');
        } else if ($target == 'ruangan') {
            $get_data = Ruangan::where('id_ruangan', $request->id_ruangan)->first();
            $except = ['_token', 'id_ruangan'];
            $request['keterangan'] = $request->keterangan ? $request->keterangan : '';

            foreach ($request->except($except) as $keys => $data) {
                $get_data->$keys = $data;
            }
            $get_data->save();

            return back()->with('success', 'Data ruangan berhasil di update');
        } else if ($target == 'jenis_ptk') {
            $get_data = JenisPtk::where('id_jenis_ptk', $request->id_jenis_ptk)->first();
            $except = ['_token', 'id_jenis_ptk'];
            $request['keterangan'] = $request->keterangan ? $request->keterangan : '';
            foreach ($request->except($except) as $keys => $data) {
                $get_data->$keys = $data;
            }
            $get_data->save();

            return back()->with('success', 'Data Jenis PTK berhasil di update');
        } else if ($target == 'kepegawaian') {
            $get_data = Kepegawaian::where('id_status_kepegawaian', $request->id_status_kepegawaian)->first();
            $except = ['_token', 'id_status_kepegawaian'];
            $request['keterangan'] = $request->keterangan ? $request->keterangan : '';
            foreach ($request->except($except) as $keys => $data) {
                $get_data->$keys = $data;
            }
            $get_data->save();

            return back()->with('success', 'Data Status Kepegawaian berhasil di update');
        } else if ($target == 'jurusan') {
            $get_data = Jurusan::where('id_jurusan', $request->id_jurusan)->first();
            $except = ['_token', 'id_jurusan'];
            $request['nama_jurusan_en'] = $request->nama_jurusan_en ? $request->nama_jurusan_en : '';
            $request['bidang_keahlian'] = $request->bidang_keahlian ? $request->bidang_keahlian : '';
            $request['kompetensi_umum'] = $request->kompetensi_umum ? $request->kompetensi_umum : '';
            $request['kompetensi_khusus'] = $request->kompetensi_khusus ? $request->kompetensi_khusus : '';
            $request['keterangan'] = $request->keterangan ? $request->keterangan : '';

            foreach ($request->except($except) as $keys => $data) {
                $get_data->$keys = $data;
            }
            $get_data->save();

            return back()->with('success', 'Data Jurusan berhasil di update');
        } else if ($target == 'kelas') {
            $this->validate($request, [
                'kode_kelas' => 'max:10',
                'nama_kelas' => 'max:20',
            ]);

            $get_data = Kelas::where('id_kelas', $request->id_kelas)->first();
            $except = ['_token', 'id_kelas'];

            foreach ($request->except($except) as $keys => $data) {
                $get_data->$keys = $data;
            }
            $get_data->save();

            return back()->with('success', 'Data Jurusan berhasil di update');
        } else if ($target == 'administrator') {
            $get_data = User::where('id_user', $request->id_user)->first();
            $except = ['_token', 'foto_', 'akses'];
            if ($request->foto_) {
                $file = $request->file('foto_');
                $file->move(public_path('img/admin'), $request->foto);
            }

            if ($request->password) {
                $request['password'] = hash("sha512", md5($request->password));
            } else {
                array_push($except, 'password');
            }

            if ($request->akses) {
                UserModul::where('id_user', $get_data->id_user)->delete();
                foreach ($request->akses as $aks) {
                    UserModul::create([
                        'id_user' => $get_data->id_user,
                        'id_modul' => $aks,
                        'level' => $request->level,
                    ]);
                }
            }

            foreach ($request->except($except) as $keys => $data) {
                $get_data->$keys = $data;
            }
            $get_data->save();

            return back()->with('success', 'Data Akses Admin berhasil di update');
        }
    }

    public function delete($key, $target, $id)
    {
        if ($target == 'tingkat') {
            $get_data = Tingkat::where('id_tingkat', $id)->first();
            if (count($get_data->kelas) <= 0) {
                $get_data->delete();
                return back()->with('success', 'Data tingkat berhasil dihapus');
            } else {
                return redirect()->back()->withErrors(['error' => ['Gagal Hapus, Terdapat ' . count($get_data->kelas) . ' Kelas untuk Tingkat Ini.']]);
            }
        } else if ($target == 'gedung') {
            $get_data = Gedung::where('id_gedung', $id)->first();
            if (count($get_data->ruangan) <= 0) {
                $get_data->delete();
                return back()->with('success', 'Data gedung berhasil dihapus');
            } else {
                return redirect()->back()->withErrors(['error' => ['Gagal Hapus, Terdapat ' . count($get_data->ruangan) . ' Ruangan untuk Gedung Ini.']]);
            }
        } else if ($target == 'ruangan') {
            $get_data = Ruangan::where('id_ruangan', $id)->first();
            if (count($get_data->jadwal) <= 0) {
                $get_data->delete();
                return back()->with('success', 'Data ruangan berhasil dihapus');
            } else {
                return redirect()->back()->withErrors(['error' => ['Gagal Hapus, Terdapat ' . count($get_data->jadwal) . ' Jadwal untuk Ruangan Ini.']]);
            }
        } else if ($target == 'jenis_ptk') {
            $get_data = JenisPtk::where('id_jenis_ptk', $id)->first();
            $get_data->delete();
            return back()->with('success', 'Data Jenis PTK berhasil dihapus');
        } else if ($target == 'kepegawaian') {
            $get_data = Kepegawaian::where('id_status_kepegawaian', $id)->first();
            $get_data->delete();
            return back()->with('success', 'Data Status Kepegawaian berhasil dihapus');
        } else if ($target == 'jurusan') {
            $get_data = Jurusan::where('id_jurusan', $id)->first();
            if (count($get_data->kelas) <= 0) {
                $get_data->delete();
                return back()->with('success', 'Data jurusan berhasil dihapus');
            } else {
                return redirect()->back()->withErrors(['error' => ['Gagal Hapus, Terdapat ' . count($get_data->kelas) . ' Kelas untuk Jurusan Ini.']]);
            }
        } else if ($target == 'kelas') {
            $get_data = Kelas::where('id_kelas', $id)->first();
            if (count($get_data->siswa) <= 0) {
                $get_data->delete();
                return back()->with('success', 'Data kelas berhasil dihapus');
            } else {
                return redirect()->back()->withErrors(['error' => ['Gagal Hapus, Terdapat ' . count($get_data->siswa) . ' Siswa untuk Kelas Ini.']]);
            }
        } else if ($target == 'administrator') {
            $get_data = User::where('id_user', $id)->first();
            $get_data->delete();
            UserModul::where('id_user', $id)->delete();
            return back()->with('success', 'Data Akses Admin berhasil dihapus');
        }
    }

    public function config(Request $request)
    {
        if ($request->req == 'getAntrian') {
        }
    }
}
