<!--get base64 of template nota image-->
<?php
$nota = file_get_contents("images/template-nota.jpeg");
$nota = base64_encode($nota);
//data:image/jpeg;base64,<?=$nota
?>
<style>
    @font-face {
        font-family: 'Sofia';
        src: url('fonts/Sofia-Regular.ttf');
    }
    p,span {

        font-family: 'Sofia', cursive;
    }

</style>

<?php for($i=0; $i<count($arr); $i++): ?>
    <div style="position: relative">
        <img style="width: 90%; transform: rotate(180deg)" src="images/template-nota.jpeg">
        <div>
            <b><p style="position: absolute; top: 7px; left: 320px; font-size: 20px"><?=$arr[$i]?></p></b>
            <p style="position: absolute; top: 26px; left: 275px; font-size: 24px"><span style="margin-right: 20px">Rp. </span><?=$arr_harga[$i]["number"]?>.000</p>
            <b><p style="position: absolute; top: 85px; left: 275px; font-size: 20px"><?=$baris1?></p></b>
            <?php if(strlen($baris2) > 0): ?>
                <b><p style="position: absolute; top: 115px; left: 275px; font-size: 20px"><?=$baris2?></p></b>
            <?php endif; ?>
            <?php if(strlen($baris3) > 0): ?>
                <b><p style="position: absolute; top: 143px; left: 275px; font-size: 20px"><?=$baris3?></p></b>
            <?php endif; ?>
            <p style="position: absolute; top: 202px; left: 270px; font-size: 20px"><?=ucfirst($arr_harga[$i]["spell_out"])?> Ribu Rupiah</p>
        </div>
    </div>
    <hr>
<?php endfor; ?>

