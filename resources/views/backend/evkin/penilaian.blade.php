<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="csrf-token" content="G6kvFeUJcHaWmlgO9EsfgqtKTd2jyCoWlPjILasj" />
        <title>DRP - Fasilitator Evkin</title>
        <meta name="keywords" content="" />
        <meta name="description" content=" " />
        <link rel="shortcut icon" href="https://www.sistemweb.my.id/assets/logotekad.ico" />
        <meta name="base-url" id="base-url" content="https://www.sistemweb.my.id" />

        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://www.sistemweb.my.id/vendors/fontawesome/css/all.min.css" />
        <!-- Line Awesome -->
        <link rel="stylesheet" href="https://www.sistemweb.my.id/vendors/lineawesome/css/line-awesome.min.css" />
        <!--  Bootstrap 5 -->
        <link rel="stylesheet" href="https://www.sistemweb.my.id/vendors/bootstrap/css/bootstrap.min.css" />
        <!-- Metis Menu -->
        <link rel="stylesheet" href="https://www.sistemweb.my.id/vendors/metis-menu/css/metis-menu.min.css" />
        <!-- Apex Chart -->
        <link rel="stylesheet" href="https://www.sistemweb.my.id/vendors/apexchart/css/apexcharts.min.css" />
        <!-- date ranger -->
        <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css" />
        <!-- Input Tags -->
        <link rel="stylesheet" href="https://www.sistemweb.my.id/vendors/inputtags/tagsinput.css" />
        <!-- Line Icons -->
        <link rel="stylesheet" href="https://www.sistemweb.my.id/vendors/lineicons/lineicons.css" />
        <!-- RTL -->
        <link rel="stylesheet" href="https://www.sistemweb.my.id/vendors/rtlcss/css/semantic.rtl.min.css" />
        <!-- Swwet alert -->
        <link rel="stylesheet" href="https://www.sistemweb.my.id/vendors/sweet-alert/css/sweet-alert.min.css" />
        <!-- select2 -->
        <link rel="stylesheet" href="https://www.sistemweb.my.id/vendors/select2/css/select2.min.css" />
        <!-- toastr -->
        <link rel="stylesheet" href="https://www.sistemweb.my.id/css/toastr.css" />

        <link rel="stylesheet" href="https://www.sistemweb.my.id/css/daterangepicker.css" />
        <link rel="stylesheet" href="https://www.sistemweb.my.id/css/select2.css" />
        <link rel="stylesheet" href="https://www.sistemweb.my.id/css/style.css" />
        <link rel="stylesheet" href="https://www.sistemweb.my.id/backend/css/c-ui.css" />
        <style>
            .visit_table td {
                max-width: 200px !important;
                white-space: normal !important;
            }
        </style>
    </head>
    <body class="default-theme" style="background: #fff;">
        <input type="text" hidden value="https://www.sistemweb.my.id" id="url" />
        <input type="text" hidden value="DRP" id="site_name" />
        <input type="text" hidden value="H" id="time_format" />
        <input type="text" hidden value="2023/11/19" id="defaultDate" />
        <input type="hidden" id="get_custom_user_url" value="https://www.sistemweb.my.id/dashboard/user/get-users" />
        <input hidden value="Select Employee" id="select_custom_members" />
        <input hidden value="1" id="fire_base_authenticate" />
        <input hidden value="Are you sure?" id="are_you_sure" />
        <input hidden value="You want to delete this record?" id="you_want_delete" />
        <input hidden value="Something went wrong" id="something_wrong" />
        <input hidden value="Yes" id="yes" />
        <input hidden value="Cancel" id="cancel" />
        <input hidden value="$" id="currency_symbol" />
        <input hidden value="Nothing to show here" id="nothing_show_here" />
        <input hidden value="Please add a new entity or manage the data table to see the content here" id="please_add_new" />
        <input hidden value="Thank you" id="thank_you" />

        <div id="layout-wrapper">
            <header class="header">
                <div class="header-search"></div>

                <button class="close-toggle sidebar-toggle">
                    <img src="https://www.sistemweb.my.id/assets/images/icons/hammenu-2.svg" alt="" />
                </button>
                <div class="header-controls">
                    <div class="header-control-item">
                        <div class="item-content dropdown">
                            <a class="nav-link __clock_nav mt-0" href="javascript:void(0)">
                                <span class="clock company_name_clock fs-16" id="clock" onload="currentTime()">00:00:00</span>
                            </a>
                        </div>
                    </div>

                    <div class="header-control-item">
                        <div class="item-content d-flex align-items-center">
                            <div class="mt-0 d-flex align-items-between pe-auto cursor-pointer pointer" role="navigation" id="topbar_messages" aria-expanded="false">
                                <a
                                    id="demo"
                                    onclick="viewModal(`https://www.sistemweb.my.id/dashboard/ajax-checkin-modal`)"
                                    data-bs-toggle="tooltip"
                                    data-bs-placement="right"
                                    data-bs-title="Check In"
                                    class="ml-2 mr-2 checkin d-flex align-items-center sm-btn-with-radius checkin-color me-3 chckinout-btn"
                                >
                                    <span class="checkin-btn"><i class="las la-sign-in-alt"></i></span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="header-control-item">
                        <div class="item-content">
                            <div class="profile-navigate mt-0 cursor-pointer" id="profile_expand" data-bs-toggle="dropdown" role="navigation">
                                <div class="profile-photo">
                                    <img src="https://www.sistemweb.my.id/allUploads/uploads/avatar/202311120204scaled_IMG_20230702_133848.jpg" alt="profile" />
                                </div>
                                <div class="profile-info md-none">
                                    <h6>Admin</h6>
                                    <p>Admin, DRP Kemendesa</p>
                                </div>
                            </div>
                            <div class="dropdown-menu dropdown-menu-end profile-expand-dropdown top-navbar-dropdown-menu ot-card pa-0" aria-labelledby="profile_expand">
                                <div class="profile-expand-container">
                                    <div class="profile-expand-list d-flex flex-column">
                                        <a class="profile-expand-item profile-border" href="https://www.sistemweb.my.id/dashboard/profile/personal">
                                            <span>My Profile</span>
                                        </a>
                                        <a class="profile-expand-item" href="https://www.sistemweb.my.id/hrm/notification" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Notification">
                                            <span><i class="las la-bell"></i>Notification</span>
                                        </a>
                                        <a class="profile-expand-item profile-border" href="https://www.sistemweb.my.id/dashboard/profile/settings">
                                            <span><i class="las la-cog"></i> Settings</span>
                                        </a>
                                        <a class="profile-expand-item" href="https://www.sistemweb.my.id/dashboard/logout">
                                            <span>Logout</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <aside class="sidebar" id="sidebar">
                <div class="sidebar-header">
                    <div class="sidebar-logo">
                        <a href="https://www.sistemweb.my.id/dashboard" class="img-tag sidebar_logo">
                            <img class="full-logo dark_logo" src="https://www.sistemweb.my.id/images/logotekad.png" alt="" />
                            <img class="half-logo" src="https://www.sistemweb.my.id/static/blank_small.png" alt="Icon" width="15" />
                        </a>
                    </div>

                    <button class="half-expand-toggle sidebar-toggle">
                        <i class="fa fa-navicon"></i>
                    </button>
                    <button class="close-toggle sidebar-toggle">
                        <i class="fa fa-navicon"></i>
                    </button>
                </div>
                <br />
                <br />
                <br />
                <div class="sidebar-menu">
                    <div class="sidebar-menu-section">
                        <!-- parent menu list start  -->
                        <ul class="sidebar-dropdown-menu parent-menu-list">
                            <li class="sidebar-menu-item">
                                <a href="https://www.sistemweb.my.id/dashboard" class="parent-item-content">
                                    <i class="fa fa-home" style="font-size: 20px;"></i>
                                    <span class="on-half-expanded">Dashboard</span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item">
                                <a href="javascript:void(0)" class="parent-item-content has-arrow in-active">
                                    <i class="fa fa-list" style="font-size: 20px;"></i>
                                    <span class="on-half-expanded">
                                        Data Master
                                    </span>
                                </a>
                                <ul class="child-menu-list">
                                    <li class="nav-item in-active">
                                        <a href="#" class=" ">
                                            <span>Provinsi</span>
                                        </a>
                                    </li>
                                    <li class="nav-item in-active">
                                        <a href="#" class=" ">
                                            <span>Kabupaten</span>
                                        </a>
                                    </li>
                                    <li class="nav-item in-active">
                                        <a href="#" class=" ">
                                            <span>Kecamatan</span>
                                        </a>
                                    </li>
                                    <li class="nav-item in-active">
                                        <a href="#" class=" ">
                                            <span>Desa</span>
                                        </a>
                                    </li>
                                    <li class="nav-item in-active">
                                        <a href="#" class=" ">
                                            <span>Role User</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="sidebar-menu-item">
                                <a href="https://www.sistemweb.my.id/dashboard/user" class="parent-item-content in-active">
                                    <i class="fa fa-user-circle" style="font-size: 20px;"></i>
                                    <span class="on-half-expanded">
                                        Fasilitator
                                    </span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item https://www.sistemweb.my.id/hrm/leavehttps://www.sistemweb.my.id/hrm/leave/assign">
                                <a href="javascript:void(0)" class="parent-item-content has-arrow in-active">
                                    <i class="fa fa-times-circle" style="font-size: 20px;"></i>
                                    <span class="on-half-expanded">
                                        Tidak Masuk Kerja
                                    </span>
                                </a>
                                <ul class="child-menu-list">
                                    <li class="nav-item in-active">
                                        <a href="https://www.sistemweb.my.id/hrm/leave" class=" ">
                                            <span>Jenis</span>
                                        </a>
                                    </li>
                                    <li class="nav-item in-active">
                                        <a href="https://www.sistemweb.my.id/hrm/leave/assign" class=" ">
                                            <span> Penetapan</span>
                                        </a>
                                    </li>
                                    <li class="nav-item in-active">
                                        <a href="https://www.sistemweb.my.id/hrm/leave/request" class=" ">
                                            <span>Request Data</span>
                                        </a>
                                    </li>

                                    <li class="nav-item in-active">
                                        <a href="https://www.sistemweb.my.id/dashboard/user/leave-balance" class=" ">
                                            <span>Rekap</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="sidebar-menu-item">
                                <a href="https://www.sistemweb.my.id/hrm/attendance" class="parent-item-content">
                                    <i class="fa fa-check-square" style="font-size: 20px;"></i>
                                    <span class="on-half-expanded">
                                        Absensi
                                    </span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item">
                                <a href="https://www.sistemweb.my.id/hrm/appointment" class="parent-item-content">
                                    <i class="fa fa-book" style="font-size: 20px;"></i>
                                    <span class="on-half-expanded">
                                        Aktivitas Harian
                                    </span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item">
                                <a href="https://www.sistemweb.my.id/hrm/visit" class="parent-item-content">
                                    <i class="fa fa-calendar" style="font-size: 20px;"></i>
                                    <span class="on-half-expanded">
                                        Laporan Bulanan
                                    </span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item">
                                <a href="https://www.sistemweb.my.id/hrm/evkin" class="parent-item-content active">
                                    <i class="fa fa-tag" style="font-size: 20px;"></i>
                                    <span class="on-half-expanded">
                                        Evkin
                                    </span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item">
                                <a href="javascript:void(0)" class="parent-item-content has-arrow in-active">
                                    <i class="fa fa-gear" style="font-size: 20px;"></i>
                                    <span class="on-half-expanded">
                                        Konfigurasi
                                    </span>
                                </a>
                                <ul class="child-menu-list">
                                    <li class="nav-item in-active">
                                        <a href="https://www.sistemweb.my.id/hrm/weekend/setup" class=" ">
                                            <span>Weekend Setup</span>
                                        </a>
                                    </li>
                                    <li class="nav-item in-active">
                                        <a href="https://www.sistemweb.my.id/hrm/holiday/setup" class="in-active">
                                            <span>Holiday Setup</span>
                                        </a>
                                    </li>
                                    <li class="nav-item in-active">
                                        <a href="https://www.sistemweb.my.id/hrm/shift" class=" ">
                                            <span>Shift Setup</span>
                                        </a>
                                    </li>

                                    <li class="nav-item in-active">
                                        <a href="https://www.sistemweb.my.id/hrm/location" class="">
                                            <span>Lokasi</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="sidebar-menu-item">
                                <a href="javascript:void(0)" class="parent-item-content has-arrow in-active">
                                    <i class="fa fa-print" style="font-size: 20px;"></i>
                                    <span class="on-half-expanded">
                                        Laporan
                                    </span>
                                </a>
                                <ul class="child-menu-list">
                                    <li class="nav-item in-active">
                                        <a href="#" class=" ">
                                            <span>Lap Absensi</span>
                                        </a>
                                    </li>
                                    <li class="nav-item in-active">
                                        <a href="#" class=" ">
                                            <span>Lap Evkin</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                        <!-- parent menu list end  -->
                    </div>
                </div>
            </aside>

            <main class="main-content ph-32 pt-100 pb-20" id="__index_ltn">
                <div class="page-content">
                    <div class="breadcrumb-warning d-flex justify-content-between ot-card">
                        <div><h3>Penilaian Evkin</h3></div>
                        <nav aria-label="breadcrumb ">
                            <ol class="breadcrumb ot-breadcrumb ot-breadcrumb-basic">
                                <li class="breadcrumb-item"><a href="https://www.sistemweb.my.id/dashboard">Dashboard</a></li>
                                <li class="breadcrumb-item active">Penilaian Evkin</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="table-content table-basic">
                        <div class="card">
                            <div class="card-body">
                                
                                <!-- toolbar table end -->
                                <!--  table start -->
                                <h6>Nama : Bastiar Pramana</h6>
                                <h6>Tingkat : Kader Desa</h6>
                                <h6>Provinsi : Papua</h6>
                                <h6>Kabupaten : Merauke</h6>
                                <h6>Kecamatan/Distrik : Merauke</h6>
                                <h6>Desa/Kelurahan : Bambu Pemali</h6>
                                <br><hr><br>
                                <div class="table-responsive">
                                    <table class="table table-bordered visit_table" id="table">
                                        
                                        <tr>
                                            <td class="sorting_desc">No</td>
                                            <td class="sorting_desc">Aspek</td>
                                            <td class="sorting_desc">Variabel</td>
                                            <td class="sorting_desc">Nilai Skor</td>
                                        </tr>
                                        <tr>
                                            <td class="sorting_desc">I</td>
                                            <td class="sorting_desc" colspan="3">ASPEK KINERJA</td>
                                        </tr>
                                        <tr>
                                            <td class="sorting_desc">1.1</td>
                                            <td class="sorting_desc" colspan="3">ADMINISTRASI</td>
                                        </tr>
                                        <tr>
                                            <td class="sorting_desc">1.1.1</td>
                                            <td class="sorting_desc"></td>
                                            <td class="sorting_desc">Tingkat kehadiran <i class="fa fa-file"></i></td>
                                            <td class="sorting_desc">5</td>
                                        </tr>
                                        <tr>
                                            <td class="sorting_desc">1.1.2</td>
                                            <td class="sorting_desc"></td>
                                            <td class="sorting_desc">Menyusun laporan harian <i class="fa fa-file"></i></td>
                                            <td class="sorting_desc">
                                                <select class="form-control">
                                                    <option value="">-Pilih Nilai-</option>
                                                    <option value="">5 - Sesuai dengan Tupoksi (100%)</option>
                                                    <option value="">4 - Tidak sesuai dengan Tupoksi (2 kegiatan)</option>
                                                    <option value="">3 - Tidak sesuai dengan Tupoksi (4 kegiatan)</option>
                                                    <option value="">2 - Tidak sesuai dengan Tupoksi (6 kegiatan)</option>
                                                    <option value="">1 - Tidak sesuai dengan Tupoksi (8 kegiatan)</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="sorting_desc">1.1.3</td>
                                            <td class="sorting_desc"></td>
                                            <td class="sorting_desc">Menyusun laporan bulanan <i class="fa fa-file"></i></td>
                                            <td class="sorting_desc">
                                                <select class="form-control">
                                                    <option value="">-Pilih Nilai-</option>
                                                    <option value="">5 - Laporan Sesuai dan Lengkap</option>
                                                    <option value="">4 - Isi Laporan Kurang Sesuai dan  Lengkap</option>
                                                    <option value="">3 - Isi Laporan Kurang Sesuai dan  Kurang Lengkap</option>
                                                    <option value="">2 - Isi Laporan Kurang Sesuai dan  Tidak Lengkap</option>
                                                    <option value="">1 - Isi Laporan Tidak Sesuai dan  Tidak Lengkap</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="sorting_desc">1.2</td>
                                            <td class="sorting_desc" colspan="3">PENDAMPINGAN, SUPERVISI, MONITORING DAN EVALUASI</td>
                                        </tr>
                                        <tr>
                                            <td class="sorting_desc">1.2.1</td>
                                            <td class="sorting_desc"></td>
                                            <td class="sorting_desc">Pendampingan  Terhadap Program TEKAD</td>
                                            <td class="sorting_desc">
                                                <select class="form-control">
                                                    <option value="">-Pilih Nilai-</option>
                                                    <option value="">5 - Pendampingan dilakukan dan sesuai dengan Kebutuhan kegiatan Komponen/ Sub Komponen</option>
                                                    <option value="">4 - Pendampingan  dilakukan dan  belum maksimal sesuai dengan Kebutuhan kegiatan Komponen/ Sub Komponen</option>
                                                    <option value="">3 - Pendampingan dilakukan dan cukup sesuai dengan Kebutuhan kegiatan Komponen/ Sub Komponen</option>
                                                    <option value="">2 - Pendampingan dilakukan dan kurang sesuai dengan Kebutuhan kegiatan Komponen/ Sub Komponen</option>
                                                    <option value="">1 - Pendampingan Tidak dilakukan sesuai dengan Kebutuhan kegiatan Komponen/ Sub Komponen</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="sorting_desc">1.2.2</td>
                                            <td class="sorting_desc"></td>
                                            <td class="sorting_desc">Supervisi dan Monev terhadap Kelompok dan Sasaran Program</td>
                                            <td class="sorting_desc">
                                                <select class="form-control">
                                                    <option value="">-Pilih Nilai-</option>
                                                    <option value="">5 - Dilakukan Supervisi dan Monev sesuai dengan Target Group kelompok dan sasaran Program</option>
                                                    <option value="">4 - Dilakukan Supervisi dan Monev terhadap Target Group kelompok dan kurang sesuai dengan sasaran Program</option>
                                                    <option value="">3 - Dilakukan Supervisi dan Monev namun kurang sesuai Target Group kelompok dan kurang sesuai dengan sasaran Program</option>
                                                    <option value="">2 - Dilakukan Supervisi dan Monev namun Tidak sesuai Target Group kelompok dan kurang sesuai dengan sasaran Program</option>
                                                    <option value="">1 - Tidak melakukan Supervisi dan Monev terhadap Target Group kelompok dan sasaran Program</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="sorting_desc">1.3</td>
                                            <td class="sorting_desc" colspan="3">PENCAPAIAN OUTPUT</td>
                                        </tr>
                                        <tr>
                                            <td class="sorting_desc">1.3.1</td>
                                            <td class="sorting_desc"></td>
                                            <td class="sorting_desc">Rencana Kerja</td>
                                            <td class="sorting_desc">
                                                <select class="form-control">
                                                    <option value="">-Pilih Nilai-</option>
                                                    <option value="">5 - Memiliki Rencana Kerja sesuai dengan Tupoksi </option>
                                                    <option value="">4 - Memiliki Rencana Kerja agak sesuai dengan Tupoksi </option>
                                                    <option value="">3 - Memiliki Rencana Kerja cukup sesuai dengan Tupoksi </option>
                                                    <option value="">2 - Memiliki Rencana Kerja Tidak sesuai dengan Tupoksi </option>
                                                    <option value="">1 - Tidak memiliki Rencana Kerja sesuai dengan Tupoksi </option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="sorting_desc">1.3.2</td>
                                            <td class="sorting_desc"></td>
                                            <td class="sorting_desc">Output Sesuai Tupoksi</td>
                                            <td class="sorting_desc">
                                                <select class="form-control">
                                                    <option value="">-Pilih Nilai-</option>
                                                    <option value="">5 - Memiliki Uraian Output kegiatan sesuai dengan Tupoksi </option>
                                                    <option value="">4 - Memiliki Uraian Output kegiatan Agak Sesuai  dengan Tupoksi </option>
                                                    <option value="">3 - Memiliki Uraian Output kegiatan Cukup sesuai dengan Tupoksi </option>
                                                    <option value="">2 - Memiliki Uraian Output kegiatan Tidak sesuai dengan Tupoksi </option>
                                                    <option value="">1 - Tidak ada uraian Output kegiatan sesuai dengan Tupoksi </option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="sorting_desc">II</td>
                                            <td class="sorting_desc" colspan="3">PERILAKU KERJA</td>
                                        </tr>
                                        <tr>
                                            <td class="sorting_desc">2.1</td>
                                            <td class="sorting_desc" colspan="3">Pengendalian Pendamping</td>
                                        </tr>
                                        <tr>
                                            <td class="sorting_desc">2.1.1</td>
                                            <td class="sorting_desc"></td>
                                            <td class="sorting_desc">Pendampingan untuk perberdayaan masyarakat</td>
                                            <td class="sorting_desc">
                                                <select class="form-control">
                                                    <option value="">-Pilih Nilai-</option>
                                                    <option value="">5 - Melakukan kegiatan pendampingan sesuai dengan tupoksi , kebutuhan dan jenjang</option>
                                                    <option value="">4 - Melakukan kegiatan pendampingan sesuai dengan tupoksi, tetapi kurang sesuai kebutuhan dan jenjang (hirarki) </option>
                                                    <option value="">3 - Melakukan kegiatan pendampingan kurang sesuai mulai dari tupoksi, kebtuhan dan jenjang </option>
                                                    <option value="">2 - Melakukan kegiatan pendampingan tidak sesuai tupoksi , kebutuhan maupun jenjang</option>
                                                    <option value="">1 - Tidak melakukan kegiatan pendampingan</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="sorting_desc">2.1.2</td>
                                            <td class="sorting_desc"></td>
                                            <td class="sorting_desc">Penanganan dan penyelesaian permasalahan tim kerja (berjenjang)</td>
                                            <td class="sorting_desc">
                                                <select class="form-control">
                                                    <option value="">-Pilih Nilai-</option>
                                                    <option value="">5 - Melaksanakan penanganan dan penyelesaian permasalahan tim kerja secara berjenjang</option>
                                                    <option value="">4 - Melaksanakan penangan tetapi belum tuntas dalam penyelesaian permasalahan tim kerja secara berjenjang </option>
                                                    <option value="">3 - Melaksanan penanganan tetapi tidak menyelesaikan permasalahan tim kerja secara berjenjang</option>
                                                    <option value="">2 - Kurang responsif terhadap penangan masalah dan tidak menyelesaikan masalah tim kerja secara berjenjang</option>
                                                    <option value="">1 - Tidak melaksanakan penanganan dan penyelesaian permasalahan tim kerja secara berjenjang tim kerja secara berjenjang</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="sorting_desc">2.2</td>
                                            <td class="sorting_desc" colspan="2">Loyalitas dan Ketaatan</td>
                                            <td class="sorting_desc">
                                                <select class="form-control">
                                                    <option value="">-Pilih Nilai-</option>
                                                    <option value="">5 - Loyal dan taat terhadap peraturan, hirarki dan tupoksi</option>
                                                    <option value="">4 - Belum sepenuhnya loyal dan taat terhadap peraturan, hirarki dan tupoksi </option>
                                                    <option value="">3 - Cukup  Loyal dan taat terhadap peraturan, hirarki dan tupoksi</option>
                                                    <option value="">2 - Kurang  Loyal dan taat terhadap peraturan, hirarki dan tupoksi</option>
                                                    <option value="">1 - Tidak Loyal dan taat terhadap peraturan, hirarki dan tupoksi</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="sorting_desc">2.3</td>
                                            <td class="sorting_desc" colspan="2">Koordinasi dan Kerjasama</td>
                                            <td class="sorting_desc">
                                                <select class="form-control">
                                                    <option value="">-Pilih Nilai-</option>
                                                    <option value="">5 - Melaksanan koordinasi dan kerjasama sesuai hirarki dan lini kerja</option>
                                                    <option value="">4 - Belum optimal dalam melaksanan koordinasi dan kerjasama sesuai hirarki dan lini kerja</option>
                                                    <option value="">3 - Melaksanan koordinasi tetapi kurang  kerjasama sesuai hirarki dan lini kerja</option>
                                                    <option value="">2 - Kurang dalam melaksanan koordinasi dan kerjasama sesuai hirarki dan lini kerja</option>
                                                    <option value="">1 - Tidak melaksanan koordinasi dan kerjasama sesuai hirarki dan lini kerja</option>
                                                </select>
                                            </td>
                                        </tr>
                                    </table>
                                    <input type="text" hidden id="visit_table_url" value="https://www.sistemweb.my.id/hrm/visit" />
                                    <br><br>
                                    <center>
                                        <button class="btn btn-success">Simpan</button>
                                    </center>
                                    <br><br>
                                </div>
                                <!--  table end -->
                            </div>
                        </div>
                    </div>
                </div>

                <!-- /.content-wrapper -->
                <footer class="footer main-footer mt-3">
                    <p class="px-4">&copy;2023<a href="#"> DRP KEMENDESA </a> All rights reserved</p>
                </footer>
                <!-- Control Sidebar -->
                <aside class="control-sidebar control-sidebar-dark">
                    <!-- Control sidebar content goes here -->
                </aside>
            </main>
        </div>

        <script>
            var isRTL = 0;
        </script>
        <!-- jQuery -->
        <script src="https://www.sistemweb.my.id/vendors/jquery/jquery-3.6.0.min.js"></script>
        <!--  Bootstrap 5 -->
        <script src="https://www.sistemweb.my.id/vendors/bootstrap/js/popper.min.js"></script>
        <script src="https://www.sistemweb.my.id/vendors/bootstrap/js/bootstrap.min.js"></script>
        <!-- RTL -->
        <script src="https://www.sistemweb.my.id/vendors/rtlcss/js/semantic.min.js"></script>
        <!-- Metis Menu -->
        <script src="https://www.sistemweb.my.id/vendors/metis-menu/js/metis-menu.min.js"></script>
        <!-- date ranger -->
        <script src="https://www.sistemweb.my.id/vendors/daterangepicker/js/moment.min.js"></script>
        <script src="https://www.sistemweb.my.id/vendors/daterangepicker/js/daterangepicker.min.js"></script>
        <!-- Swwet alert -->
        <script src="https://www.sistemweb.my.id/vendors/sweet-alert/js/sweetalert2@11.min.js"></script>
        <script src="https://www.sistemweb.my.id/vendors/select2/js/select2.min.js"></script>

        <script src="https://www.sistemweb.my.id/backend/js/jquery-ui.js"></script>

        <script src="https://www.sistemweb.my.id/js/toastr.js"></script>
        <script type="text/javascript"></script>

        <script src="https://www.sistemweb.my.id/js/tooltip.js"></script>
        <script src="https://www.sistemweb.my.id/js/newmain.js"></script>
        <script src="https://www.sistemweb.my.id/js/theme.js" async></script>
        <!-- Input Tags -->
        <script src="https://www.sistemweb.my.id/vendors/inputtags/tagsinput.js"></script>
        <script src="https://www.sistemweb.my.id/backend/js/main.js"></script>
        <script src="https://www.sistemweb.my.id/js/select2-init.js"></script>

        <script src="https://www.sistemweb.my.id/js/axios.js"></script>

        <script>
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
            });
        </script>
        <script src="https://www.sistemweb.my.id/backend/js/fs_d_ecma/configuration/configuration.js"></script>

        <script></script>

        <script src="https://www.sistemweb.my.id/backend/js/table/data-table.js"></script>

        <script type="module" src="https://www.sistemweb.my.id/backend/js/fs_d_ecma/controller/tableController.js"></script>
        <script src="https://www.sistemweb.my.id/backend/js/table/export/excel.js"></script>
        <script src="https://www.sistemweb.my.id/backend/js/table/export/pdf.js"></script>
        <script src="https://www.sistemweb.my.id/backend/js/table/export/jspdf.js"></script>
        <script src="https://www.sistemweb.my.id/backend/js/table/export/exportMethod.js"></script>
        <script src="https://www.sistemweb.my.id/backend/js/table/__export.js"></script>
        <script src="https://www.sistemweb.my.id/backend/js/backend_common.js"></script>
        <script src="https://www.sistemweb.my.id/backend/js/__app.script.js"></script>
    </body>
</html>
