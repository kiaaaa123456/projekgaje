@extends('backend.layouts.app')
@section('title', @$data['title'])
@section('content')
    {!! breadcrumb([
        'title' => @$data['title'],
        route('admin.dashboard') => _trans('common.Dashboard'),
        '#' => @$data['title'],
    ]) !!}

    <style type="text/css">
        #map-canvas {
            height: 100%;
            margin: 0px;
            padding: 0px;
        }
        .controls {
            margin-top: 16px;
            border: 1px solid transparent;
            border-radius: 2px 0 0 2px;
            box-sizing: border-box;
            -moz-box-sizing: border-box;
            height: 32px;
            outline: none;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        }

        #pac-input {
            background-color: #fff;
            font-family: Roboto;
            font-size: 15px;
            font-weight: 300;
            margin-left: 12px;
            padding: 0 11px 0 13px;
            text-overflow: ellipsis;
            width: 400px;
        }

        #pac-input:focus {
            border-color: #4d90fe;
        }

        .pac-container {
            font-family: Roboto;
        }

        #type-selector {
            color: #fff;
            background-color: #4d90fe;
            padding: 5px 11px 0px 11px;
        }

        #type-selector label {
            font-family: Roboto;
            font-size: 13px;
            font-weight: 300;
        }
    </style>
    <div class="table-content table-basic ">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form method="POST" action="{{ route('appointment.store') }}" class=""
                            enctype="multipart/form-data" id="saveData">
                            @csrf
                            <input type="text" hidden value="{{ auth()->id() }}" name="user_id">
                            <input type="hidden"  value="1" name="appoinment_with">
                            <div class="">
                                <div class="row">

                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="name">{{ _trans('common.Rencana') }} <span
                                                    class="text-danger">*</span></label>
                                            <textarea name="title" class="form-control mt-0 ot-input" placeholder="{{ _trans('common.Masukkan Rencana Kegiatan') }}" rows="6" required></textarea>
                                            @if ($errors->has('rencana'))
                                                <div class="error">{{ $errors->first('rencana') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label class="form-label">{{ _trans('common.Realisasi') }} <span
                                                    class="text-danger">*</span></label>
                                            <textarea name="description" class="form-control mt-0 ot-input" placeholder="{{ _trans('common.Masukkan Realisasi Kegiatan') }}" rows="6" required></textarea>
                                            @if ($errors->has('realisasi'))
                                                <div class="error">{{ $errors->first('realisasi') }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <!--<div class="col-md-12">
                                        <center>
                                        
                                            <input id="pac-input" class="controls" type="text" name="location" placeholder="Cari tempat/lokasi .." />
                                            <div id="map-canvas" style="width: 100%; height: 380px;"></div>
                                        
                                        </center>
                                        <br><br>
                                    </div>-->

                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="location"
                                                class="form-label">{{ _trans('common.Lokasi') }} <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="location" id="location" class="form-control ot-form-control ot-input" readonly>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="lat"
                                                class="form-label">{{ _trans('common.Latitude') }} <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="latitude" id="lat" class="form-control ot-form-control ot-input" readonly>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="long"
                                                class="form-label">{{ _trans('common.Longitude') }} <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="longitude" id="long" class="form-control ot-form-control ot-input" readonly>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="date"
                                                class="form-label">{{ _trans('common.Tanggal') }} <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="date" id="date"
                                                class="form-control ot-form-control ot-input" placeholder="{{ _trans('common.Date') }}" value="{{date('d-m-Y')}}" readonly>
                                            @if ($errors->has('date'))
                                                <div class="error">{{ $errors->first('date') }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    

                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="#" class="form-label">{{ _trans('common.Jam Mulai') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control ot-form-control ot-input"
                                                name="appoinment_start_at" placeholder="{{ _trans('common.Jam Mulai') }}" value="{{ old('appoinment_start_at') }}"
                                                required>
                                            @if ($errors->has('appoinment_start_at'))
                                                <div class="error">{{ $errors->first('appoinment_start_at') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="#" class="form-label">{{ _trans('common.Jam Berakhir') }} <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control ot-form-control ot-input"
                                                name="appoinment_end_at" placeholder="{{ _trans('common.Jam Berakhir') }}" value="{{ old('appoinment_end_at') }}" required>
                                            @if ($errors->has('appoinment_end_at'))
                                                <div class="error">{{ $errors->first('appoinment_end_at') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="#" class="form-label">{{ _trans('common.Lampiran Kegiatan') }} <span
                                                    class="text-danger">*</span></label>
                                            <input type="file" class="form-control ot-form-control ot-input"
                                                name="file" placeholder="{{ _trans('common.Lampiran Kegiatan') }}" value="{{ old('file') }}" required>
                                            @if ($errors->has('file'))
                                                <div class="error">{{ $errors->first('file') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-12 ">
                                        <div class=" float-right d-flex justify-content-end">
                                            <button type="submit"
                                                class="btn btn-success action-btn">{{ _trans('common.Simpan') }}</button>
                                        </div>
                                    </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <input type="hidden" id="get_user_url" value="{{ route('user.getUser') }}">
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyALCRT0rEUbgVV9SfMqfyUvW3rZiTjTLqA&libraries=places"></script>

    <script>
        
        var url_main = "{!!url('')!!}";
        // $(document).ready(function(){
        //     $('#saveData').on('submit', function(e){
        //         e.preventDefault();
        //         var lat = $('#lat').val();
        //         if(lat=="") {
        //             alert('Map tidak boleh kosong!') 
        //         } else {

        //             $.ajax({
        //             url: ""+url_main+"/hrm/appointment/store",
        //             type: "POST",
        //             data:new FormData(this),
        //             contentType: false,
        //             cache: false,
        //             processData: false,
        //             dataType:"json",
        //             success: function (data) {
        //                 window.location = ""+url_main+"/hrm/appointment";
        //             },
        //         });
        //         }
        //     });
        // });

        
        // var marker;
      
        // function taruhMarker(peta, posisiTitik){
            
        //     if( marker ){
        //         marker.setPosition(posisiTitik);
        //     } else {
        //         marker = new google.maps.Marker({
        //             position: posisiTitik,
        //             map: peta
        //         });
        //     }
                   

        //     document.getElementById("lat").value = posisiTitik.lat();
        //     document.getElementById("long").value = posisiTitik.lng();
            
        // }
        
        // function initialize() {
        //     var markers = [];
        //     var map = new google.maps.Map(document.getElementById("map-canvas"), {
        //         mapTypeId: google.maps.MapTypeId.ROADMAP,
        //     });

        //     var defaultBounds = new google.maps.LatLngBounds(new google.maps.LatLng(-6.165646, 106.8214951), new google.maps.LatLng(-6.115646, 106.8214951));


            
        //     google.maps.event.addListener(map, 'click', function(event) {
        //     taruhMarker(this, event.latLng);
        //     });

        //     map.fitBounds(defaultBounds);

        //     // Create the search box and link it to the UI element.
        //     var input = /** @type {HTMLInputElement} */ (document.getElementById("pac-input"));
        //     map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        //     var searchBox = new google.maps.places.SearchBox(/** @type {HTMLInputElement} */ (input));

        //     // [START region_getplaces]
        //     // Listen for the event fired when the user selects an item from the
        //     // pick list. Retrieve the matching places for that item.
        //     google.maps.event.addListener(searchBox, "places_changed", function () {
        //         var places = searchBox.getPlaces();

        //         if (places.length == 0) {
        //             return;
        //         }
        //         for (var i = 0, marker; (marker = markers[i]); i++) {
        //             marker.setMap(null);
        //         }

        //         // For each place, get the icon, place name, and location.
        //         markers = [];
        //         var bounds = new google.maps.LatLngBounds();
        //         for (var i = 0, place; (place = places[i]); i++) {
        //             var image = {
        //                 url: place.icon,
        //                 size: new google.maps.Size(71, 71),
        //                 origin: new google.maps.Point(0, 0),
        //                 anchor: new google.maps.Point(17, 34),
        //                 scaledSize: new google.maps.Size(25, 25),
        //             };

        //             // Create a marker for each place.
        //             var marker = new google.maps.Marker({
        //                 map: map,
        //                 icon: image,
        //                 title: place.name,
        //                 position: place.geometry.location,
        //             });

        //             markers.push(marker);

        //             // bounds.extend(place.geometry.location);
        //         }

        //         // map.fitBounds(bounds);
        //         map.fitBounds(places[0].geometry.viewport);
        //     });
        //     // [END region_getplaces]

        //     // Bias the SearchBox results towards places that are within the bounds of the
        //     // current map's viewport.
        //     google.maps.event.addListener(map, "bounds_changed", function () {
        //         var bounds = map.getBounds();
        //         searchBox.setBounds(bounds);
        //     });
        // }

        // google.maps.event.addDomListener(window, "load", initialize);

        let api_key = "the_key_you_get_from_your_account";
            $.getJSON("https://ipgeolocation.abstractapi.com/v1/?api_key=c3c3af51992545b5998dce0e992ffcda", function(data) {
            var loc_info = "Your location details :\n";
            loc_info += "Latitude: "+data.latitude +"\n";
            loc_info += "Longitude: "+data.longitude+"\n";
            loc_info += "Timezone: GMT"+data.gmt_offset+"\n";
            loc_info += "Country: "+data.country+"\n";
            loc_info += "Region: "+data.region+"\n";
            loc_info += "City: "+data.city+"\n";
            console.log(loc_info);
            $('#lat').val(data.latitude);
            $('#long').val(data.longitude);
            $('#location').val(''+data.city+', '+data.region+', '+data.country+'');
        })

        // var lat_val = $('#lat').val();
        // var long_val = $('#long').val();

        // console.log('Lat'+lat_val);

        // function initialize() {

        //     var propertiPeta = {
        //         center:new google.maps.LatLng(lat_val , long_val),
        //         zoom:9,
        //         mapTypeId:google.maps.MapTypeId.ROADMAP
        //     };
            
        //     var peta = new google.maps.Map(document.getElementById("googleMap"), propertiPeta);
            
        //     // membuat Marker
            
        //     var marker=new google.maps.Marker({
        //         position: new google.maps.LatLng(lat_val , long_val),
        //         map: peta
        //     });

        // }

        // // event jendela di-load  
        // google.maps.event.addDomListener(window, 'load', initialize);

    </script>
@endsection
