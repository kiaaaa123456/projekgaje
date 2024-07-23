<?php

namespace App\Http\Controllers\Drp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Evkin;
use App\Models\Periodeevkin;
use App\Models\Attendance;
use Validator;
use DB;
use Hash;
use Signature;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{

    public function index(Request $request)
    {
        $user = Auth::user();

        if($user) {

            $provinsi  = DB::select( DB::raw("SELECT * FROM wilayah_provinsi ORDER BY nmprov ASC"));
            return view('drp.admin.laporan-aktivitas-harian', compact('provinsi'));
            
        } else {

            return redirect('sign-in');
        }
        
    }

    public function laporanAbsensi(Request $request)
    {
        $user = Auth::user();

        if($user) {

            $provinsi  = DB::select( DB::raw("SELECT * FROM wilayah_provinsi ORDER BY nmprov ASC"));
            return view('drp.admin.laporan-absensi', compact('provinsi'));
            
        } else {

            return redirect('sign-in');
        }
        
    }

    public function laporanCronjob(Request $request)
    {
        $user = Auth::user();

        if($user) {
            
            return view('drp.admin.laporan-cronjob');
            
        } else {

            return redirect('sign-in');
        }
        
    }

    public function laporanRekapBulanan(Request $request)
    {
        $user = Auth::user();
        

        if($user) {

            if (empty($_GET['kodeprov']) && empty($_GET['kodekab']) && empty($_GET['bulan'])) {

                $tahun = date('Y');
                $bulan = date('m');
                

                if ($bulan == 1) {
                    $nama_bulan = 'Januari';
                } else if ($bulan == 2) {
                    $nama_bulan = 'Februari';
                } else if ($bulan == 3) {
                    $nama_bulan = 'Maret';
                } else if ($bulan == 4) {
                    $nama_bulan = 'April';
                } else if ($bulan == 5) {
                    $nama_bulan = 'Mei';
                } else if ($bulan == 6) {
                    $nama_bulan = 'Juni';
                } else if ($bulan == 7) {
                    $nama_bulan = 'Juli';
                } else if ($bulan == 8) {
                    $nama_bulan = 'Agustus';
                } else if ($bulan == 9) {
                    $nama_bulan = 'September';
                } else if ($bulan == 10) {
                    $nama_bulan = 'Oktober';
                } else if ($bulan == 11) {
                    $nama_bulan = 'November';
                } else if ($bulan == 12) {
                    $nama_bulan = 'Desember';
                }
                
                $provinsi  = DB::select( DB::raw("SELECT * FROM wilayah_provinsi ORDER BY nmprov ASC"));

                $nmprov = 'Seluruh Provinsi';
                $nmkab = 'Seluruh Kabupaten';
                $jml = DB::select( DB::raw("SELECT count(id) AS jml FROM users WHERE department_id != '1' AND department_id != '24' AND department_id != '25' AND department_id != '26' AND department_id != '27' AND department_id != '28' AND department_id != '29' AND department_id != '30' AND department_id != '31' AND department_id != '32' AND department_id != '33'"))['0']->jml;

                $kader  = DB::select( DB::raw("SELECT name, nmkab, nmkec, nmdesa, (SELECT COUNT(*) FROM attendances WHERE attendances.user_id = users.id AND YEAR(date)='2024' AND month(date)='$bulan') AS hari_kerja, (SELECT COUNT(*) FROM daily_activity WHERE daily_activity.created_by = users.id AND YEAR(date)='2024' AND month(date)='$bulan') AS akt_harian, (SELECT SUM(stay_time) FROM attendances WHERE attendances.user_id = users.id AND YEAR(date)='2024' AND month(date)='$bulan') AS jam_kerja, (SELECT COUNT(*) FROM leave_requests WHERE leave_requests.user_id = users.id AND YEAR(apply_date)='2024' AND month(apply_date)='$bulan') AND status_id=1 AS tdk_masuk, (SELECT COUNT(file) FROM monthly_report WHERE monthly_report.user_id = users.id AND year='2024' AND month='$nama_bulan') AS lap_bul, (SELECT COUNT(file_ttdbasah) FROM monthly_report WHERE monthly_report.user_id = users.id AND year='2024' AND month='$nama_bulan') AS ttd_basah, (SELECT nilai FROM evkin JOIN periode_evkin ON periode_evkin.id = evkin.periode_id WHERE evkin.user_id = users.id AND tahun='2024' AND bulan='$bulan' GROUP BY evkin.user_id) AS nilai_evkin FROM users LEFT JOIN wilayah_kabupaten ON wilayah_kabupaten.kdkab = users.kdkab LEFT JOIN wilayah_kecamatan ON wilayah_kecamatan.kdkec = users.kdkec LEFT JOIN wilayah_desa ON wilayah_desa.kddesa = users.kddesa WHERE department_id = 8 ORDER BY name ASC"));

                $fasdis  = DB::select( DB::raw("SELECT name, nmkab, nmkec, (SELECT COUNT(*) FROM attendances WHERE attendances.user_id = users.id AND YEAR(date)='2024' AND month(date)='$bulan') AS hari_kerja, (SELECT COUNT(*) FROM daily_activity WHERE daily_activity.created_by = users.id AND YEAR(date)='2024' AND month(date)='$bulan') AS akt_harian, (SELECT SUM(stay_time) FROM attendances WHERE attendances.user_id = users.id AND YEAR(date)='2024' AND month(date)='$bulan') AS jam_kerja, (SELECT COUNT(*) FROM leave_requests WHERE leave_requests.user_id = users.id AND YEAR(apply_date)='2024' AND month(apply_date)='$bulan') AND status_id=1 AS tdk_masuk, (SELECT COUNT(file) FROM monthly_report WHERE monthly_report.user_id = users.id AND year='2024' AND month='$nama_bulan') AS lap_bul, (SELECT COUNT(file_ttdbasah) FROM monthly_report WHERE monthly_report.user_id = users.id AND year='2024' AND month='$nama_bulan') AS ttd_basah, (SELECT nilai FROM evkin JOIN periode_evkin ON periode_evkin.id = evkin.periode_id WHERE evkin.user_id = users.id AND tahun='2024' AND bulan='$bulan' GROUP BY evkin.user_id) AS nilai_evkin FROM users LEFT JOIN wilayah_kabupaten ON wilayah_kabupaten.kdkab = users.kdkab LEFT JOIN wilayah_kecamatan ON wilayah_kecamatan.kdkec = users.kdkec  WHERE department_id = 7 ORDER BY name ASC"));

                $faskab  = DB::select( DB::raw("SELECT name, nmkab, (SELECT COUNT(*) FROM attendances WHERE attendances.user_id = users.id AND YEAR(date)='2024' AND month(date)='$bulan') AS hari_kerja, (SELECT COUNT(*) FROM daily_activity WHERE daily_activity.created_by = users.id AND YEAR(date)='2024' AND month(date)='$bulan') AS akt_harian, (SELECT SUM(stay_time) FROM attendances WHERE attendances.user_id = users.id AND YEAR(date)='2024' AND month(date)='$bulan') AS jam_kerja, (SELECT COUNT(*) FROM leave_requests WHERE leave_requests.user_id = users.id AND YEAR(apply_date)='2024' AND month(apply_date)='$bulan') AND status_id=1 AS tdk_masuk, (SELECT COUNT(file) FROM monthly_report WHERE monthly_report.user_id = users.id AND year='2024' AND month='$nama_bulan') AS lap_bul, (SELECT COUNT(file_ttdbasah) FROM monthly_report WHERE monthly_report.user_id = users.id AND year='2024' AND month='$nama_bulan') AS ttd_basah, (SELECT nilai FROM evkin JOIN periode_evkin ON periode_evkin.id = evkin.periode_id WHERE evkin.user_id = users.id AND tahun='2024' AND bulan='$bulan' GROUP BY evkin.user_id) AS nilai_evkin FROM users LEFT JOIN wilayah_kabupaten ON wilayah_kabupaten.kdkab = users.kdkab WHERE department_id = 6 ORDER BY name ASC"));

                $korkab  = DB::select( DB::raw("SELECT name, nmkab, (SELECT COUNT(*) FROM attendances WHERE attendances.user_id = users.id AND YEAR(date)='2024' AND month(date)='$bulan') AS hari_kerja, (SELECT COUNT(*) FROM daily_activity WHERE daily_activity.created_by = users.id AND YEAR(date)='2024' AND month(date)='$bulan') AS akt_harian, (SELECT SUM(stay_time) FROM attendances WHERE attendances.user_id = users.id AND YEAR(date)='2024' AND month(date)='$bulan') AS jam_kerja, (SELECT COUNT(*) FROM leave_requests WHERE leave_requests.user_id = users.id AND YEAR(apply_date)='2024' AND month(apply_date)='$bulan') AND status_id=1 AS tdk_masuk, (SELECT COUNT(file) FROM monthly_report WHERE monthly_report.user_id = users.id AND year='2024' AND month='$nama_bulan') AS lap_bul, (SELECT COUNT(file_ttdbasah) FROM monthly_report WHERE monthly_report.user_id = users.id AND year='2024' AND month='$nama_bulan') AS ttd_basah, (SELECT nilai FROM evkin JOIN periode_evkin ON periode_evkin.id = evkin.periode_id WHERE evkin.user_id = users.id AND tahun='2024' AND bulan='$bulan' GROUP BY evkin.user_id) AS nilai_evkin FROM users LEFT JOIN wilayah_kabupaten ON wilayah_kabupaten.kdkab = users.kdkab WHERE department_id = 5 ORDER BY name ASC"));

            } else {

                $tahun = date('Y');
                $bulan = $_GET['bulan'];
                $kdprov = $_GET['kodeprov'];
                $kdkab = $_GET['kodekab'];
                $bulan = $_GET['bulan'];

                $nmprov = DB::select( DB::raw("SELECT nmprov FROM wilayah_provinsi WHERE kdprov = '$kdprov' "))['0']->nmprov;
                $nmkab = DB::select( DB::raw("SELECT nmkab FROM wilayah_kabupaten WHERE kdkab = '$kdkab' "))['0']->nmkab;
                $jml = DB::select( DB::raw("SELECT count(id) AS jml FROM users WHERE kdprov='$kdprov' AND kdkab='$kdkab' AND department_id != '1' AND department_id != '24' AND department_id != '25' AND department_id != '26' AND department_id != '27' AND department_id != '28' AND department_id != '29' AND department_id != '30' AND department_id != '31' AND department_id != '32' AND department_id != '33'"))['0']->jml;
                

                if ($bulan == 1) {
                    $nama_bulan = 'Januari';
                } else if ($bulan == 2) {
                    $nama_bulan = 'Februari';
                } else if ($bulan == 3) {
                    $nama_bulan = 'Maret';
                } else if ($bulan == 4) {
                    $nama_bulan = 'April';
                } else if ($bulan == 5) {
                    $nama_bulan = 'Mei';
                } else if ($bulan == 6) {
                    $nama_bulan = 'Juni';
                } else if ($bulan == 7) {
                    $nama_bulan = 'Juli';
                } else if ($bulan == 8) {
                    $nama_bulan = 'Agustus';
                } else if ($bulan == 9) {
                    $nama_bulan = 'September';
                } else if ($bulan == 10) {
                    $nama_bulan = 'Oktober';
                } else if ($bulan == 11) {
                    $nama_bulan = 'November';
                } else if ($bulan == 12) {
                    $nama_bulan = 'Desember';
                }
                
                $provinsi  = DB::select( DB::raw("SELECT * FROM wilayah_provinsi ORDER BY nmprov ASC"));

                $kader  = DB::select( DB::raw("SELECT name, nmkab, nmkec, nmdesa, (SELECT COUNT(*) FROM attendances WHERE attendances.user_id = users.id AND YEAR(date)='2024' AND month(date)='$bulan') AS hari_kerja, (SELECT COUNT(*) FROM daily_activity WHERE daily_activity.created_by = users.id AND YEAR(date)='2024' AND month(date)='$bulan') AS akt_harian, (SELECT SUM(stay_time) FROM attendances WHERE attendances.user_id = users.id AND YEAR(date)='2024' AND month(date)='$bulan') AS jam_kerja, (SELECT COUNT(*) FROM leave_requests WHERE leave_requests.user_id = users.id AND YEAR(apply_date)='2024' AND month(apply_date)='$bulan') AND status_id=1 AS tdk_masuk, (SELECT COUNT(file) FROM monthly_report WHERE monthly_report.user_id = users.id AND year='2024' AND month='$nama_bulan') AS lap_bul, (SELECT COUNT(file_ttdbasah) FROM monthly_report WHERE monthly_report.user_id = users.id AND year='2024' AND month='$nama_bulan') AS ttd_basah, (SELECT nilai FROM evkin JOIN periode_evkin ON periode_evkin.id = evkin.periode_id WHERE evkin.user_id = users.id AND tahun='2024' AND bulan='$bulan' GROUP BY evkin.user_id) AS nilai_evkin FROM users LEFT JOIN wilayah_kabupaten ON wilayah_kabupaten.kdkab = users.kdkab LEFT JOIN wilayah_kecamatan ON wilayah_kecamatan.kdkec = users.kdkec LEFT JOIN wilayah_desa ON wilayah_desa.kddesa = users.kddesa WHERE department_id = 8 AND users.kdprov='$kdprov' AND users.kdkab='$kdkab' ORDER BY name ASC"));

                $fasdis  = DB::select( DB::raw("SELECT name, nmkab, nmkec, (SELECT COUNT(*) FROM attendances WHERE attendances.user_id = users.id AND YEAR(date)='2024' AND month(date)='$bulan') AS hari_kerja, (SELECT COUNT(*) FROM daily_activity WHERE daily_activity.created_by = users.id AND YEAR(date)='2024' AND month(date)='$bulan') AS akt_harian, (SELECT SUM(stay_time) FROM attendances WHERE attendances.user_id = users.id AND YEAR(date)='2024' AND month(date)='$bulan') AS jam_kerja, (SELECT COUNT(*) FROM leave_requests WHERE leave_requests.user_id = users.id AND YEAR(apply_date)='2024' AND month(apply_date)='$bulan') AND status_id=1 AS tdk_masuk, (SELECT COUNT(file) FROM monthly_report WHERE monthly_report.user_id = users.id AND year='2024' AND month='$nama_bulan') AS lap_bul, (SELECT COUNT(file_ttdbasah) FROM monthly_report WHERE monthly_report.user_id = users.id AND year='2024' AND month='$nama_bulan') AS ttd_basah, (SELECT nilai FROM evkin JOIN periode_evkin ON periode_evkin.id = evkin.periode_id WHERE evkin.user_id = users.id AND tahun='2024' AND bulan='$bulan' GROUP BY evkin.user_id) AS nilai_evkin FROM users LEFT JOIN wilayah_kabupaten ON wilayah_kabupaten.kdkab = users.kdkab LEFT JOIN wilayah_kecamatan ON wilayah_kecamatan.kdkec = users.kdkec  WHERE department_id = 7 AND users.kdprov='$kdprov' AND users.kdkab='$kdkab' ORDER BY name ASC"));

                $faskab  = DB::select( DB::raw("SELECT name, nmkab, (SELECT COUNT(*) FROM attendances WHERE attendances.user_id = users.id AND YEAR(date)='2024' AND month(date)='$bulan') AS hari_kerja, (SELECT COUNT(*) FROM daily_activity WHERE daily_activity.created_by = users.id AND YEAR(date)='2024' AND month(date)='$bulan') AS akt_harian, (SELECT SUM(stay_time) FROM attendances WHERE attendances.user_id = users.id AND YEAR(date)='2024' AND month(date)='$bulan') AS jam_kerja, (SELECT COUNT(*) FROM leave_requests WHERE leave_requests.user_id = users.id AND YEAR(apply_date)='2024' AND month(apply_date)='$bulan') AND status_id=1 AS tdk_masuk, (SELECT COUNT(file) FROM monthly_report WHERE monthly_report.user_id = users.id AND year='2024' AND month='$nama_bulan') AS lap_bul, (SELECT COUNT(file_ttdbasah) FROM monthly_report WHERE monthly_report.user_id = users.id AND year='2024' AND month='$nama_bulan') AS ttd_basah, (SELECT nilai FROM evkin JOIN periode_evkin ON periode_evkin.id = evkin.periode_id WHERE evkin.user_id = users.id AND tahun='2024' AND bulan='$bulan' GROUP BY evkin.user_id) AS nilai_evkin FROM users LEFT JOIN wilayah_kabupaten ON wilayah_kabupaten.kdkab = users.kdkab WHERE department_id = 6 AND users.kdprov='$kdprov' AND users.kdkab='$kdkab' ORDER BY name ASC"));

                $korkab  = DB::select( DB::raw("SELECT name, nmkab, (SELECT COUNT(*) FROM attendances WHERE attendances.user_id = users.id AND YEAR(date)='2024' AND month(date)='$bulan') AS hari_kerja, (SELECT COUNT(*) FROM daily_activity WHERE daily_activity.created_by = users.id AND YEAR(date)='2024' AND month(date)='$bulan') AS akt_harian, (SELECT SUM(stay_time) FROM attendances WHERE attendances.user_id = users.id AND YEAR(date)='2024' AND month(date)='$bulan') AS jam_kerja, (SELECT COUNT(*) FROM leave_requests WHERE leave_requests.user_id = users.id AND YEAR(apply_date)='2024' AND month(apply_date)='$bulan') AND status_id=1 AS tdk_masuk, (SELECT COUNT(file) FROM monthly_report WHERE monthly_report.user_id = users.id AND year='2024' AND month='$nama_bulan') AS lap_bul, (SELECT COUNT(file_ttdbasah) FROM monthly_report WHERE monthly_report.user_id = users.id AND year='2024' AND month='$nama_bulan') AS ttd_basah, (SELECT nilai FROM evkin JOIN periode_evkin ON periode_evkin.id = evkin.periode_id WHERE evkin.user_id = users.id AND tahun='2024' AND bulan='$bulan' GROUP BY evkin.user_id) AS nilai_evkin FROM users LEFT JOIN wilayah_kabupaten ON wilayah_kabupaten.kdkab = users.kdkab WHERE department_id = 5 AND users.kdprov='$kdprov' AND users.kdkab='$kdkab' ORDER BY name ASC"));

            }
            

            return view('drp.admin.laporan-rekap-bulanan', compact('provinsi', 'kader', 'fasdis', 'faskab', 'korkab', 'nmprov', 'nmkab', 'jml', 'nama_bulan'));
            
        } else {

            return redirect('sign-in');
        }
        
    }


    public function exportRekapBulanan(Request $request)
    {
        $user = Auth::user();
        

        if($user) {

            if (empty($_GET['kodeprov']) && empty($_GET['kodekab']) && empty($_GET['bulan'])) {

                $tahun = date('Y');
                $bulan = date('m');
                

                if ($bulan == 1) {
                    $nama_bulan = 'Januari';
                } else if ($bulan == 2) {
                    $nama_bulan = 'Februari';
                } else if ($bulan == 3) {
                    $nama_bulan = 'Maret';
                } else if ($bulan == 4) {
                    $nama_bulan = 'April';
                } else if ($bulan == 5) {
                    $nama_bulan = 'Mei';
                } else if ($bulan == 6) {
                    $nama_bulan = 'Juni';
                } else if ($bulan == 7) {
                    $nama_bulan = 'Juli';
                } else if ($bulan == 8) {
                    $nama_bulan = 'Agustus';
                } else if ($bulan == 9) {
                    $nama_bulan = 'September';
                } else if ($bulan == 10) {
                    $nama_bulan = 'Oktober';
                } else if ($bulan == 11) {
                    $nama_bulan = 'November';
                } else if ($bulan == 12) {
                    $nama_bulan = 'Desember';
                }
                
                $provinsi  = DB::select( DB::raw("SELECT * FROM wilayah_provinsi ORDER BY nmprov ASC"));

                $nmprov = 'Seluruh Provinsi';
                $nmkab = 'Seluruh Kabupaten';
                $jml = DB::select( DB::raw("SELECT count(id) AS jml FROM users WHERE department_id != '1' AND department_id != '24' AND department_id != '25' AND department_id != '26' AND department_id != '27' AND department_id != '28' AND department_id != '29' AND department_id != '30' AND department_id != '31' AND department_id != '32' AND department_id != '33'"))['0']->jml;

                $kader  = DB::select( DB::raw("SELECT name, nmkab, nmkec, nmdesa, (SELECT COUNT(*) FROM attendances WHERE attendances.user_id = users.id AND YEAR(date)='2024' AND month(date)='$bulan') AS hari_kerja, (SELECT COUNT(*) FROM daily_activity WHERE daily_activity.created_by = users.id AND YEAR(date)='2024' AND month(date)='$bulan') AS akt_harian, (SELECT SUM(stay_time) FROM attendances WHERE attendances.user_id = users.id AND YEAR(date)='2024' AND month(date)='$bulan') AS jam_kerja, (SELECT COUNT(*) FROM leave_requests WHERE leave_requests.user_id = users.id AND YEAR(apply_date)='2024' AND month(apply_date)='$bulan') AND status_id=1 AS tdk_masuk, (SELECT COUNT(file) FROM monthly_report WHERE monthly_report.user_id = users.id AND year='2024' AND month='$nama_bulan') AS lap_bul, (SELECT COUNT(file_ttdbasah) FROM monthly_report WHERE monthly_report.user_id = users.id AND year='2024' AND month='$nama_bulan') AS ttd_basah, (SELECT nilai FROM evkin JOIN periode_evkin ON periode_evkin.id = evkin.periode_id WHERE evkin.user_id = users.id AND tahun='2024' AND bulan='$bulan' GROUP BY evkin.user_id) AS nilai_evkin FROM users LEFT JOIN wilayah_kabupaten ON wilayah_kabupaten.kdkab = users.kdkab LEFT JOIN wilayah_kecamatan ON wilayah_kecamatan.kdkec = users.kdkec LEFT JOIN wilayah_desa ON wilayah_desa.kddesa = users.kddesa WHERE department_id = 8 ORDER BY name ASC"));

                $fasdis  = DB::select( DB::raw("SELECT name, nmkab, nmkec, (SELECT COUNT(*) FROM attendances WHERE attendances.user_id = users.id AND YEAR(date)='2024' AND month(date)='$bulan') AS hari_kerja, (SELECT COUNT(*) FROM daily_activity WHERE daily_activity.created_by = users.id AND YEAR(date)='2024' AND month(date)='$bulan') AS akt_harian, (SELECT SUM(stay_time) FROM attendances WHERE attendances.user_id = users.id AND YEAR(date)='2024' AND month(date)='$bulan') AS jam_kerja, (SELECT COUNT(*) FROM leave_requests WHERE leave_requests.user_id = users.id AND YEAR(apply_date)='2024' AND month(apply_date)='$bulan') AND status_id=1 AS tdk_masuk, (SELECT COUNT(file) FROM monthly_report WHERE monthly_report.user_id = users.id AND year='2024' AND month='$nama_bulan') AS lap_bul, (SELECT COUNT(file_ttdbasah) FROM monthly_report WHERE monthly_report.user_id = users.id AND year='2024' AND month='$nama_bulan') AS ttd_basah, (SELECT nilai FROM evkin JOIN periode_evkin ON periode_evkin.id = evkin.periode_id WHERE evkin.user_id = users.id AND tahun='2024' AND bulan='$bulan' GROUP BY evkin.user_id) AS nilai_evkin FROM users LEFT JOIN wilayah_kabupaten ON wilayah_kabupaten.kdkab = users.kdkab LEFT JOIN wilayah_kecamatan ON wilayah_kecamatan.kdkec = users.kdkec  WHERE department_id = 7 ORDER BY name ASC"));

                $faskab  = DB::select( DB::raw("SELECT name, nmkab, (SELECT COUNT(*) FROM attendances WHERE attendances.user_id = users.id AND YEAR(date)='2024' AND month(date)='$bulan') AS hari_kerja, (SELECT COUNT(*) FROM daily_activity WHERE daily_activity.created_by = users.id AND YEAR(date)='2024' AND month(date)='$bulan') AS akt_harian, (SELECT SUM(stay_time) FROM attendances WHERE attendances.user_id = users.id AND YEAR(date)='2024' AND month(date)='$bulan') AS jam_kerja, (SELECT COUNT(*) FROM leave_requests WHERE leave_requests.user_id = users.id AND YEAR(apply_date)='2024' AND month(apply_date)='$bulan') AND status_id=1 AS tdk_masuk, (SELECT COUNT(file) FROM monthly_report WHERE monthly_report.user_id = users.id AND year='2024' AND month='$nama_bulan') AS lap_bul, (SELECT COUNT(file_ttdbasah) FROM monthly_report WHERE monthly_report.user_id = users.id AND year='2024' AND month='$nama_bulan') AS ttd_basah, (SELECT nilai FROM evkin JOIN periode_evkin ON periode_evkin.id = evkin.periode_id WHERE evkin.user_id = users.id AND tahun='2024' AND bulan='$bulan' GROUP BY evkin.user_id) AS nilai_evkin FROM users LEFT JOIN wilayah_kabupaten ON wilayah_kabupaten.kdkab = users.kdkab WHERE department_id = 6 ORDER BY name ASC"));

                $korkab  = DB::select( DB::raw("SELECT name, nmkab, (SELECT COUNT(*) FROM attendances WHERE attendances.user_id = users.id AND YEAR(date)='2024' AND month(date)='$bulan') AS hari_kerja, (SELECT COUNT(*) FROM daily_activity WHERE daily_activity.created_by = users.id AND YEAR(date)='2024' AND month(date)='$bulan') AS akt_harian, (SELECT SUM(stay_time) FROM attendances WHERE attendances.user_id = users.id AND YEAR(date)='2024' AND month(date)='$bulan') AS jam_kerja, (SELECT COUNT(*) FROM leave_requests WHERE leave_requests.user_id = users.id AND YEAR(apply_date)='2024' AND month(apply_date)='$bulan') AND status_id=1 AS tdk_masuk, (SELECT COUNT(file) FROM monthly_report WHERE monthly_report.user_id = users.id AND year='2024' AND month='$nama_bulan') AS lap_bul, (SELECT COUNT(file_ttdbasah) FROM monthly_report WHERE monthly_report.user_id = users.id AND year='2024' AND month='$nama_bulan') AS ttd_basah, (SELECT nilai FROM evkin JOIN periode_evkin ON periode_evkin.id = evkin.periode_id WHERE evkin.user_id = users.id AND tahun='2024' AND bulan='$bulan' GROUP BY evkin.user_id) AS nilai_evkin FROM users LEFT JOIN wilayah_kabupaten ON wilayah_kabupaten.kdkab = users.kdkab WHERE department_id = 5 ORDER BY name ASC"));

            } else {

                $tahun = date('Y');
                $bulan = $_GET['bulan'];
                $kdprov = $_GET['kodeprov'];
                $kdkab = $_GET['kodekab'];
                $bulan = $_GET['bulan'];

                $nmprov = DB::select( DB::raw("SELECT nmprov FROM wilayah_provinsi WHERE kdprov = '$kdprov' "))['0']->nmprov;
                $nmkab = DB::select( DB::raw("SELECT nmkab FROM wilayah_kabupaten WHERE kdkab = '$kdkab' "))['0']->nmkab;
                $jml = DB::select( DB::raw("SELECT count(id) AS jml FROM users WHERE kdprov='$kdprov' AND kdkab='$kdkab' AND department_id != '1' AND department_id != '24' AND department_id != '25' AND department_id != '26' AND department_id != '27' AND department_id != '28' AND department_id != '29' AND department_id != '30' AND department_id != '31' AND department_id != '32' AND department_id != '33'"))['0']->jml;
                

                if ($bulan == 1) {
                    $nama_bulan = 'Januari';
                } else if ($bulan == 2) {
                    $nama_bulan = 'Februari';
                } else if ($bulan == 3) {
                    $nama_bulan = 'Maret';
                } else if ($bulan == 4) {
                    $nama_bulan = 'April';
                } else if ($bulan == 5) {
                    $nama_bulan = 'Mei';
                } else if ($bulan == 6) {
                    $nama_bulan = 'Juni';
                } else if ($bulan == 7) {
                    $nama_bulan = 'Juli';
                } else if ($bulan == 8) {
                    $nama_bulan = 'Agustus';
                } else if ($bulan == 9) {
                    $nama_bulan = 'September';
                } else if ($bulan == 10) {
                    $nama_bulan = 'Oktober';
                } else if ($bulan == 11) {
                    $nama_bulan = 'November';
                } else if ($bulan == 12) {
                    $nama_bulan = 'Desember';
                }
                
                $provinsi  = DB::select( DB::raw("SELECT * FROM wilayah_provinsi ORDER BY nmprov ASC"));

                $kader  = DB::select( DB::raw("SELECT name, nmkab, nmkec, nmdesa, (SELECT COUNT(*) FROM attendances WHERE attendances.user_id = users.id AND YEAR(date)='2024' AND month(date)='$bulan') AS hari_kerja, (SELECT COUNT(*) FROM daily_activity WHERE daily_activity.created_by = users.id AND YEAR(date)='2024' AND month(date)='$bulan') AS akt_harian, (SELECT SUM(stay_time) FROM attendances WHERE attendances.user_id = users.id AND YEAR(date)='2024' AND month(date)='$bulan') AS jam_kerja, (SELECT COUNT(*) FROM leave_requests WHERE leave_requests.user_id = users.id AND YEAR(apply_date)='2024' AND month(apply_date)='$bulan') AND status_id=1 AS tdk_masuk, (SELECT COUNT(file) FROM monthly_report WHERE monthly_report.user_id = users.id AND year='2024' AND month='$nama_bulan') AS lap_bul, (SELECT COUNT(file_ttdbasah) FROM monthly_report WHERE monthly_report.user_id = users.id AND year='2024' AND month='$nama_bulan') AS ttd_basah, (SELECT nilai FROM evkin JOIN periode_evkin ON periode_evkin.id = evkin.periode_id WHERE evkin.user_id = users.id AND tahun='2024' AND bulan='$bulan' GROUP BY evkin.user_id) AS nilai_evkin FROM users LEFT JOIN wilayah_kabupaten ON wilayah_kabupaten.kdkab = users.kdkab LEFT JOIN wilayah_kecamatan ON wilayah_kecamatan.kdkec = users.kdkec LEFT JOIN wilayah_desa ON wilayah_desa.kddesa = users.kddesa WHERE department_id = 8 AND users.kdprov='$kdprov' AND users.kdkab='$kdkab' ORDER BY name ASC"));

                $fasdis  = DB::select( DB::raw("SELECT name, nmkab, nmkec, (SELECT COUNT(*) FROM attendances WHERE attendances.user_id = users.id AND YEAR(date)='2024' AND month(date)='$bulan') AS hari_kerja, (SELECT COUNT(*) FROM daily_activity WHERE daily_activity.created_by = users.id AND YEAR(date)='2024' AND month(date)='$bulan') AS akt_harian, (SELECT SUM(stay_time) FROM attendances WHERE attendances.user_id = users.id AND YEAR(date)='2024' AND month(date)='$bulan') AS jam_kerja, (SELECT COUNT(*) FROM leave_requests WHERE leave_requests.user_id = users.id AND YEAR(apply_date)='2024' AND month(apply_date)='$bulan') AND status_id=1 AS tdk_masuk, (SELECT COUNT(file) FROM monthly_report WHERE monthly_report.user_id = users.id AND year='2024' AND month='$nama_bulan') AS lap_bul, (SELECT COUNT(file_ttdbasah) FROM monthly_report WHERE monthly_report.user_id = users.id AND year='2024' AND month='$nama_bulan') AS ttd_basah, (SELECT nilai FROM evkin JOIN periode_evkin ON periode_evkin.id = evkin.periode_id WHERE evkin.user_id = users.id AND tahun='2024' AND bulan='$bulan' GROUP BY evkin.user_id) AS nilai_evkin FROM users LEFT JOIN wilayah_kabupaten ON wilayah_kabupaten.kdkab = users.kdkab LEFT JOIN wilayah_kecamatan ON wilayah_kecamatan.kdkec = users.kdkec  WHERE department_id = 7 AND users.kdprov='$kdprov' AND users.kdkab='$kdkab' ORDER BY name ASC"));

                $faskab  = DB::select( DB::raw("SELECT name, nmkab, (SELECT COUNT(*) FROM attendances WHERE attendances.user_id = users.id AND YEAR(date)='2024' AND month(date)='$bulan') AS hari_kerja, (SELECT COUNT(*) FROM daily_activity WHERE daily_activity.created_by = users.id AND YEAR(date)='2024' AND month(date)='$bulan') AS akt_harian, (SELECT SUM(stay_time) FROM attendances WHERE attendances.user_id = users.id AND YEAR(date)='2024' AND month(date)='$bulan') AS jam_kerja, (SELECT COUNT(*) FROM leave_requests WHERE leave_requests.user_id = users.id AND YEAR(apply_date)='2024' AND month(apply_date)='$bulan') AND status_id=1 AS tdk_masuk, (SELECT COUNT(file) FROM monthly_report WHERE monthly_report.user_id = users.id AND year='2024' AND month='$nama_bulan') AS lap_bul, (SELECT COUNT(file_ttdbasah) FROM monthly_report WHERE monthly_report.user_id = users.id AND year='2024' AND month='$nama_bulan') AS ttd_basah, (SELECT nilai FROM evkin JOIN periode_evkin ON periode_evkin.id = evkin.periode_id WHERE evkin.user_id = users.id AND tahun='2024' AND bulan='$bulan' GROUP BY evkin.user_id) AS nilai_evkin FROM users LEFT JOIN wilayah_kabupaten ON wilayah_kabupaten.kdkab = users.kdkab WHERE department_id = 6 AND users.kdprov='$kdprov' AND users.kdkab='$kdkab' ORDER BY name ASC"));

                $korkab  = DB::select( DB::raw("SELECT name, nmkab, (SELECT COUNT(*) FROM attendances WHERE attendances.user_id = users.id AND YEAR(date)='2024' AND month(date)='$bulan') AS hari_kerja, (SELECT COUNT(*) FROM daily_activity WHERE daily_activity.created_by = users.id AND YEAR(date)='2024' AND month(date)='$bulan') AS akt_harian, (SELECT SUM(stay_time) FROM attendances WHERE attendances.user_id = users.id AND YEAR(date)='2024' AND month(date)='$bulan') AS jam_kerja, (SELECT COUNT(*) FROM leave_requests WHERE leave_requests.user_id = users.id AND YEAR(apply_date)='2024' AND month(apply_date)='$bulan') AND status_id=1 AS tdk_masuk, (SELECT COUNT(file) FROM monthly_report WHERE monthly_report.user_id = users.id AND year='2024' AND month='$nama_bulan') AS lap_bul, (SELECT COUNT(file_ttdbasah) FROM monthly_report WHERE monthly_report.user_id = users.id AND year='2024' AND month='$nama_bulan') AS ttd_basah, (SELECT nilai FROM evkin JOIN periode_evkin ON periode_evkin.id = evkin.periode_id WHERE evkin.user_id = users.id AND tahun='2024' AND bulan='$bulan' GROUP BY evkin.user_id) AS nilai_evkin FROM users LEFT JOIN wilayah_kabupaten ON wilayah_kabupaten.kdkab = users.kdkab WHERE department_id = 5 AND users.kdprov='$kdprov' AND users.kdkab='$kdkab' ORDER BY name ASC"));

            }
            

            return view('drp.admin.export-rekap-bulanan', compact('provinsi', 'kader', 'fasdis', 'faskab', 'korkab', 'nmprov', 'nmkab', 'jml', 'nama_bulan'));
            
        } else {

            return redirect('sign-in');
        }
        
    }

    public function getLaporanFasilitator(Request $request, $page, $limit, $search, $kdprov, $kdkab, $kdkec, $kddesa)
    {
        $user = Auth::user();

        if ($search != "all" AND $kdprov== 'all' AND $kdkab == 'all' AND $kdkec == 'all' AND $kddesa=='all') {
            $where = "WHERE users.name LIKE '%" . $search . "%'";
        }  else if($search != "all" AND $kdprov!= 'all' AND $kdkab == 'all' AND $kdkec == 'all' AND $kddesa=='all') {
            $where = "WHERE users.name LIKE '%" . $search . "%' AND users.kdprov='$kdprov'";
        }  else if($search != "all" AND $kdprov!= 'all' AND $kdkab != 'all' AND $kdkec == 'all' AND $kddesa=='all') {
            $where = "WHERE users.name LIKE '%" . $search . "%' AND users.kdprov='$kdprov' AND users.kdkab='$kdkab'";
        }  else if($search != "all" AND $kdprov!= 'all' AND $kdkab != 'all' AND $kdkec != 'all' AND $kddesa=='all') {
            $where = "WHERE users.name LIKE '%" . $search . "%' AND users.kdprov='$kdprov' AND users.kdkab='$kdkab' AND users.kdkec='$kdkec'";
        } else if($search != "all" AND $kdprov!= 'all' AND $kdkab != 'all' AND $kdkec != 'all' AND $kddesa!='all') {
            $where = "WHERE users.name LIKE '%" . $search . "%' AND users.kdprov='$kdprov' AND users.kdkab='$kdkab' AND users.kdkec='$kdkec' AND users.kddesa='$kddesa'";
        } else if($search == "all" AND $kdprov!= 'all' AND $kdkab == 'all' AND $kdkec == 'all' AND $kddesa =='all') {
            $where = "WHERE users.kdprov='$kdprov'";
        } else if($search == "all" AND $kdprov!= 'all' AND $kdkab != 'all' AND $kdkec == 'all' AND $kddesa =='all') {
            $where = "WHERE users.kdprov='$kdprov' AND users.kdkab='$kdkab'";
        } else if($search == "all" AND $kdprov!= 'all' AND $kdkab != 'all' AND $kdkec != 'all' AND $kddesa =='all') {
            $where = "WHERE users.kdprov='$kdprov' AND users.kdkab='$kdkab' AND users.kdkec='$kdkec'";
        } else if($search == "all" AND $kdprov!= 'all' AND $kdkab != 'all' AND $kdkec != 'all' AND $kddesa !='all') {
            $where = "WHERE users.kdprov='$kdprov' AND users.kdkab='$kdkab' AND users.kdkec='$kdkec' AND users.kddesa='$kddesa'";
        } else {
            $where = '';
        }

        if($user) {

            $page_ = $page - 1;
            $total = $page_ * $limit;
            $isadmin = Auth::user()->is_admin;

            if($isadmin==1) {

                $data  = DB::select( DB::raw("SELECT *,users.id AS id_main, users.name AS nama FROM  users  LEFT JOIN departments ON departments.id = users.department_id $where  ORDER BY users.id DESC LIMIT $total, $limit "));
                $count  = DB::select( DB::raw("SELECT COUNT(users.id) AS id FROM users  $where "))['0']->id;
            
                $total_page = ceil($count / $limit);

                if($total_page == 0) {
                    $total_page = 1;
                }   

                return response()->json(['status' => 'success' ,'data' => $data, 'count' => $count, 'total_page' => $total_page, 'total' => $total]);

            } 
            
        } else {

            return redirect('sign-in');
        }
        
    } 


    public function getLaporanRekapBulanan(Request $request, $search, $kdprov, $kdkab, $kdkec, $kddesa)
    {
        $user = Auth::user();

        if ($search != "all" AND $kdprov== 'all' AND $kdkab == 'all' AND $kdkec == 'all' AND $kddesa=='all') {
            $where = "WHERE users.name LIKE '%" . $search . "%'";
        }  else if($search != "all" AND $kdprov!= 'all' AND $kdkab == 'all' AND $kdkec == 'all' AND $kddesa=='all') {
            $where = "WHERE users.name LIKE '%" . $search . "%' AND users.kdprov='$kdprov'";
        }  else if($search != "all" AND $kdprov!= 'all' AND $kdkab != 'all' AND $kdkec == 'all' AND $kddesa=='all') {
            $where = "WHERE users.name LIKE '%" . $search . "%' AND users.kdprov='$kdprov' AND users.kdkab='$kdkab'";
        }  else if($search != "all" AND $kdprov!= 'all' AND $kdkab != 'all' AND $kdkec != 'all' AND $kddesa=='all') {
            $where = "WHERE users.name LIKE '%" . $search . "%' AND users.kdprov='$kdprov' AND users.kdkab='$kdkab' AND users.kdkec='$kdkec'";
        } else if($search != "all" AND $kdprov!= 'all' AND $kdkab != 'all' AND $kdkec != 'all' AND $kddesa!='all') {
            $where = "WHERE users.name LIKE '%" . $search . "%' AND users.kdprov='$kdprov' AND users.kdkab='$kdkab' AND users.kdkec='$kdkec' AND users.kddesa='$kddesa'";
        } else if($search == "all" AND $kdprov!= 'all' AND $kdkab == 'all' AND $kdkec == 'all' AND $kddesa =='all') {
            $where = "WHERE users.kdprov='$kdprov'";
        } else if($search == "all" AND $kdprov!= 'all' AND $kdkab != 'all' AND $kdkec == 'all' AND $kddesa =='all') {
            $where = "WHERE users.kdprov='$kdprov' AND users.kdkab='$kdkab'";
        } else if($search == "all" AND $kdprov!= 'all' AND $kdkab != 'all' AND $kdkec != 'all' AND $kddesa =='all') {
            $where = "WHERE users.kdprov='$kdprov' AND users.kdkab='$kdkab' AND users.kdkec='$kdkec'";
        } else if($search == "all" AND $kdprov!= 'all' AND $kdkab != 'all' AND $kdkec != 'all' AND $kddesa !='all') {
            $where = "WHERE users.kdprov='$kdprov' AND users.kdkab='$kdkab' AND users.kdkec='$kdkec' AND users.kddesa='$kddesa'";
        } else {
            $where = '';
        }

        if($user) {

            
            $isadmin = Auth::user()->is_admin;

            if($isadmin==1) {

                $data  = DB::select( DB::raw("SELECT *,users.id AS id_main, users.name AS nama FROM  users  LEFT JOIN departments ON departments.id = users.department_id $where  ORDER BY users.id DESC "));
                $count  = DB::select( DB::raw("SELECT COUNT(users.id) AS id FROM users  $where "))['0']->id;
                   

                return response()->json(['status' => 'success' ,'data' => $data, 'count' => $count]);

            } 
            
        } else {

            return redirect('sign-in');
        }
        
    } 


    public function getLaporanCronjob(Request $request, $page, $limit, $date)
    {
        $user = Auth::user();
        if ($date != "all") {
            $date = date("Y-m-d", strtotime($date));
            $where = "WHERE DATE(date)='$date'";
        }  else {
            $where = "";
        }                    

        if($user) {

            $page_ = $page - 1;
            $total = $page_ * $limit;
            $isadmin = Auth::user()->is_admin;

            if($isadmin==1) {

                $data  = DB::select( DB::raw("SELECT * FROM cronjob $where  ORDER BY id DESC LIMIT $total, $limit "));
                $count  = DB::select( DB::raw("SELECT COUNT(id) AS id FROM cronjob  $where "))['0']->id;
            
                $total_page = ceil($count / $limit);

                if($total_page == 0) {
                    $total_page = 1;
                }   

                return response()->json(['status' => 'success' ,'data' => $data, 'count' => $count, 'total_page' => $total_page, 'total' => $total]);

            } 
            
        } else {

            return redirect('sign-in');
        }
        
    } 

    
    public function downloadLaporanaktharian($id_user)
    {
        $user = Auth::user();

        if($user) {

            $check_durasi  = DB::select( DB::raw("SELECT id, timestampdiff(second, check_in, check_out) AS detik FROM attendances WHERE stay_time IS NULL"));
    
            if (count($check_durasi) > 0) {
                foreach ($check_durasi as $value) {

                    if ($value->detik > 28800) {
                        $durasi = 28800;
                    } else {
                        $durasi = $value->detik;
                    }

                    Attendance::where('id',$value->id)->update(['stay_time' => $durasi]);
                }
            }

            $bulan = date('m');
            $tahun = date('Y');
            $data  = DB::select( DB::raw("SELECT * FROM users WHERE id='$id_user'"));
            $nama = $data['0']->name;
            $id_dep = $data['0']->department_id;

            if ($id_dep==8 || $id_dep==7 || $id_dep==6 || $id_dep==5) {

                $kdprov = $data['0']->kdprov;
                $kdkab = $data['0']->kdkab;
                $kdkec = $data['0']->kdkec;
                $kddesa = $data['0']->kddesa;
                $currentMonth = now()->month;
                $currentYear = now()->year;
                $data  = DB::select( DB::raw("SELECT * FROM daily_activity WHERE created_by = '$id_user' and YEAR(date) = '$currentYear' and MONTH(date) = '$currentMonth' ORDER BY id DESC"));
                $leave  = DB::select( DB::raw("SELECT *,leave_types.name AS name, leave_requests.status_id AS stt, leave_requests.days AS durasi FROM leave_requests  Join assign_leaves on assign_leaves.id = leave_requests.assign_leave_id LEFT JOIN leave_types ON assign_leaves.type_id = leave_types.id  WHERE leave_requests.user_id = '$id_user' AND MONTH(leave_from) = '$bulan' AND leave_requests.status_id=1"));
                $durasi_  = DB::select( DB::raw("SELECT SUM(stay_time) AS detik FROM attendances WHERE user_id='$id_user' AND YEAR(date) = '$tahun' and MONTH(date) = '$bulan'"))['0']->detik;
                if ($durasi_==null) {
                    $durasi = 0;
                } else {
                    $durasi = $durasi_;
                }

                $total_kerja  = DB::select( DB::raw("SELECT COUNT(id) AS id FROM attendances WHERE user_id='$id_user' AND YEAR(date) = '$tahun' and MONTH(date) = '$bulan'"))['0']->id;

                $department  = DB::select( DB::raw("SELECT title FROM departments WHERE id = '$id_dep'"))['0']->title;
                $nmprov  = DB::select( DB::raw("SELECT nmprov FROM wilayah_provinsi WHERE kdprov = '$kdprov'"))['0']->nmprov;

                $nmkab  = DB::select( DB::raw("SELECT nmkab FROM wilayah_kabupaten WHERE kdkab = '$kdkab'"))['0']->nmkab;

                if ($id_dep == 8) {
                    $nmkec  = DB::select( DB::raw("SELECT nmkec FROM wilayah_kecamatan WHERE kdkec = '$kdkec'"))['0']->nmkec;
                    $nmdesa  = DB::select( DB::raw("SELECT nmdesa FROM wilayah_desa WHERE kddesa = '$kddesa'"))['0']->nmdesa;
                } else if ($id_dep == 7) {
                    $nmkec  = DB::select( DB::raw("SELECT nmkec FROM wilayah_kecamatan WHERE kdkec = '$kdkec'"))['0']->nmkec;
                    $nmdesa  = '';
                } else if ($id_dep == 6 || $id_dep == 5) {
                    $nmkec  = '';
                    $nmdesa  = '';
                }


                
                return view('drp.fasilitator.eksport-laporan-aktivitasharian', compact('data', 'department', 'nama', 'nmprov', 'nmkab', 'id_dep', 'nmkec', 'nmdesa', 'bulan', 'tahun', 'durasi', 'total_kerja', 'leave'));

            } else {

                echo "Maaf, jenis peran tidak tersedia di laporan aplikasi e-LAPKIN.";

            }
            
            
        } else {

            return redirect('sign-in');
        }
        
    }

    public function getPreviewAktivitas($id_user)
    {
        $user = Auth::user();

        if($user) {

            $check_durasi  = DB::select( DB::raw("SELECT id, timestampdiff(second, check_in, check_out) AS detik FROM attendances WHERE stay_time IS NULL"));
    
            if (count($check_durasi) > 0) {
                foreach ($check_durasi as $value) {

                    if ($value->detik > 28800) {
                        $durasi = 28800;
                    } else {
                        $durasi = $value->detik;
                    }

                    Attendance::where('id',$value->id)->update(['stay_time' => $durasi]);
                }
            }

            $bulan = date('m');
            $tahun = date('Y');
            $data  = DB::select( DB::raw("SELECT * FROM users WHERE id='$id_user'"));
            $nama = $data['0']->name;
            $id_dep = $data['0']->department_id;
            
            if ($id_dep==8 || $id_dep==7 || $id_dep==6 || $id_dep==5) {

                $kdprov = $data['0']->kdprov;
                $kdkab = $data['0']->kdkab;
                $kdkec = $data['0']->kdkec;
                $kddesa = $data['0']->kddesa;
                $currentMonth = now()->month;
                $currentYear = now()->year;
                $data  = DB::select( DB::raw("SELECT * FROM daily_activity WHERE created_by = '$id_user' and YEAR(date) = '$currentYear' and MONTH(date) = '$currentMonth' ORDER BY id DESC"));
                $durasi  = DB::select( DB::raw("SELECT SUM(stay_time) AS detik FROM attendances WHERE user_id='$id_user' AND YEAR(date) = '$tahun' and MONTH(date) = '$bulan'"))['0']->detik;
                $leave  = DB::select( DB::raw("SELECT *,leave_types.name AS name, leave_requests.status_id AS stt, leave_requests.days AS durasi FROM leave_requests  Join assign_leaves on assign_leaves.id = leave_requests.assign_leave_id LEFT JOIN leave_types ON assign_leaves.type_id = leave_types.id  WHERE leave_requests.user_id = '$id_user' AND MONTH(leave_from) = '$bulan' AND leave_requests.status_id=1"));
                $total_kerja  = DB::select( DB::raw("SELECT COUNT(id) AS id FROM attendances WHERE user_id='$id_user' AND YEAR(date) = '$tahun' and MONTH(date) = '$bulan'"))['0']->id;
                $department  = DB::select( DB::raw("SELECT title FROM departments WHERE id = '$id_dep'"))['0']->title;
                $nmprov  = DB::select( DB::raw("SELECT nmprov FROM wilayah_provinsi WHERE kdprov = '$kdprov'"))['0']->nmprov;
                $nmkab  = DB::select( DB::raw("SELECT nmkab FROM wilayah_kabupaten WHERE kdkab = '$kdkab'"))['0']->nmkab;
                if ($id_dep == 8) {
                    $nmkec  = DB::select( DB::raw("SELECT nmkec FROM wilayah_kecamatan WHERE kdkec = '$kdkec'"))['0']->nmkec;
                    $nmdesa  = DB::select( DB::raw("SELECT nmdesa FROM wilayah_desa WHERE kddesa = '$kddesa'"))['0']->nmdesa;
                } else if ($id_dep == 7) {
                    $nmkec  = DB::select( DB::raw("SELECT nmkec FROM wilayah_kecamatan WHERE kdkec = '$kdkec'"))['0']->nmkec;
                    $nmdesa  = '';
                } else if ($id_dep == 6 || $id_dep == 5) {
                    $nmkec  = '';
                    $nmdesa  = '';
                }
                
                return view('drp.fasilitator.preview-aktivitas-harian', compact('data', 'department', 'nama', 'nmprov', 'nmkab', 'id_dep', 'nmkec', 'nmdesa', 'bulan', 'tahun', 'durasi', 'total_kerja', 'leave'));

            } else {

                echo "Maaf, jenis peran tidak tersedia di laporan aplikasi e-LAPKIN.";

            }
            
            
        } else {

            return redirect('sign-in');
        }
        
    }

    public function downloadLaporanabsensi($id_user)
    {
        $user = Auth::user();

        if($user) {

            $data  = DB::select( DB::raw("SELECT * FROM users WHERE id='$id_user'"));
            $nama = $data['0']->name;
            $id_dep = $data['0']->department_id;
            
            if ($id_dep==8 || $id_dep==7 || $id_dep==6 || $id_dep==5) {
                
                $kdprov = $data['0']->kdprov;
                $kdkab = $data['0']->kdkab;
                $kdkec = $data['0']->kdkec;
                $kddesa = $data['0']->kddesa;
                $currentMonth = now()->month;
                $currentYear = now()->year;

                $data  = DB::select( DB::raw("SELECT * FROM attendances WHERE user_id = '$id_user' and YEAR(date) = '$currentYear' and MONTH(date) = '$currentMonth' ORDER BY id DESC"));
                
                $department  = DB::select( DB::raw("SELECT title FROM departments WHERE id = '$id_dep'"))['0']->title;
                $nmprov  = DB::select( DB::raw("SELECT nmprov FROM wilayah_provinsi WHERE kdprov = '$kdprov'"))['0']->nmprov;
                $nmkab  = DB::select( DB::raw("SELECT nmkab FROM wilayah_kabupaten WHERE kdkab = '$kdkab'"))['0']->nmkab;
                if ($id_dep == 8) {
                    $nmkec  = DB::select( DB::raw("SELECT nmkec FROM wilayah_kecamatan WHERE kdkec = '$kdkec'"))['0']->nmkec;
                    $nmdesa  = DB::select( DB::raw("SELECT nmdesa FROM wilayah_desa WHERE kddesa = '$kddesa'"))['0']->nmdesa;
                } else if ($id_dep == 7) {
                    $nmkec  = DB::select( DB::raw("SELECT nmkec FROM wilayah_kecamatan WHERE kdkec = '$kdkec'"))['0']->nmkec;
                    $nmdesa  = '';
                } else if ($id_dep == 6 || $id_dep == 5) {
                    $nmkec  = '';
                    $nmdesa  = '';
                } 
                
                
                return view('drp.fasilitator.eksport-absensi', compact('data', 'department', 'nama', 'nmprov', 'nmkab', 'id_dep', 'nmkec', 'nmdesa'));
            } else {

                echo "Maaf, jenis peran tidak tersedia di laporan aplikasi e-LAPKIN.";

            }
            
        } else {

            return redirect('sign-in');
        }
        
    }

    

    public function getPreviewAbsensi($id_user)
    {
        
        $user = Auth::user();

        if($user) {

            $data  = DB::select( DB::raw("SELECT * FROM users WHERE id='$id_user'"));
            $nama = $data['0']->name;
            $id_dep = $data['0']->department_id;
            if ($id_dep==8 || $id_dep==7 || $id_dep==6 || $id_dep==5) {
                
                $kdprov = $data['0']->kdprov;
                $kdkab = $data['0']->kdkab;
                $kdkec = $data['0']->kdkec;
                $kddesa = $data['0']->kddesa;
                $currentMonth = now()->month;
                $currentYear = now()->year;

                $data  = DB::select( DB::raw("SELECT * FROM attendances WHERE user_id = '$id_user' and YEAR(date) = '$currentYear' and MONTH(date) = '$currentMonth' ORDER BY id DESC"));
                
                $department  = DB::select( DB::raw("SELECT title FROM departments WHERE id = '$id_dep'"))['0']->title;
                $nmprov  = DB::select( DB::raw("SELECT nmprov FROM wilayah_provinsi WHERE kdprov = '$kdprov'"))['0']->nmprov;
                $nmkab  = DB::select( DB::raw("SELECT nmkab FROM wilayah_kabupaten WHERE kdkab = '$kdkab'"))['0']->nmkab;
                if ($id_dep == 8) {
                    $nmkec  = DB::select( DB::raw("SELECT nmkec FROM wilayah_kecamatan WHERE kdkec = '$kdkec'"))['0']->nmkec;
                    $nmdesa  = DB::select( DB::raw("SELECT nmdesa FROM wilayah_desa WHERE kddesa = '$kddesa'"))['0']->nmdesa;
                } else if ($id_dep == 7) {
                    $nmkec  = DB::select( DB::raw("SELECT nmkec FROM wilayah_kecamatan WHERE kdkec = '$kdkec'"))['0']->nmkec;
                    $nmdesa  = '';
                } else if ($id_dep == 6 || $id_dep == 5) {
                    $nmkec  = '';
                    $nmdesa  = '';
                } 
                
                
                return view('drp.fasilitator.preview-absensi', compact('data', 'department', 'nama', 'nmprov', 'nmkab', 'id_dep', 'nmkec', 'nmdesa'));
            } else {

                echo "Maaf, jenis peran tidak tersedia di laporan aplikasi e-LAPKIN.";

            }
            
            
        } else {

            return redirect('sign-in');
        }
        
    }

    
    
        
    
}
