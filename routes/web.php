<?php

use Carbon\Carbon;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DevController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\ValidationMessageController;
use App\Http\Controllers\ExpireNotificationController;
use App\Http\Controllers\Frontend\NavigatorController;
use App\Http\Controllers\Frontend\Auth\LoginController;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

use App\Http\Controllers\Drp\RegisterdrpController;
use App\Http\Controllers\Drp\ProvinsiController;
use App\Http\Controllers\Drp\KabupatenController;
use App\Http\Controllers\Drp\KecamatanController;
use App\Http\Controllers\Drp\DesaController;
use App\Http\Controllers\Drp\RoleController;
use App\Http\Controllers\Drp\FasilitatorController;
use App\Http\Controllers\Drp\EvkinController;
use App\Http\Controllers\Drp\UserController;
use App\Http\Controllers\Drp\AbsensiController;
use App\Http\Controllers\Drp\AktivitasharianController;
use App\Http\Controllers\Drp\LaporanbulananController;
use App\Http\Controllers\Drp\TidakmasukController;
use App\Http\Controllers\Drp\LaporanController;
use App\Http\Controllers\Drp\KonfigurasiController;


Route::view('/privacy', 'privacy');
Route::middleware(['demo.mode'])->group(function () {

if(!in_array(url('/'), config('tenancy.central_domains')) && config('app.mood') === 'Saas'  && isModuleActive('Saas')) {
    $middleware = [
        'web',
        InitializeTenancyByDomain::class,
        PreventAccessFromCentralDomains::class,
    ];
}else{
    $middleware = ['web'];
}


Route::get('daftar-fasilitator', [FasilitatorController::class, 'index']);
Route::get('daftar-fasilitator/{page}/{limit}/{search}/{kdprov}/{kdkab}/{kdkec}/{kddesa}', [FasilitatorController::class, 'getFasilitator']);
Route::get('eksport-aktivitas-harian-apiv2/{id}/{bulan}/{tahun}', [AktivitasharianController::class, 'eksportAktivitasApiV2']);
Route::get('eksport-aktivitas-harian-api/{id}', [AktivitasharianController::class, 'eksportAktivitasApi']);
Route::get('register-drp', [RegisterdrpController::class, 'index']);
Route::get('success-register', [RegisterdrpController::class, 'successRegister']);

Route::get('get-kab/{id}', [RegisterdrpController::class, 'getKab']);
Route::get('get-kec/{id}', [RegisterdrpController::class, 'getKec']);
Route::get('get-desa/{id}', [RegisterdrpController::class, 'getDesa']);
Route::post('save-register', [RegisterdrpController::class, 'saveRegister']);
Route::post('add-dataregister', [RegisterdrpController::class, 'addDataRegister']);
Route::post('verification-email/{id}', [RegisterdrpController::class, 'verifikasiEmail']);
Route::put('update-register/{id}', [RegisterdrpController::class, 'updateRegister']);
Route::delete('delete-register/{id}', [RegisterdrpController::class, 'deleteRegister']);
Route::put('update-register-backup/{id}', [RegisterdrpController::class, 'updateRegisterBackup']);


Route::get('provinsi', [ProvinsiController::class, 'index']);
Route::get('get-provinsi/{page}/{limit}/{search}', [ProvinsiController::class, 'getProvinsi']);
Route::get('get-data-prov', [ProvinsiController::class, 'getData']);

Route::get('kabupaten', [KabupatenController::class, 'index']);
Route::get('get-kabupaten/{page}/{limit}/{search}', [KabupatenController::class, 'getKabupaten']);
Route::get('get-data-kab', [KabupatenController::class, 'getData']);


Route::get('kecamatan', [KecamatanController::class, 'index']);
Route::get('get-kecamatan/{page}/{limit}/{search}', [KecamatanController::class, 'getKecamatan']);
Route::get('get-data-kec', [KecamatanController::class, 'getData']);

Route::get('desa', [DesaController::class, 'index']);
Route::get('get-desa/{page}/{limit}/{search}', [DesaController::class, 'getDesa']);
Route::get('get-data-desa', [DesaController::class, 'getData']);

Route::get('role', [RoleController::class, 'index']);
Route::get('get-role/{page}/{limit}/{search}', [RoleController::class, 'getRole']);
Route::get('get-data-role', [RoleController::class, 'getData']);
Route::get('list-role', [RoleController::class, 'listRole']);


Route::get('periode-evkin', [EvkinController::class, 'index']);
Route::get('get-periode/{page}/{limit}/{month}/{year}', [EvkinController::class, 'getData']);
Route::get('periode-evkin-admin', [EvkinController::class, 'periodeEvkin']);
Route::get('periode-evkin-admin/{page}/{limit}/{month}/{year}/{kdprov}/{kdkab}/{kdkec}', [EvkinController::class, 'getPeriodeEvkin']);
Route::post('add-periode', [EvkinController::class, 'addData']);
Route::get('get-periode/{id}', [EvkinController::class, 'getDataDetail']);
Route::post('update-periode', [EvkinController::class, 'updateData']);

Route::get('evkin-korkab', [EvkinController::class, 'evkinKorkab']);
Route::get('get-evkin-korkab/{page}/{limit}/{month}/{year}', [EvkinController::class, 'getEvkinKorkab']);
Route::get('evkin-faskab', [EvkinController::class, 'evkinFaskab']);
Route::get('get-evkin-faskab/{page}/{limit}/{month}/{year}', [EvkinController::class, 'getEvkinFaskab']);
Route::get('evkin-fasdis', [EvkinController::class, 'evkinFasdis']);
Route::get('get-evkin-fasdis/{page}/{limit}/{month}/{year}', [EvkinController::class, 'getEvkinFasdis']);
Route::get('evkin-kader', [EvkinController::class, 'evkinKader']);
Route::get('get-evkin-kader/{page}/{limit}/{month}/{year}', [EvkinController::class, 'getEvkinKader']);


Route::get('evkin-fasilitator/{id_periode}', [EvkinController::class, 'evkinFasilitator']);
Route::get('get-evkin-fasilitator/{page}/{limit}/{id_periode}/{search}', [EvkinController::class, 'getEvkinFasilitator']);
Route::get('nilai-fasilitator/{id_periode}/{id_user}', [EvkinController::class, 'nilaiFasilitator']);
Route::get('edit-nilai-fasilitator/{id_periode}/{id_user}', [EvkinController::class, 'editnilaiFasilitator']);
Route::get('profil-fasilitator/{id_periode}/{id_user}', [EvkinController::class, 'profilFasilitator']);
Route::post('update-nilai-evkin', [EvkinController::class, 'updateNilaiEvkin']);
Route::get('detail-nilai/{id_periode}/{id_user}', [EvkinController::class, 'detailNilai']);
Route::post('add-fasilitator-evkin', [EvkinController::class, 'addFasilitatorEvkin']);
Route::post('delete-fasilitator-evkin', [EvkinController::class, 'deleteFasilitatorEvkin']);

Route::get('evkin-saya', [EvkinController::class, 'evkinSaya']);
Route::get('get-evkin-saya/{page}/{limit}/{month}/{year}', [EvkinController::class, 'getEvkinSaya']);
Route::post('delete-evkin', [EvkinController::class, 'deleteEvkin']);

Route::get('get-data-user/{id}', [UserController::class, 'getDataUser']);
Route::get('profile', [UserController::class, 'profile']);
Route::post('update-status-user', [UserController::class, 'updateStatusUser']);
Route::post('delete-user', [UserController::class, 'deleteUser']);
Route::get('sync-user-monev', [UserController::class, 'syncUser']);

Route::get('absensi', [AbsensiController::class, 'absensiAdmin']);
Route::get('absensi-admin/{page}/{limit}/{search}/{date}/{kdprov}/{kdkab}/{kdkec}/{kddesa}', [AbsensiController::class, 'getAbsensiadmin']);
Route::get('absensi-saya', [AbsensiController::class, 'absensiSaya']);
Route::get('absensi-saya/{page}/{limit}/{date}', [AbsensiController::class, 'getAbsensiSaya']);
Route::get('absensi-tim-saya', [AbsensiController::class, 'index']);
Route::get('absensi-tim-saya/{page}/{limit}/{date}', [AbsensiController::class, 'getAbsensiTim']);

Route::get('absensi-korkab', [AbsensiController::class, 'absensiKorkab']);
Route::get('absensi-korkab/{page}/{limit}/{search}/{date}', [AbsensiController::class, 'getAbsensiKorkab']);
Route::get('absensi-faskab', [AbsensiController::class, 'absensiFaskab']);
Route::get('absensi-faskab/{page}/{limit}/{search}/{date}', [AbsensiController::class, 'getAbsensiFaskab']);
Route::get('absensi-fasdis', [AbsensiController::class, 'absensiFasdis']);
Route::get('absensi-fasdis/{page}/{limit}/{search}/{date}', [AbsensiController::class, 'getAbsensiFasdis']);
Route::get('absensi-kader', [AbsensiController::class, 'absensiKader']);
Route::get('absensi-kader/{page}/{limit}/{search}/{date}', [AbsensiController::class, 'getAbsensiKader']);
Route::post('delete-absensi', [AbsensiController::class, 'deleteAbsensi']);
Route::post('delete-absensi-pulang', [AbsensiController::class, 'deleteAbsensiPulang']);

Route::get('tidak-masuk', [TidakmasukController::class, 'tidakMasuk']);
Route::get('tidak-masuk/{page}/{limit}/{search}/{date}/{kdprov}/{kdkab}/{kdkec}/{kddesa}', [TidakmasukController::class, 'getTidakMasuk']);
Route::get('tidak-masuk-saya', [TidakmasukController::class, 'tidakMasukSaya']);
Route::get('tidak-masuk-saya/{page}/{limit}/{date}', [TidakmasukController::class, 'getTidakMasukSaya']);
Route::get('tidak-masuk-tim', [TidakmasukController::class, 'tidakMasukTim']);
Route::get('tidak-masuk-tim/{page}/{limit}/{date}', [TidakmasukController::class, 'getTidakMasukTim']);
Route::get('tambah-tidak-masuk', [TidakmasukController::class, 'tambahTidakMasuk']);
Route::post('simpan-tidak-masuk', [TidakmasukController::class, 'saveTidakMasuk']);
Route::get('edit-tidak-masuk/{id}', [TidakmasukController::class, 'editTidakMasuk']);
Route::post('update-tidak-masuk', [TidakmasukController::class, 'updateTidakMasuk']);
Route::get('get-data-tidakmasuk/{id}', [TidakmasukController::class, 'getDataTidakMasuk']);
Route::post('update-status-pengajuan', [TidakmasukController::class, 'updateStatusPengajuan']);

Route::get('tidak-masuk-korkab', [TidakmasukController::class, 'tidakMasukKorkab']);
Route::get('tidak-masuk-korkab/{page}/{limit}/{date}', [TidakmasukController::class, 'getTidakMasukKorkab']);
Route::get('tidak-masuk-faskab', [TidakmasukController::class, 'tidakMasukFaskab']);
Route::get('tidak-masuk-faskab/{page}/{limit}/{date}', [TidakmasukController::class, 'getTidakMasukFaskab']);
Route::get('tidak-masuk-fasdis', [TidakmasukController::class, 'tidakMasukFasdis']);
Route::get('tidak-masuk-fasdis/{page}/{limit}/{date}', [TidakmasukController::class, 'getTidakMasukFasdis']);
Route::get('tidak-masuk-kader', [TidakmasukController::class, 'tidakMasukKader']);
Route::get('tidak-masuk-kader/{page}/{limit}/{date}', [TidakmasukController::class, 'getTidakMasukKader']);
Route::post('delete-tidak-masuk', [TidakmasukController::class, 'deleteTidakMasuk']);

Route::get('aktivitas-harian', [AktivitasharianController::class, 'aktivitasHarian']);
Route::get('aktivitas-harian/{page}/{limit}/{search}/{date}/{kdprov}/{kdkab}/{kdkec}/{kddesa}', [AktivitasharianController::class, 'getAktivitasHarian']);
Route::get('aktivitas-harian-saya', [AktivitasharianController::class, 'aktivitasSaya']);
Route::get('aktivitas-harian-saya/{page}/{limit}/{date}', [AktivitasharianController::class, 'getAktivitasSaya']);
Route::get('tambah-aktivitas-harian', [AktivitasharianController::class, 'tambahAktivitas']);
Route::post('simpan-aktivitas-harian', [AktivitasharianController::class, 'saveAktivitas']);
Route::get('edit-aktivitas-harian/{id}', [AktivitasharianController::class, 'editAktivitas']);
Route::post('update-aktivitas-harian', [AktivitasharianController::class, 'updateAktivitas']);
Route::get('aktivitas-harian-tim', [AktivitasharianController::class, 'index']);
Route::get('aktivitas-harian-tim-saya/{page}/{limit}/{date}', [AktivitasharianController::class, 'getAktivitasTim']);

Route::get('eksport-aktivitas-harian/{bulan}/{tahun}', [AktivitasharianController::class, 'eksportAktivitas']);

Route::get('aktivitas-harian-korkab', [AktivitasharianController::class, 'aktivitasKorkab']);
Route::get('aktivitas-harian-korkab/{page}/{limit}/{date}', [AktivitasharianController::class, 'getAktivitasKorkab']);
Route::get('aktivitas-harian-faskab', [AktivitasharianController::class, 'aktivitasFaskab']);
Route::get('aktivitas-harian-faskab/{page}/{limit}/{date}', [AktivitasharianController::class, 'getAktivitasFaskab']);
Route::get('aktivitas-harian-fasdis', [AktivitasharianController::class, 'aktivitasFasdis']);
Route::get('aktivitas-harian-fasdis/{page}/{limit}/{date}', [AktivitasharianController::class, 'getAktivitasFasdis']);
Route::get('aktivitas-harian-kader', [AktivitasharianController::class, 'aktivitasKader']);
Route::get('aktivitas-harian-kader/{page}/{limit}/{date}', [AktivitasharianController::class, 'getAktivitasKader']);
Route::post('delete-aktivitas-harian', [AktivitasharianController::class, 'deleteAktivitasHarian']);
Route::get('detail-realisasi/{id}', [AktivitasharianController::class, 'detailRealisasi']);

Route::get('laporan-bulanan', [LaporanbulananController::class, 'laporanBulanan']);
Route::get('laporan-bulanan/{page}/{limit}/{search}/{month}/{year}/{kdprov}/{kdkab}/{kdkec}/{kddesa}', [LaporanbulananController::class, 'getLaporanBulanan']);
Route::get('laporan-bulanan-tim', [LaporanbulananController::class, 'index']);
Route::get('laporan-bulanan-tim/{page}/{limit}/{month}/{year}', [LaporanbulananController::class, 'getLaporanTim']);
Route::get('laporan-bulanan-saya', [LaporanbulananController::class, 'laporanSaya']);
Route::get('laporan-bulanan-saya/{page}/{limit}/{month}/{year}', [LaporanbulananController::class, 'getLaporanSaya']);
Route::get('tambah-laporan-bulanan', [LaporanbulananController::class, 'tambahLaporan']);
Route::post('simpan-laporan-bulanan', [LaporanbulananController::class, 'saveLaporan']);
Route::get('edit-laporan-bulanan/{id}', [LaporanbulananController::class, 'editLaporan']);
Route::post('update-laporan-bulanan', [LaporanbulananController::class, 'updateLaporan']);

Route::get('laporan-bulanan-korkab', [LaporanbulananController::class, 'laporanKorkab']);
Route::get('laporan-bulanan-korkab/{page}/{limit}/{month}/{year}', [LaporanbulananController::class, 'getlaporanKorkab']);
Route::get('laporan-bulanan-faskab', [LaporanbulananController::class, 'laporanFaskab']);
Route::get('laporan-bulanan-faskab/{page}/{limit}/{month}/{year}', [LaporanbulananController::class, 'getlaporanFaskab']);
Route::get('laporan-bulanan-fasdis', [LaporanbulananController::class, 'laporanFasdis']);
Route::get('laporan-bulanan-fasdis/{page}/{limit}/{month}/{year}', [LaporanbulananController::class, 'getlaporanFasdis']);
Route::get('laporan-bulanan-kader', [LaporanbulananController::class, 'laporanKader']);
Route::get('laporan-bulanan-kader/{page}/{limit}/{month}/{year}', [LaporanbulananController::class, 'getlaporanKader']);
Route::post('delete-laporan-bulanan', [LaporanbulananController::class, 'deleteLaporanBulanan']);

Route::get('laporan-aktivitas-harian', [LaporanController::class, 'index']);
Route::get('laporan-absensi', [LaporanController::class, 'laporanAbsensi']);
// Route::get('get-laporan-fasilitator/{page}/{limit}/{search}/{date}', [LaporanController::class, 'getLaporanFasilitator']);
Route::get('get-laporan-fasilitator/{page}/{limit}/{search}/{kdprov}/{kdkab}/{kdkec}/{kddesa}', [LaporanController::class, 'getLaporanFasilitator']);
Route::get('get-preview-absensi/{id}', [LaporanController::class, 'getPreviewAbsensi']);
Route::get('get-preview-aktivitas/{id}', [LaporanController::class, 'getPreviewAktivitas']);
Route::get('laporan-aktivitas-harian/{id}', [LaporanController::class, 'downloadLaporanaktharian']);
Route::get('laporan-absensi/{id}', [LaporanController::class, 'downloadLaporanabsensi']);

Route::get('laporan-rekap-bulanan', [LaporanController::class, 'laporanRekapBulanan']);
Route::get('laporan-rekap-absensi', [LaporanController::class, 'laporanRekapAbsensi']);

Route::get('get-laporan-rekap-bulanan/{search}/{kdprov}/{kdkab}/{kdkec}/{kddesa}', [LaporanController::class, 'getLaporanRekapBulanan']);

Route::get('export-rekap-bulanan', [LaporanController::class, 'exportRekapBulanan']);

Route::get('laporan-cronjob', [LaporanController::class, 'laporanCronjob']);
Route::get('get-laporan-cronjob/{page}/{limit}/{date}', [LaporanController::class, 'getLaporanCronjob']);

Route::get('sync-user', [KonfigurasiController::class, 'syncUser']);
Route::get('backup-db', [KonfigurasiController::class, 'backupDb']);

Route::get('logout-web', [RegisterdrpController::class, 'logout']);

// send-expire-notification
Route::get('send-expire-notification', [ExpireNotificationController::class, 'index'])->name('send-expire-notification')->middleware('xss');
Route::get('notification-read/{id}/{employee_id}', [ExpireNotificationController::class, 'notificationRead'])->name('notification-read')->middleware('xss');
Route::get('get-all-employee-list-api', [ExpireNotificationController::class, 'getAllEmployeeListApi']);

Route::get('/storage-link', function () {
    $exitCode = Artisan::call('storage:link');
    return 'storage-linked Successfully';
})->middleware('xss');

Route::get('update-features', function () {
    Artisan::call('migrate', [
        '--force' => true,
    ]);
    return 'Database Updated';
});



Route::middleware($middleware)->group(
    function () {
        Route::get('/storage-link', function () {
            $exitCode = Artisan::call('storage:link');
            return 'storage-linked Successfully';
        })->middleware('xss');

        Route::get('update-features', function () {
            Artisan::call('migrate', [
                '--force' => true,
            ]);
            return 'Database Updated';
        });


        Route::get('sign-in', [LoginController::class, 'adminLogin'])->name('adminLogin')->middleware('xss');
        Route::group(['middleware' => ['xss', 'MaintenanceMode', 'redirect']], function () {
            
            Route::get('/', [NavigatorController::class, 'index'])->name('home');
            Route::get('/home', [NavigatorController::class, 'index']);
        });
        Route::group(['prefix' => 'video-conference'], function () {
            Route::get('my-meeting', [\Modules\VideoConference\Http\Controllers\ConferenceController::class, 'myMeeting']);
        });
        Auth::routes();
        //admin routes here
        include_route_files(__DIR__ . '/admin/');

        //frontend routes here
        include_route_files(__DIR__ . '/frontend/');

        // Route::domain('{username}.24hourworx.com')->group(function () {
        //     Route::get('user/{id}', function ($username, $id) {
        //         dd($username, $id);
        //     });
        // });

        // Route::domain('sookh' . 'hrm.test')->group(function () {
        //     Route::get('user/{id}', function ($username, $id) {
        //         dd($username, $id);
        //     });
        // });

        //====================Validation Message Generate===============================
        Route::get('validation-message-generate', function () {
            return view('validation-message-generate');
        })->name('test')->middleware('xss');
        Route::POST('validation-message-generate', [ValidationMessageController::class, 'messageGenerate'])->name('message_generate')->middleware('xss');

        Route::get('sync-flugs/{language_name}', [DevController::class, 'syncFlug']);
    }
);

});
