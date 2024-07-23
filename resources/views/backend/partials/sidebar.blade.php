<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="sidebar-logo">
            <a href="{{ route('admin.dashboard') }}" class="img-tag sidebar_logo">
                @include('backend.auth.backend_logo')
                <img class="half-logo" src="{{ uploaded_asset(@base_settings('company_icon')) }}" alt="Icon"
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
            <br><br>
            <ul class="sidebar-dropdown-menu parent-menu-list">
                <li class="sidebar-menu-item">
                    <a href="{!!url('dashboard')!!}"
                        class="parent-item-content {{ set_active(route('admin.dashboard')) }}">
                        <i class="fa fa-home"style="font-size:20px"></i>
                        <span class="on-half-expanded">{{ _trans('common.Dashboard') }}</span>
                    </a>
                </li>

                @if(Auth::user()->is_admin==1)
                <li class="sidebar-menu-item">
                    <a href="javascript:void(0)" class="parent-item-content has-arrow in-active">
                        <i class="fa fa-list"style="font-size:20px"></i>
                        <span class="on-half-expanded">
                            Data Master
                        </span>
                    </a>
                    <ul class="child-menu-list">
                        <li class="nav-item in-active">
                            <a href="{!!url('provinsi')!!}" class=" ">
                                <span>Provinsi</span>
                            </a>
                        </li>
                        <li class="nav-item in-active">
                            <a href="{!!url('kabupaten')!!}" class=" ">
                                <span>Kabupaten</span>
                            </a>
                        </li>
                        <li class="nav-item in-active">
                            <a href="{!!url('kecamatan')!!}" class=" ">
                                <span>Kecamatan</span>
                            </a>
                        </li>
                        <li class="nav-item in-active">
                            <a href="{!!url('desa')!!}" class=" ">
                                <span>Desa</span>
                            </a>
                        </li>
                        <li class="nav-item in-active">
                            <a href="{!!url('role')!!}" class=" ">
                                <span>Role User</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-menu-item ">
                    <a href="{!!url('daftar-fasilitator')!!}"
                        class="parent-item-content {{ menu_active_by_route(['user.index', 'user.edit', 'user.create']) }}">
                        <i class="fa fa-user-circle"style="font-size:20px"></i>
                        <span class="on-half-expanded">
                            {{ _trans('common.Daftar Pengguna') }}
                        </span>
                    </a>
                </li>
                <li class="sidebar-menu-item ">
                    <a href="{!!url('absensi')!!}"
                        class="parent-item-content @if( Request::segment(2)=='absensi') active @endif">
                        <i class="fa fa-check-square"style="font-size:20px"></i>
                        <span class="on-half-expanded">
                            Absensi
                        </span>
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <a href="{!!url('tidak-masuk')!!}"
                        class="parent-item-content">
                        <i class="fa fa-times-circle"style="font-size:20px"></i>
                        <span class="on-half-expanded">{{ _trans('common.Tidak Masuk Kerja') }}</span>
                    </a>
                </li>
                <li class="sidebar-menu-item ">
                    <a href="{!!url('aktivitas-harian')!!}"
                        class="parent-item-content @if( Request::segment(2)=='aktivitas-harian') active @endif">
                        <i class="fa fa-book"style="font-size:20px"></i>
                        <span class="on-half-expanded">
                            Aktivitas Harian
                        </span>
                    </a>
                </li> 
                <li class="sidebar-menu-item ">
                    <a href="{!!url('laporan-bulanan')!!}"
                        class="parent-item-content @if( Request::segment(2)=='laporan-bulanan') active @endif">
                        <i class="fa fa-calendar"style="font-size:20px"></i>
                        <span class="on-half-expanded">
                            Laporan Bulanan
                        </span>
                    </a>
                </li>
                <li class="sidebar-menu-item ">
                    <a href="{!!url('periode-evkin-admin')!!}"
                        class="parent-item-content @if( Request::segment(2)=='periode-evkin-admin') active @endif">
                        <i class="fa fa-tag" style="font-size:20px"></i>
                        <span class="on-half-expanded">
                            Evkin
                        </span>
                    </a>
                </li> 
                <li class="sidebar-menu-item">
                    <a href="javascript:void(0)" class="parent-item-content has-arrow in-active">
                        <i class="fa fa-print" style="font-size:20px"></i>
                        <span class="on-half-expanded">
                            Laporan
                        </span>
                    </a>
                    <ul class="child-menu-list">
                        <li class="nav-item in-active">
                            <a href="{!!url('laporan-absensi')!!}" class=" ">
                                <span>Lap Absensi</span>
                            </a>
                        </li>
                        <li class="nav-item in-active">
                            <a href="{!!url('laporan-aktivitas-harian')!!}" class=" ">
                                <span>Lap Aktivitas Harian</span>
                            </a>
                        </li>
                        <li class="nav-item in-active">
                            <a href="{!!url('laporan-rekap-bulanan')!!}" class=" ">
                                <span>Lap Rekap Bulanan</span>
                            </a>
                        </li> 
                        <li class="nav-item in-active">
                            <a href="{!!url('laporan-cronjob')!!}" class=" ">
                                <span>Lap Cronjob Absensi</span>
                            </a>
                        </li>                                                               
                    </ul>
                </li> 
                <li class="sidebar-menu-item">
                    <a href="javascript:void(0)" class="parent-item-content has-arrow in-active">
                        <i class="fa fa-gear" style="font-size:20px"></i>
                        <span class="on-half-expanded">
                            Konfigurasi
                        </span>
                    </a>
                    <ul class="child-menu-list">
                        <!-- <li class="nav-item in-active">
                            <a href="{!!url('sync-user')!!}" class=" ">
                                <span>Singkronisasi User</span>
                            </a>
                        </li> -->
                        <li class="nav-item in-active">
                            <a href="{!!url('backup-db')!!}" class=" ">
                                <span>Backup Database</span>
                            </a>
                        </li>                                                              
                    </ul>
                </li> 

                @else

                    @if(Auth::user()->department_id==8 || Auth::user()->department_id==7 || Auth::user()->department_id==6 || Auth::user()->department_id==5)
                
                    <li class="sidebar-menu-item ">
                        <a href="{!!url('absensi-saya')!!}"
                            class="parent-item-content @if( Request::segment(2)=='absensi-saya') active @endif">
                            <i class="fa fa-check-square"style="font-size:20px"></i>
                            <span class="on-half-expanded">
                                Absensi
                            </span>
                        </a>
                    </li>
                    
                    <li class="sidebar-menu-item ">
                        <a href="{!!url('tidak-masuk-saya')!!}"
                            class="parent-item-content @if( Request::segment(2)=='tidak-masuk-saya') active @endif">
                            <i class="fa fa-times-circle"style="font-size:20px"></i>
                            <span class="on-half-expanded">
                                Tidak Masuk Kerja
                            </span>
                        </a>
                    </li>

                    <li class="sidebar-menu-item ">
                        <a href="{!!url('aktivitas-harian-saya')!!}"
                            class="parent-item-content @if( Request::segment(2)=='aktivitas-harian-saya') active @endif">
                            <i class="fa fa-book"style="font-size:20px"></i>
                            <span class="on-half-expanded">
                                Aktivitas Harian
                            </span>
                        </a>
                    </li> 
                    
                    <li class="sidebar-menu-item ">
                        <a href="{!!url('laporan-bulanan-saya')!!}"
                            class="parent-item-content @if( Request::segment(2)=='laporan-bulanan-saya') active @endif">
                            <i class="fa fa-calendar"style="font-size:20px"></i>
                            <span class="on-half-expanded">
                                Laporan Bulanan
                            </span>
                        </a>
                    </li>  

                    <li class="sidebar-menu-item ">
                        <a href="{!!url('evkin-saya')!!}"
                            class="parent-item-content @if( Request::segment(2)=='evkin') active @endif">
                            <i class="fa fa-tag" style="font-size:20px"></i>
                            <span class="on-half-expanded">
                                Evkin
                            </span>
                        </a>
                    </li> 

                    @endif

                    @if(Auth::user()->department_id==27 || Auth::user()->department_id==33 || Auth::user()->department_id==31)
                
                    <li class="sidebar-menu-item ">
                        <a href="{!!url('absensi-korkab')!!}"
                            class="parent-item-content @if( Request::segment(2)=='absensi-korkab') active @endif">
                            <i class="fa fa-check-square"style="font-size:20px"></i>
                            <span class="on-half-expanded">
                                Absensi
                            </span>
                        </a>
                    </li>
                    
                    <li class="sidebar-menu-item ">
                        <a href="{!!url('tidak-masuk-korkab')!!}"
                            class="parent-item-content @if( Request::segment(2)=='tidak-masuk-korkab') active @endif">
                            <i class="fa fa-times-circle"style="font-size:20px"></i>
                            <span class="on-half-expanded">
                                Tidak Masuk Kerja
                            </span>
                        </a>
                    </li>

                    <li class="sidebar-menu-item ">
                        <a href="{!!url('aktivitas-harian-korkab')!!}"
                            class="parent-item-content @if( Request::segment(2)=='aktivitas-harian-korkab') active @endif">
                            <i class="fa fa-book"style="font-size:20px"></i>
                            <span class="on-half-expanded">
                                Aktivitas Harian
                            </span>
                        </a>
                    </li> 
                    
                    <li class="sidebar-menu-item ">
                        <a href="{!!url('laporan-bulanan-korkab')!!}"
                            class="parent-item-content @if( Request::segment(2)=='laporan-bulanan-korkab') active @endif">
                            <i class="fa fa-calendar"style="font-size:20px"></i>
                            <span class="on-half-expanded">
                                Laporan Bulanan
                            </span>
                        </a>
                    </li>  

                    <li class="sidebar-menu-item ">
                        <a href="{!!url('evkin-korkab')!!}"
                            class="parent-item-content @if( Request::segment(2)=='korkab') active @endif">
                            <i class="fa fa-tag" style="font-size:20px"></i>
                            <span class="on-half-expanded">
                                Evkin
                            </span>
                        </a>
                    </li> 

                    @endif

                @endif

            </li>
                    



                

            </ul>
            <!-- parent menu list end  -->
        </div>
    </div>
</aside>
