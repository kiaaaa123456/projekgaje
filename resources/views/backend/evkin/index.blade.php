<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="G6kvFeUJcHaWmlgO9EsfgqtKTd2jyCoWlPjILasj">
    <title> DRP - Evkin</title>
    <meta name="keywords" content="">
    <meta name="description" content=" ">
    <link rel="shortcut icon" href="https://www.sistemweb.my.id/assets/logotekad.ico">
        <meta name="base-url" id="base-url" content="https://www.sistemweb.my.id">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://www.sistemweb.my.id/vendors/fontawesome/css/all.min.css">
    <!-- Line Awesome -->
    <link rel="stylesheet" href="https://www.sistemweb.my.id/vendors/lineawesome/css/line-awesome.min.css">
    <!--  Bootstrap 5 -->
    <link rel="stylesheet" href="https://www.sistemweb.my.id/vendors/bootstrap/css/bootstrap.min.css">
    <!-- Metis Menu -->
    <link rel="stylesheet" href="https://www.sistemweb.my.id/vendors/metis-menu/css/metis-menu.min.css">
    <!-- Apex Chart -->
    <link rel="stylesheet" href="https://www.sistemweb.my.id/vendors/apexchart/css/apexcharts.min.css">
    <!-- date ranger -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <!-- Input Tags -->
    <link rel="stylesheet" href="https://www.sistemweb.my.id/vendors/inputtags/tagsinput.css">
    <!-- Line Icons -->
    <link rel="stylesheet" href="https://www.sistemweb.my.id/vendors/lineicons/lineicons.css">
    <!-- RTL -->
    <link rel="stylesheet" href="https://www.sistemweb.my.id/vendors/rtlcss/css/semantic.rtl.min.css">
    <!-- Swwet alert -->
    <link rel="stylesheet" href="https://www.sistemweb.my.id/vendors/sweet-alert/css/sweet-alert.min.css">
    <!-- select2 -->
    <link rel="stylesheet" href="https://www.sistemweb.my.id/vendors/select2/css/select2.min.css">
    <!-- toastr -->
    <link rel="stylesheet" href="https://www.sistemweb.my.id/css/toastr.css">

    <link rel="stylesheet" href="https://www.sistemweb.my.id/css/daterangepicker.css">
    <link rel="stylesheet" href="https://www.sistemweb.my.id/css/select2.css">
    <link rel="stylesheet" href="https://www.sistemweb.my.id/css/style.css">
    <link rel="stylesheet" href="https://www.sistemweb.my.id/backend/css/c-ui.css">    
    <style>
    .visit_table td{
        max-width: 200px !important;
        white-space: normal !important;
    }

</style>
</head>
<body class="default-theme" style="background: #fff;">
    
    <input type="text" hidden value="https://www.sistemweb.my.id" id="url">
    <input type="text" hidden value="DRP" id="site_name">
    <input type="text" hidden value="H" id="time_format">
    <input type="text" hidden value="2023/11/19" id="defaultDate">
    <input type="hidden" id="get_custom_user_url" value="https://www.sistemweb.my.id/dashboard/user/get-users">
    <input hidden value="Select Employee" id="select_custom_members">
    <input hidden value="1" id="fire_base_authenticate">
    <input hidden value="Are you sure?" id="are_you_sure">
    <input hidden value="You want to delete this record?" id="you_want_delete">
    <input hidden value="Something went wrong" id="something_wrong">
    <input hidden value="Yes" id="yes">
    <input hidden value="Cancel" id="cancel">
    <input hidden value="$" id="currency_symbol">
    <input hidden value="Nothing to show here" id="nothing_show_here">
    <input hidden
        value="Please add a new entity or manage the data table to see the content here"
        id="please_add_new">
    <input hidden value="Thank you" id="thank_you">

    <div id="layout-wrapper">
        
        <header class="header">

    <div class="header-search"> 
    </div>

    <button class="close-toggle sidebar-toggle">
        <img src="https://www.sistemweb.my.id/assets/images/icons/hammenu-2.svg" alt="">
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
                <div class="mt-0 d-flex  align-items-between pe-auto cursor-pointer pointer " role="navigation" id="topbar_messages"
                    aria-expanded="false">
                                            <a id="demo" onclick="viewModal(`https://www.sistemweb.my.id/dashboard/ajax-checkin-modal`)"
                            data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Check In"
                            class="ml-2 mr-2 checkin d-flex align-items-center sm-btn-with-radius checkin-color me-3 chckinout-btn">
                            <span class="checkin-btn"><i class="las la-sign-in-alt"></i></span>
                        </a>
                                                                            </div>
            </div>
        </div>
        
        <div class="header-control-item">
            <div class="item-content">
                <div class="profile-navigate mt-0 cursor-pointer " id="profile_expand" data-bs-toggle="dropdown"
                     role="navigation">
                    <div class="profile-photo">
                        <img  src="https://www.sistemweb.my.id/allUploads/uploads/avatar/202311120204scaled_IMG_20230702_133848.jpg" alt="profile">
                    </div>
                    <div class="profile-info md-none">
                        @if(Auth::user()->is_admin==1)
                            <h6>Admin</h6>
                            <p> Admin, DRP Kemendesa</p>
                        @else
                            <h6>Fasilitator</h6>
                            <p> Fasilitator, DRP Kemendesa</p>
                        @endif
                    </div>
                </div>
                <div class="dropdown-menu dropdown-menu-end profile-expand-dropdown top-navbar-dropdown-menu ot-card pa-0"
                    aria-labelledby="profile_expand">
                    <div class="profile-expand-container">
                        <div class="profile-expand-list d-flex flex-column">
                                                            <a class="profile-expand-item profile-border"
                                    href="https://www.sistemweb.my.id/dashboard/profile/personal">
                                    <span>My Profile</span>
                                </a>
                                                        <a class="profile-expand-item" href="https://www.sistemweb.my.id/hrm/notification"
                                data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Notification">
                                <span><i class="las la-bell"></i>Notification</span>
                            </a>
                            <a class="profile-expand-item profile-border"
                                href="https://www.sistemweb.my.id/dashboard/profile/settings">
                                <span><i class="las la-cog"></i> Settings</span>
                            </a>
                            <a class="profile-expand-item " href="https://www.sistemweb.my.id/dashboard/logout">
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
                <img class="full-logo dark_logo" src="https://www.sistemweb.my.id/images/logotekad.png" alt="" >
                <img class="half-logo" src="https://www.sistemweb.my.id/static/blank_small.png" alt="Icon"
                    width="15">
            </a>
        </div>

        <button class="half-expand-toggle sidebar-toggle">
            <i class="fa fa-navicon"></i>
        </button>
        <button class="close-toggle sidebar-toggle">
            <i class="fa fa-navicon"></i>
        </button>
    </div>
    <br><br><br>
    <div class="sidebar-menu">
        <div class="sidebar-menu-section">
            <!-- parent menu list start  -->
            <ul class="sidebar-dropdown-menu parent-menu-list">
                @if(Auth::user()->is_admin==1)
                <li class="sidebar-menu-item">
                    <a href="https://www.sistemweb.my.id/dashboard"
                        class="parent-item-content ">
                        <i class="fa fa-home"style="font-size:20px"></i>
                        <span class="on-half-expanded">Dashboard</span>
                    </a>
                </li>

                <li class="sidebar-menu-item">
                    <a href="javascript:void(0)" class="parent-item-content has-arrow in-active">
                        <i class="fa fa-list"style="font-size:20px"></i>
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


               
                                    <li class="sidebar-menu-item ">
                        <a href="https://www.sistemweb.my.id/dashboard/user"
                            class="parent-item-content in-active">
                            <i class="fa fa-user-circle"style="font-size:20px"></i>
                            <span class="on-half-expanded">
                                Fasilitator
                            </span>
                        </a>
                    </li>
                
                                    <li class="sidebar-menu-item https://www.sistemweb.my.id/hrm/leavehttps://www.sistemweb.my.id/hrm/leave/assign">
                        <a href="javascript:void(0)"
                            class="parent-item-content has-arrow in-active">
                            <i class="fa fa-times-circle"style="font-size:20px"></i>
                            <span class="on-half-expanded">
                                Tidak Masuk Kerja
                            </span>
                        </a>
                        <ul
                            class="child-menu-list ">
                                                            <li
                                    class="nav-item in-active">
                                    <a href="https://www.sistemweb.my.id/hrm/leave"
                                        class=" ">
                                        <span>Jenis</span>
                                    </a>
                                </li>
                                                                                        <li
                                    class="nav-item in-active">
                                    <a href="https://www.sistemweb.my.id/hrm/leave/assign"
                                        class=" ">
                                        <span> Penetapan</span>
                                    </a>
                                </li>
                                                                                        <li
                                    class="nav-item in-active">
                                    <a href="https://www.sistemweb.my.id/hrm/leave/request"
                                        class=" ">
                                        <span>Request Data</span>
                                    </a>
                                </li>
                                                        
                                                            <li class="nav-item in-active">
                                    <a href="https://www.sistemweb.my.id/dashboard/user/leave-balance"
                                        class=" ">
                                        <span>Rekap</span>
                                    </a>
                                </li>
                                                    </ul>
                    </li>
                                
                <li class="sidebar-menu-item ">
                    <a href="https://www.sistemweb.my.id/hrm/attendance"
                        class="parent-item-content ">
                        <i class="fa fa-check-square"style="font-size:20px"></i>
                        <span class="on-half-expanded">
                            Absensi
                        </span>
                    </a>
                </li> 
               
                <li class="sidebar-menu-item ">
                    <a href="https://www.sistemweb.my.id/hrm/appointment"
                        class="parent-item-content ">
                        <i class="fa fa-book"style="font-size:20px"></i>
                        <span class="on-half-expanded">
                            Aktivitas Harian
                        </span>
                    </a>
                </li>  

                <li class="sidebar-menu-item ">
                    <a href="https://www.sistemweb.my.id/hrm/visit"
                        class="parent-item-content  ">
                        <i class="fa fa-calendar"style="font-size:20px"></i>
                        <span class="on-half-expanded">
                            Laporan Bulanan
                        </span>
                    </a>
                </li>  

                <li class="sidebar-menu-item ">
                    <a href="https://www.sistemweb.my.id/hrm/evkin"
                        class="parent-item-content active">
                        <i class="fa fa-tag" style="font-size:20px"></i>
                        <span class="on-half-expanded">
                            Evkin
                        </span>
                    </a>
                </li> 

                                    <li class="sidebar-menu-item">
                        <a href="javascript:void(0)"
                            class="parent-item-content has-arrow in-active">
                            <i class="fa fa-gear" style="font-size:20px"></i>
                            <span class="on-half-expanded">
                                Konfigurasi

                            </span>
                        </a>
                        <ul
                            class="child-menu-list  ">

                            

                                                            <li class="nav-item in-active">
                                    <a href="https://www.sistemweb.my.id/hrm/weekend/setup"
                                        class=" ">
                                        <span>Weekend Setup</span>
                                    </a>
                                </li>
                                                                                        <li
                                    class="nav-item in-active">
                                    <a href="https://www.sistemweb.my.id/hrm/holiday/setup"
                                        class=" in-active">
                                        <span>Holiday Setup</span>
                                    </a>
                                </li>
                                                                                        <li class="nav-item in-active">
                                    <a href="https://www.sistemweb.my.id/hrm/shift"
                                        class=" ">
                                        <span>Shift Setup</span>
                                    </a>
                                </li>
                                                        
                                                            <li
                                    class="nav-item in-active">
                                    <a href="https://www.sistemweb.my.id/hrm/location" class="">
                                        <span>Lokasi</span>
                                    </a>
                                </li>
                                                    </ul>

                        <li class="sidebar-menu-item">
                            <a href="javascript:void(0)" class="parent-item-content has-arrow in-active">
                                <i class="fa fa-print" style="font-size:20px"></i>
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
                    </li>
                @else
                <li class="sidebar-menu-item">
                    <a href="https://www.sistemweb.my.id/dashboard"
                        class="parent-item-content ">
                        <i class="fa fa-home"style="font-size:20px"></i>
                        <span class="on-half-expanded">Dashboard</span>
                    </a>
                </li>                                             
                <li class="sidebar-menu-item ">
                    <a href="https://www.sistemweb.my.id/hrm/attendance"
                        class="parent-item-content  ">
                        <i class="fa fa-check-square"style="font-size:20px"></i>
                        <span class="on-half-expanded">
                            Absensi
                        </span>
                    </a>
                </li> 
               
                <li class="sidebar-menu-item ">
                    <a href="https://www.sistemweb.my.id/hrm/appointment"
                        class="parent-item-content ">
                        <i class="fa fa-book"style="font-size:20px"></i>
                        <span class="on-half-expanded">
                            Aktivitas Harian
                        </span>
                    </a>
                </li>  

                <li class="sidebar-menu-item ">
                    <a href="https://www.sistemweb.my.id/hrm/visit"
                        class="parent-item-content ">
                        <i class="fa fa-calendar"style="font-size:20px"></i>
                        <span class="on-half-expanded">
                            Laporan Bulanan
                        </span>
                    </a>
                </li>  

                <li class="sidebar-menu-item ">
                    <a href="https://www.sistemweb.my.id/hrm/evkin"
                        class="parent-item-content active">
                        <i class="fa fa-tag" style="font-size:20px"></i>
                        <span class="on-half-expanded">
                            Evkin
                        </span>
                    </a>
                </li>

                @endif

            </ul>
            <!-- parent menu list end  -->
        </div>
    </div>
</aside>
        
        <main class="main-content ph-32 pt-100 pb-20" id="__index_ltn">
            <div class="page-content">
                
                    <div class="breadcrumb-warning d-flex justify-content-between ot-card"><div><h3>Evkin</h3></div><nav aria-label="breadcrumb "><ol class="breadcrumb ot-breadcrumb ot-breadcrumb-basic"><li class="breadcrumb-item "><a href="https://www.sistemweb.my.id/dashboard">Dashboard</a></li><li class="breadcrumb-item active">Evkin</li></ol></nav></div>
    <div class="table-content table-basic">
        <div class="card">

            <div class="card-body">
                <!-- toolbar table start -->
                <div
                    class="table-toolbar d-flex flex-wrap gap-2 flex-xl-row justify-content-xxl-between align-content-center pb-3">
                    <div class="align-self-center">
                        <div class="d-flex flex-wrap gap-2  flex-lg-row justify-content-center align-content-center">
                            <!-- show per page -->
                            <div class="align-self-center">
                                <label>
                                    <span class="mr-8">Show</span>
                                    <select class="form-select d-inline-block" id="entries" onchange="visitDatatable()">
                                        <option selected value="10">10</option>
<option value="25">25</option>
<option value="50">50</option>
<option value="100">100</option>
<option value="500">500</option>
<option value="1000">1000</option>                                    </select>
                                    <span class="ml-8">Entries</span>
                                </label>
                            </div>



                            <div class="align-self-center d-flex flex-wrap gap-2">
                                <!-- add btn -->



                                <!-- <div class="align-self-center">
                                    <div class="dropdown dropdown-designation" data-bs-toggle="tooltip"
                                        data-bs-placement="right" data-bs-title="type">
                                        <button type="button" class="btn-designation" data-bs-toggle="dropdown"
                                            aria-expanded="false" data-bs-auto-close="false">
                                            <span class="icon"><i class="fa-solid fa-tag"></i></span>
                                            <span class="d-none d-xl-inline">Status</span>
                                        </button>

                                        <div class="dropdown-menu  align-self-center ">
                                            <select name="status" class="form-control select2" id="status"
                                                onchange="visitDatatable()">
                                                <option value="">Status</option>
                                                                                                    <option value="created">Created</option>
                                                                                                    <option value="started">Started</option>
                                                                                                    <option value="reached">Reached</option>
                                                                                                    <option value="completed">Completed</option>
                                                                                                    <option value="canceled">Canceled</option>
                                                                                            </select>
                                        </div>
                                    </div>
                                </div> -->

                                <!-- search -->
                                <div class="align-self-center">
                                    <div class="search-box d-flex">
                                        <input class="form-control" placeholder="Search"
                                            name="search" onkeyup="visitDatatable()" autocomplete="off" />
                                        <span class="icon"><i class="fa-solid fa-magnifying-glass"></i></span>
                                    </div>
                                </div>


                            </div>


                        </div>
                    </div>
                    
                   

                </div>
                <!-- toolbar table end -->
                <!--  table start -->
                <div class="table-responsive">
                    @if(Auth::user()->is_admin==1)
                    <table class="table table-bordered visit_table" id="table">
                        <thead class="thead">
                            <tr>
                                <th class="sorting_desc">No</th>
                                <th class="sorting_desc">Bulan</th>
                                <th class="sorting_desc">Aksi</th>
                            </tr>
                            <tr>
                                <th class="sorting_desc">1</th>
                                <th class="sorting_desc">Januari</th>
                                <th class="sorting_desc"><a href="{!!url('hrm/evkin/fasilitator')!!}"><i class="fa fa-edit"></i></a></th>
                            </tr>
                            <tr>
                                <th class="sorting_desc">2</th>
                                <th class="sorting_desc">Februari</th>
                                <th class="sorting_desc"><a href="{!!url('hrm/evkin/fasilitator')!!}"><i class="fa fa-edit"></i></a></th>
                            </tr>
                            <tr>
                                <th class="sorting_desc">3</th>
                                <th class="sorting_desc">Maret</th>
                                <th class="sorting_desc"><a href="{!!url('hrm/evkin/fasilitator')!!}"><i class="fa fa-edit"></i></a></th>
                            </tr>
                            <tr>
                                <th class="sorting_desc">4</th>
                                <th class="sorting_desc">April</th>
                                <th class="sorting_desc"><a href="{!!url('hrm/evkin/fasilitator')!!}"><i class="fa fa-edit"></i></a></th>
                            </tr>
                            <tr>
                                <th class="sorting_desc">5</th>
                                <th class="sorting_desc">Mei</th>
                                <th class="sorting_desc"><a href="{!!url('hrm/evkin/fasilitator')!!}"><i class="fa fa-edit"></i></a></th>
                            </tr>
                            <tr>
                                <th class="sorting_desc">6</th>
                                <th class="sorting_desc">Juni</th>
                                <th class="sorting_desc"><a href="{!!url('hrm/evkin/fasilitator')!!}"><i class="fa fa-edit"></i></a></th>
                            </tr>
                            <tr>
                                <th class="sorting_desc">7</th>
                                <th class="sorting_desc">Juli</th>
                                <th class="sorting_desc"><a href="{!!url('hrm/evkin/fasilitator')!!}"><i class="fa fa-edit"></i></a></th>
                            </tr>
                            <tr>
                                <th class="sorting_desc">8</th>
                                <th class="sorting_desc">Agustus</th>
                                <th class="sorting_desc"><a href="{!!url('hrm/evkin/fasilitator')!!}"><i class="fa fa-edit"></i></a></th>
                            </tr>
                            <tr>
                                <th class="sorting_desc">9</th>
                                <th class="sorting_desc">September</th>
                                <th class="sorting_desc"><a href="{!!url('hrm/evkin/fasilitator')!!}"><i class="fa fa-edit"></i></a></th>
                            </tr>
                            <tr>
                                <th class="sorting_desc">10</th>
                                <th class="sorting_desc">Oktober</th>
                                <th class="sorting_desc"><a href="{!!url('hrm/evkin/fasilitator')!!}"><i class="fa fa-edit"></i></a></th>
                            </tr>
                            <tr>
                                <th class="sorting_desc">11</th>
                                <th class="sorting_desc">November</th>
                                <th class="sorting_desc"><a href="{!!url('hrm/evkin/fasilitator')!!}"><i class="fa fa-edit"></i></a></th>
                            </tr>
                            <tr>
                                <th class="sorting_desc">12</th>
                                <th class="sorting_desc">Desember</th>
                                <th class="sorting_desc"><a href="{!!url('hrm/evkin/fasilitator')!!}"><i class="fa fa-edit"></i></a></th>
                            </tr>
                        </thead>
                    </table>
                    @else
                    <table class="table table-bordered visit_table" id="table">
                        <thead class="thead">
                            <tr>
                                <th class="sorting_desc">No</th>
                                <th class="sorting_desc">Bulan</th>
                                <th class="sorting_desc">Nilai</th>
                                <th class="sorting_desc">Aksi</th>
                            </tr>
                            <tr>
                                <th class="sorting_desc">1</th>
                                <th class="sorting_desc">Januari</th>
                                <th class="sorting_desc">70</th>
                                <th class="sorting_desc"><a href="{!!url('hrm/evkin/detail_evkin')!!}"><i class="fa fa-info"></i></a></th>
                            </tr>
                            <tr>
                                <th class="sorting_desc">2</th>
                                <th class="sorting_desc">Februari</th>
                                <th class="sorting_desc">75</th>
                                <th class="sorting_desc"><a href="{!!url('hrm/evkin/detail_evkin')!!}"><i class="fa fa-info"></i></a></th>
                            </tr>
                            <tr>
                                <th class="sorting_desc">3</th>
                                <th class="sorting_desc">Maret</th>
                                <th class="sorting_desc">80</th>
                                <th class="sorting_desc"><a href="{!!url('hrm/evkin/detail_evkin')!!}"><i class="fa fa-info"></i></a></th>
                            </tr>
                            <tr>
                                <th class="sorting_desc">4</th>
                                <th class="sorting_desc">April</th>
                                <th class="sorting_desc">90</th>
                                <th class="sorting_desc"><a href="{!!url('hrm/evkin/detail_evkin')!!}"><i class="fa fa-info"></i></a></th>
                            </tr>
                            <tr>
                                <th class="sorting_desc">5</th>
                                <th class="sorting_desc">Mei</th>
                                <th class="sorting_desc">85</th>
                                <th class="sorting_desc"><a href="{!!url('hrm/evkin/detail_evkin')!!}"><i class="fa fa-info"></i></a></th>
                            </tr>
                            <tr>
                                <th class="sorting_desc">6</th>
                                <th class="sorting_desc">Juni</th>
                                <th class="sorting_desc">70</th>
                                <th class="sorting_desc"><a href="{!!url('hrm/evkin/detail_evkin')!!}"><i class="fa fa-info"></i></a></th>
                            </tr>
                            <tr>
                                <th class="sorting_desc">7</th>
                                <th class="sorting_desc">Juli</th>
                                <th class="sorting_desc">70</th>
                                <th class="sorting_desc"><a href="{!!url('hrm/evkin/detail_evkin')!!}"><i class="fa fa-info"></i></a></th>
                            </tr>
                            <tr>
                                <th class="sorting_desc">8</th>
                                <th class="sorting_desc">Agustus</th>
                                <th class="sorting_desc">80</th>
                                <th class="sorting_desc"><a href="{!!url('hrm/evkin/detail_evkin')!!}"><i class="fa fa-info"></i></a></th>
                            </tr>
                            <tr>
                                <th class="sorting_desc">9</th>
                                <th class="sorting_desc">September</th>
                                <th class="sorting_desc">90</th>
                                <th class="sorting_desc"><a href="{!!url('hrm/evkin/detail_evkin')!!}"><i class="fa fa-info"></i></a></th>
                            </tr>
                            <tr>
                                <th class="sorting_desc">10</th>
                                <th class="sorting_desc">Oktober</th>
                                <th class="sorting_desc">80</th>
                                <th class="sorting_desc"><a href="{!!url('hrm/evkin/detail_evkin')!!}"><i class="fa fa-info"></i></a></th>
                            </tr>
                            <tr>
                                <th class="sorting_desc">11</th>
                                <th class="sorting_desc">November</th>
                                <th class="sorting_desc">Belum dinilai</th>
                                <th class="sorting_desc">-</th>
                            </tr>
                            <tr>
                                <th class="sorting_desc">12</th>
                                <th class="sorting_desc">Desember</th>
                                <th class="sorting_desc">Belum dinilai</th>
                                <th class="sorting_desc">-</th>
                            </tr>
                        </thead>
                    </table>
                    @endif
    <input type="text" hidden id="visit_table_url" value="https://www.sistemweb.my.id/hrm/visit">
                </div>
                <!--  table end -->
            </div>
        </div>
    </div>
                
            </div>
            
            <!-- /.content-wrapper -->
<footer class="footer main-footer mt-3">
    
    <p class="px-4">&copy;2023<a href="#"> DRP KEMENDESA    </a>  All rights reserved</p>
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

    
    
    <script >
    
                    </script>

    
    
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