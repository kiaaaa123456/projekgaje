<!DOCTYPE html>

<html lang="id">
<!--begin::Head-->

<head> 
    <base href="" />
    <title>TEKAD</title>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="Sf3NS76ld97RBtMIs0rYWt7Y0xCx2MixQhyGVmR7">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="canonical" href="https://preview.keenthemes.com/metronic8" />
    <link rel="shortcut icon" href="https://alfanumerik-lab.com/tekad_2023/monev/assets/media/logos/favicon.ico" />
    <!--begin::Fonts(mandatory for all pages)-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Vendor Stylesheets(used for this page only)-->
    <link href="https://alfanumerik-lab.com/tekad_2023/monev/assets/plugins/custom/fullcalendar/fullcalendar.bundle.css"
        rel="stylesheet" type="text/css" />
    <link href="https://alfanumerik-lab.com/tekad_2023/monev/assets/plugins/custom/datatables/datatables.bundle.css"
        rel="stylesheet" type="text/css" />
    <!--end::Vendor Stylesheets-->
    <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
    <link href="https://alfanumerik-lab.com/tekad_2023/monev/assets/plugins/global/plugins.bundle.css" rel="stylesheet"
        type="text/css" />
    <link href="https://alfanumerik-lab.com/tekad_2023/monev/assets/css/style.bundle.css" rel="stylesheet"
        type="text/css" />
    <!--end::Global Stylesheets Bundle-->
    <link rel="stylesheet" href="https://kendo.cdn.telerik.com/2022.3.913/styles/kendo.default-main.min.css">
    <link rel="stylesheet" href="https://kendo.cdn.telerik.com/2022.3.913/styles/kendo.default.mobile.min.css">

    <style>
        table th {
            font-weight: bold !important;
        }
    </style>

    <style>
        .image-preview {
            position: relative;
            vertical-align: top;
            height: 45px;
        }
    </style>
</head>
<!--end::Head-->
<!--begin::Body-->

<body data-kt-name="metronic" data-theme-mode="light" id="kt_body" class="app-blank bg-danger">

    <div class="d-flex flex-column flex-root bg-secondary" id="kt_content">

        <div class="d-flex flex-column flex-lg-row flex-column-fluid">
            <div class="container" id="content-registrasi">
                <section id="header" class="mt-5">
                    <div class="d-flex">
                        <div class="flex-grow-1 pt-3">
                            <h1 class="text-green fw-bolder">Registrasi Pengguna Aplikasi - TEKAD MONEV</h1>
                        </div>
                        <div>
                            <img src="https://alfanumerik-lab.com/tekad_2023/monev/assets/media/logos/logo-tekad.png"
                                alt="logo-tekad.png" class="w-100px">
                        </div>
                    </div>
                </section>
                <form method="POST" action="add-dataregister">
                    @csrf <section id="body" class="p-5 mt-5">
                        <div class="card mb-5">
                            <div class="card-header">
                                <h3 class="card-title">Form Registrasi</h3>
                                <div class="card-toolbar">
                                    <a class="btn btn-secondary btn-sm"
                                        href="https://alfanumerik-lab.com/tekad_2023/monev/login" role="button"
                                        href="">
                                        <i class="fa fa-arrow-left"></i> Kembali
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row mb-5">
                                    <div class="col-lg-6">
                                        <h3 class="text-green">Biodata</h3>
                                        <section id="biodata">
                                            <div class="form-group mb-5">
                                                <label class="fw-bold required">NIK</label>
                                                <input type="text" name="nik" id="nik" class="textbox"
                                                    required>
                                            </div>
                                            <div class="form-group mb-5">
                                                <label class="fw-bold required">Nama Lengkap</label>
                                                <input type="text" name="fullname" id="fullname" class="textbox"
                                                    required>
                                            </div>
                                            <div class="form-group mb-5">
                                                <label class="fw-bold required">Nama Singkat</label>
                                                <input type="text" name="nickname" id="nickname" class="textbox"
                                                    required>
                                            </div>
                                            <div class="form-group mb-5">
                                                <label class="fw-bold required">Tanggal Lahir</label>
                                                <input type="text" name="tgl_lahir" id="tgl_lahir" class="datepicker"
                                                    required>
                                            </div>
                                            <div class="form-group mb-5">
                                                <label class="fw-bold required">Jenis Kelamin</label>
                                                <select name="jenis_kelamin" id="jenis_kelamin" required="">
                                                    <option value="Laki-laki">Laki-laki</option>
                                                    <option value="Perempuan">Perempuan</option>
                                                </select>
                                            </div>
                                            <div class="form-group mb-5">
                                                <label class="fw-bold required">Ho HP</label>
                                                <input type="text" name="telpno" id="telpno" class="textbox"
                                                    required>
                                            </div>
                                            <div class="form-group mb-5">
                                                <label class="fw-bold">Alamat</label>
                                                <textarea name="alamat" id="alamat" class="textarea"></textarea>
                                            </div>
                                        </section>
                                    </div>
                                    <div class="col-lg-6">
                                        <section id="akun">
                                            <h3 class="text-green">Akun</h3>
                                            <div class="form-group mb-5">
                                                <label class="fw-bold">Foto Profil</label>
                                                <input type="file" name="photo_file" id="photo_file">
                                                <input type="text" name="photo" id="photo"
                                                    class="textbox d-none">
                                            </div>

                                            <div class="form-group mb-5">
                                                <label class="fw-bold required">Email</label>
                                                <input type="email" name="email_register" id="email_register"
                                                    class="textbox" required>
                                            </div>
                                            <div class="form-group mb-5">
                                                <label class="fw-bold required">Password</label>
                                                <input type="password" name="password" id="password"
                                                    class="textbox" required>
                                            </div>
                                            <div class="form-group mb-5">
                                                <label class="fw-bold required">Konfirmasi Password</label>
                                                <input type="password" name="password_confirmation"
                                                    id="password_confirmation" class="textbox" required>
                                            </div>
                                        </section>

                                        <section id="peran">
                                            <h3 class="text-green">Peran & Lokasi Penugasan</h3>
                                            <div class="form-group mb-5">
                                                <label class="fw-bold required">Peran</label>
                                                <select name="roleid" class="form-select select2" required=""
                                                    id="roleid">
                                                    <option value="">-Pilih Peran-</option>
                                                    <option value="16">KADER (Kader Desa)</option>
                                                    <option value="15">FK-FASDIS (Fasilitator Kecamatan)</option>
                                                    <option value="14">FASKAB (Fasilitator Kabupaten)</option>
                                                    <option value="13">KORKAB (Koodinator Kabupaten)</option>
                                                    <option value="12">TPK-KAB (TPK Kabupaten)</option>
                                                    <option value="11">TPK-TAPROV (TA Provinsi)</option>
                                                    <option value="10">TPK-PROV (TPK Provinsi)</option>
                                                    <option value="9">NPMU-TA (TA Tekad)</option>
                                                    <option value="8">NPMU-OFFICER (Planning, Procurement,
                                                        Finance, M&amp;E, GESI, SECAP)</option>
                                                    <option value="5">NPMU-SEKRE (Sekretaris NPMU)</option>
                                                    <option value="4">NPMU-KORWIL (Koordinator Wilayah (Korwil)
                                                    </option>
                                                    <option value="3">NPMU-PIC (PIC Kegiatan)</option>
                                                    <option value="1">NPMU-PM (Project Manager)</option>
                                                </select>

                                                <div class="mt-1" id="content-role-description"></div>
                                            </div>
                                            <div class="form-group mb-5">
                                                <label class="fw-bold" id="lbl-kdprov">Provinsi</label>
                                                <select name="kdprov" class="form-select select2" id="kdprov">
                                                    <option value="">-Pilih Provinsi- </option>
                                                    <option value="00">PUSAT</option>
                                                    <option value="53">NUSA TENGGARA TIMUR</option>
                                                    <option value="81">MALUKU</option>
                                                    <option value="82">MALUKU UTARA</option>
                                                    <option value="91">PAPUA</option>
                                                    <option value="92">PAPUA BARAT</option>
                                                    <option value="93">PAPUA SELATAN</option>
                                                    <option value="94">PAPUA TENGAH</option>
                                                    <option value="95">PAPUA PEGUNUNGAN</option>
                                                    <option value="96">PAPUA BARAT DAYA</option>

                                                </select>
                                            </div>
                                            <div class="form-group mb-5">
                                                <label class="fw-bold" id="lbl-kdkab">Kabupaten</label>
                                                <select name="kdkab" class="form-select select2" id="kdkab">
                                                    <option value="">-Pilih Kabupaten-</option>
                                                    <option value="5309">NGADA</option>
                                                    <option value="5310">MANGGARAI</option>
                                                    <option value="5311">SUMBA TIMUR</option>
                                                </select>

                                            </div>
                                            <div class="form-group mb-5">
                                                <label class="fw-bold" id="lbl-kdkec">Kecamatan</label>
                                                <select name="kdkec" class="form-select select2" id="kdkec">
                                                    <option value="">-Pilih Kecamatan-</option>
                                                    <option value="530902">GOLEWA</option>
                                                    <option value="530906">BAJAWA</option>
                                                    <option value="530907">SOA</option>
                                                    <option value="530909">RIUNG</option>
                                                    <option value="530912">JEREBUU</option>
                                                    <option value="530914">RIUNG BARAT</option>
                                                    <option value="530915">BAJAWA UTARA</option>
                                                    <option value="530916">WOLOMEZE</option>
                                                    <option value="530918">GOLEWA SELATAN</option>
                                                    <option value="530919">GOLEWA BARAT</option>
                                                </select>
                                                </select>
                                            </div>
                                            <div class="form-group mb-5">
                                                <label class="fw-bold" id="lbl-kddesa">Desa</label>
                                                <select name="kddesa" class="form-select select2" id="kddesa">
                                                    <option value="">-Pilih Desa-</option>
                                                    <option value="5309072004">MASUMELI</option>
                                                    <option value="5309072008">SESO</option>
                                                    <option value="5309072011">MASU KEDHI</option>
                                                    <option value="5309072013">MELI WARU</option>
                                                    <option value="5309072014">NGABHEO</option>
                                                    <option value="5309072017">PIGA SATU</option>
                                                </select>
                                            </div>
                                        </section>
                                    </div>
                                </div>


                            </div>
                            <div class="card-footer">
                                <button class="btn btn-primary float-end" id="btn-save">
                                    <i class="fa fa-save"></i> Simpan
                                </button>
                            </div>
                        </div>
                    </section>
                </form>

                <div id="content-alert" class="d-none mt-10">
                    <div class="alert alert-dismissible bg-primary d-flex flex-column flex-sm-row p-5 mb-10">
                        <span class="fa fa-info fa-3x text-light"></span>
                        <div class="d-flex flex-column text-light pe-0 pe-sm-10">
                            <h4 class="mb-2 ms-5 text-light">Informasi</h4>
                            <div class="ms-5">
                                Maaf Pendaftaran Pengguna TEKAD sudah ditutup. Terima Kasih.
                            </div>
                        </div>

                        <!--begin::Close-->
                        <a href="https://alfanumerik-lab.com/tekad_2023/monev/login" type="button"
                            class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto"
                            data-bs-dismiss="alert">
                            <i class="fa fa-times fa-3x text-light"></i>
                        </a>
                        <!--end::Close-->
                    </div>
                </div>
            </div>
        </div>

    </div>




</body>
<!--end::Body-->

</html>
