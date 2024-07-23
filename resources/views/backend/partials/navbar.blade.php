<header class="header">

    <div class="header-search"> 
    </div>

    <button class="close-toggle sidebar-toggle">
        <img src="{{ url('assets/images/icons/hammenu-2.svg') }}" alt="">
    </button>
    <div class="header-controls">
        @php
        if(auth()->user()->role !=""){
            $role_slug=auth()->user()->role ?? auth()->user()->role->slug == 'admin' ? 'admin' : 'staff';
        }
        $role_slug="";
        @endphp
    
        {{-- <x-company-dropdown /> --}}
     
 
        @if (config('app.mood')==="Saas" && isModuleActive("Saas") && (auth()->user()->is_admin == 1 || auth()->user()->role->slug == 'admin' || auth()->user()->role->slug=="superadmin"))
            @includeIf('MultiBranch::select_branch')
        @endif


        {{-- <x-branch-dropdown /> --}}

        <div class="header-control-item">
            <div class="item-content dropdown">
                <a class="nav-link __clock_nav mt-0" href="javascript:void(0)">
                    <span class="clock company_name_clock fs-16" id="clock" onload="currentTime()">{{ _trans('partial.00:00:00') }}</span>
                </a>
            </div>
        </div>

        <div class="header-control-item">

            <div class="item-content d-flex align-items-center">
                <div class="mt-0 d-flex  align-items-between pe-auto cursor-pointer pointer " role="navigation" id="topbar_messages"
                    aria-expanded="false">
                    @if (!isAttendee()['checkin'] && auth()->user()->role_id != 1)
                        <a id="demo" onclick="viewModal(`https://tekad.kemendesa.go.id/e-lapkin/dashboard/ajax-checkin-modal`)"
                            data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="{{ _trans('common.Masuk Kerja') }}"
                            class="ml-2 mr-2 checkin d-flex align-items-center sm-btn-with-radius checkin-color me-3 chckinout-btn">
                            <span class="checkin-btn"><i class="las la-sign-in-alt"></i></span>
                        </a>
                    @endif
                    @if (isAttendee()['checkin'] && !isAttendee()['checkout'])
                        <a onclick="viewModal(`https://tekad.kemendesa.go.id/e-lapkin/dashboard/ajax-checkout-modal`)"
                            data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="{{ _trans('common.Pulang Kerja') }}"
                            class="  d-flex  align-items-center sm-btn-with-radius checkout-color me-3 chckinout-btn">
                            <span class="checkout-btn"><i class="las la-sign-out-alt"></i></span>
                        </a>

                    @endif
                    @if (isAttendee()['checkin'] && isAttendee()['checkout'])
                        <a id="demo" onclick="viewModal(`{{ route('admin.ajaxDashboardCheckinModal') }}`)"
                            class="ml-2 mr-2 checkin d-flex align-items-center sm-btn-with-radius checkin-color me-3 chckinout-btn">
                            <span class="checkin-btn"><i class="las la-sign-in-alt"></i></span>
                        </a>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="header-control-item">
            <div class="item-content">
                <div class="profile-navigate mt-0 cursor-pointer " id="profile_expand" data-bs-toggle="dropdown"
                     role="navigation">
                    <div class="profile-photo">
                        
                        @if(substr(Auth::user()->image,0,6)=='static' || empty(Auth::user()->image))
                            <img src="https://tekad.kemendesa.go.id/e-lapkin/static/blank_small.png" style="object-fit: cover;"></a>
                        @else
                            <img src="https://tekad.kemendesa.go.id/monev/storage/{{Auth::user()->image}}" style="object-fit: cover;"></a>
                        @endif
                    </div>
                    <div class="profile-info md-none">
                        <h6>{{ @Auth::user()->name }}</h6>
                        <p> 
                        @if(Auth::user()->department_id==1) 
                            Admin
                        @elseif(Auth::user()->department_id==5) 
                            Kordinator Kabupaten
                        @elseif(Auth::user()->department_id==6) 
                            Fasilitator Kabupaten
                        @elseif(Auth::user()->department_id==7) 
                            Fasilitator Kecamatan
                        @elseif(Auth::user()->department_id==8) 
                            Kader Desa
                        @elseif(Auth::user()->department_id==24) 
                            User Tamu
                        @elseif(Auth::user()->department_id==25) 
                            Project Manager
                        @elseif(Auth::user()->department_id==26) 
                            PIC Kegiatan
                        @elseif(Auth::user()->department_id==27) 
                            Koordinator Wilayah (Korwil)
                        @elseif(Auth::user()->department_id==28) 
                            Sekretaris NPMU
                        @elseif(Auth::user()->department_id==29) 
                            NPMU-OFFICER
                        @elseif(Auth::user()->department_id==30) 
                            TA TEKAD
                        @elseif(Auth::user()->department_id==31) 
                            TPK Provinsi
                        @elseif(Auth::user()->department_id==32) 
                            TA Provinsi
                        @elseif(Auth::user()->department_id==33) 
                            TPK Kabupaten
                        @endif
                        </p>
                    </div>
                </div>
                <div class="dropdown-menu dropdown-menu-end profile-expand-dropdown top-navbar-dropdown-menu ot-card pa-0"
                    aria-labelledby="profile_expand">
                    <div class="profile-expand-container">
                        <div class="profile-expand-list d-flex flex-column">
                            <a class="profile-expand-item " href="{!!url('profile')!!}">
                                <span>Profil</span>
                            </a>
                            <a class="profile-expand-item " href="{!!url('logout-web')!!}">
                                <span>{{ _trans('common.Logout') }}</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
