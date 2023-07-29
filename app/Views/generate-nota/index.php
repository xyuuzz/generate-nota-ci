<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Generate Nota</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@9.17.2/dist/sweetalert2.min.css">
    <style>
        label {
            font-weight: bold;
            font-size: 18px;
        }
        .form-check-label {
            font-weight: normal;
        }
        .btn-sm {
            height: 20px;
            display: flex;
            align-items: center;
            font-weight: bold;
            font-size: 20px;
            padding-bottom: 10px;
        }
        .btn-outline-secondary {
            padding-top: 7px;
        }


    /*    breakpoint large*/
        @media (min-width: 992px) {
            .d-grid {
                display: block !important;
            }
            .container-fluid {
                width: 90%;
            }
        }
    /*    breakpoint small */
        @media (max-width: 991px) {
            .container-fluid {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="my-5">
        <h2 class="text-center">APLIKASI GENERATE NOTA TAMBAK BOYO LOR </h2>
        <p class="text-center">
            <img width="250px" class="img-thumbnail shadow-lg" src="<?=base_url('images/bg-tambak-boyo-lor.png')?>" alt="background tambak boyo lor">
        </p>
    </div>
    <br>

    <div class="container">
        <div class="card">
            <div class="card-header">
                <h4 class="text-center">Form Generate Nota</h4>
            </div>
            <div class="card-body">
                <form action="<?=base_url('nota-pdf')?>" method="post">
                    <label class="mb-2" for="description">Deskripsi Pembayaran pada Nota:  (Max 80 Huruf)</label>
                    <input required max="80" maxlength="80" type="text" name="description" id="description" class="form-control mb-3">
                    <label for="">Data yang akan digunakan : </label>
                    <div class="d-lg-flex gap-3 mt-2">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="data_type" value="sampah" id="sampah">
                            <label class="form-check-label" for="sampah">
                                Sampah warga
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="data_type" value="usaha" id="usaha">
                            <label class="form-check-label" for="usaha">
                                Pembayaran usaha
                            </label>
                        </div>
                    </div>
                    <hr>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Cetak</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row justify-content-center gap-3">
            <div class="col-lg-5">
                <div class="card" style="margin-top: 60px">
                <div class="card-header">
                    <h4 class="text-center">Listing Warga dan Harga Bayar Sampah</h4>
                </div>
                <div class="card-body">
                    <form action="<?=base_url('update-list-warga')?>" method="post">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <label for="nama_warga">Format : (warga => harga) </label>
                            <div class="d-flex align-items-center gap-2">
                                <div onclick="minusFontSize('warga')" class="btn btn-sm btn-outline-warning">-</div>
                                <span>Ukuran Huruf <span class="font-size-warga">16</span></span>
                                <div onclick="plusFontSize('warga')" class="btn btn-sm btn-outline-secondary">+</div>
                            </div>
                        </div>
                        <textarea class="form-control" name="nama_warga" id="nama_warga" cols="30" rows="10">
<?php
foreach ($arr_warga as $nama) {
    echo $nama;
}
?>
                            </textarea>
                        <br>
                        <button type="submit" class="btn btn-primary">Perbarui</button>
                    </form>
                </div>
            </div>
            </div>
            <div class="col-lg-5">
                <div class="card" style="margin-top: 60px">
                    <div class="card-header">
                        <h4 class="text-center">Listing Pembayaran Usaha, Kost dan Ruko serta Harganya</h4>
                    </div>
                    <div class="card-body">
                        <form action="<?=base_url('update-list-usaha')?>" method="post">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <label for="nama_usaha">Format : (usaha => harga) </label>
                                <div class="d-flex align-items-center gap-2">
                                    <div onclick="minusFontSize('usaha')" class="btn btn-sm btn-outline-warning">-</div>
                                    <span>Ukuran Huruf <span class="font-size-usaha">16</span></span>
                                    <div onclick="plusFontSize('usaha')" class="btn btn-sm btn-outline-secondary">+</div>
                                </div>
                            </div>
                            <textarea class="form-control" name="nama_usaha" id="nama_usaha" cols="30" rows="10">
<?php
foreach ($arr_usaha as $usaha) {
    echo $usaha;
}
?>
                            </textarea>
                            <br>
                            <button type="submit" class="btn btn-primary">Perbarui</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <hr>
        <br>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9.17.2/dist/sweetalert2.min.js"></script>

    <script>
        $(function(){

            <?php if(session()->has("success")) { ?>
            Swal.fire({
                icon: 'success',
                title: '<?= session("title") ?? 'Great!' ?>',
                html: '<?= session("success") ?>'
            })
            <?php } ?>

            <?php if(session()->has("error")) { ?>
            Swal.fire({
                icon: 'error',
                title: '<?= session("title") ?? 'Oops...' ?>',
                html: '<?= session("error") ?>'
            })
            <?php } ?>
        });

        $("#description").on("keyup", function(){
            let value = $(this).val();
            if(value.length == 80) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    html: 'Maksimal 80 karakter atau Huruf (termasuk spasi)'
                })
            }
        });

        function plusFontSize(type) {
            let fontSize = $("#nama_" + type).css("font-size");
            fontSize = parseInt(fontSize);
            fontSize += 2;
            $("#nama_" + type).css("font-size", fontSize);
            $(".font-size-" + type).html(fontSize);
        }

        function minusFontSize(type) {
            let fontSize = $("#nama_" + type).css("font-size");
            fontSize = parseInt(fontSize);
            fontSize -= 2;
            $("#nama_" + type).css("font-size", fontSize);
            $(".font-size-" + type).html(fontSize);
        }
    </script>
</body>
</html>