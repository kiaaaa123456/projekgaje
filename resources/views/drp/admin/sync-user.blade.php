@extends('backend.layouts.app')
@section('title', 'Singkronisasi User')
@section('content')

	<div class="breadcrumb-warning d-flex justify-content-between ot-card">
    <div><h3>Singkronisasi User</h3></div>
    <nav aria-label="breadcrumb ">
        <ol class="breadcrumb ot-breadcrumb ot-breadcrumb-basic">
            <li class="breadcrumb-item"><a href="{!!url('dashboard')!!}">Dashboard</a></li>
            <li class="breadcrumb-item active">Singkronisasi User</li>
        </ol>
    </nav>
</div>
<div class="table-content table-basic">
    <div class="card">
        <div class="card-body">

            Klik button di bawah ini untuk melakukan singkronisasi data user dengan aplikasi monev.
            <br/><br/><br/>
            <center>
                <button class="btn btn-success btn-sm btn-sync">Singkronisasi User</button>
            </center>
            <br/><br/><br/>

        </div>
    </div>
</div>




@endsection
@section('script')

<script type="text/javascript">

    toastr.options = {
        "closeButton": true,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "3000",
        "hideDuration": "3000",
        "timeOut": "5000",
        "extendedTimeOut": "3000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    } 

    $(".btn-sync").click(function(){
        $.ajax({
            url:"https://tekad.kemendesa.go.id/e-lapkin/cronjob/sync_user.php",
            method:"GET",
            dataType:"json",
            beforeSend: function(){
            $('.loader').css("visibility", "visible");
            },
            success:function(data)
            {
                if(data.status==='success') {
                    toastr.success("Sukses <br> Proses singkronisasi user berhasil.");
                    // location.reload();
                } else {
                   swal("Gagal!", "Silakan coba lagi", "error")
                }
            },
        });
    });
</script>

@endsection
