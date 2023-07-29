<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class GenerateNota extends BaseController
{
    public function __construct($arr_warga = [], $arr_harga = [], $arr_warga_harga = [], $arr_usaha = [], $arr_usaha_harga = [])
    {
        $file_urunan_sampah = fopen("list warga.txt", "r") or die("Unable to open file!");
        $file_usaha = fopen("list usaha.txt", "r") or die("Unable to open file!");
        $formatNumber = new \NumberFormatter("id", \NumberFormatter::SPELLOUT);

        while(!feof($file_urunan_sampah)) {
            $simpan = fgets($file_urunan_sampah);
            $this->arr_warga_harga[] = $simpan;

            $value = explode("=>", trim($simpan));
            if(count($value) == 1) continue;

            $this->arr_warga[] = $value[0];
            if(gettype($value[1]) == "string") $this->arr_harga["urunan_sampah"][] = ["number" => $value[1], "spell_out" => $formatNumber->format($value[1])];
        }
        fclose($file_urunan_sampah);

        while(!feof($file_usaha)) {
            $simpan = fgets($file_usaha);
            $this->arr_usaha_harga[] = $simpan;

            $value = explode("=>", trim($simpan));
            if(count($value) == 1) continue;

            $this->arr_usaha[] = $value[0];
            if(gettype($value[1]) == "string") $this->arr_harga["usaha"][] = ["number" => $value[1], "spell_out" => $formatNumber->format($value[1])];
        }
        fclose($file_usaha);

        helper("form");
    }

    public function index()
    {
        return view("generate-nota/index", [
            "arr_warga" => $this->arr_warga_harga,
            "arr_usaha" => $this->arr_usaha_harga
        ]);
    }

    public function notaPdf()
    {
//        jika deskripsi nota lebih dari 80 karakter, maka kembalikan error
        if(strlen($this->request->getPost("description")) > 80) {
            return redirect()->to("/generate-nota")->with("error", "Deskripsi nota tidak boleh lebih dari 80 karakter");
        }

        $dataDigunakan = $this->request->getPost("data_type");
        $deskripsiNota = $this->request->getPost("description");
        $arrDesc = explode(" ", $deskripsiNota);

        $baris1 = "";
        $baris2 = "";
        $baris3 = "";

        foreach($arrDesc as $desc) {
            if(strlen($baris1) + strlen($baris1) < 30) {
                $baris1 .= $desc . " ";
            } else if(strlen($baris2) + strlen($baris2) < 30) {
                $baris2 .= $desc . " ";
            } else if(strlen($baris3) + strlen($baris3) < 20) {
                $baris3 .= $desc . " ";
            }
        }

        $dataView = [
            "arr" => $dataDigunakan == "sampah" ? $this->arr_warga : $this->arr_usaha,
            "arr_harga" => $dataDigunakan == "sampah" ? $this->arr_harga["urunan_sampah"] : $this->arr_harga["usaha"],
            "deskripsiNota" => $deskripsiNota,
            "baris1" => $baris1,
            "baris2" => $baris2,
            "baris3" => $baris3
        ];

        $option = new \Dompdf\Options();
        $option->setIsRemoteEnabled(true);
        $option->setChroot($_SERVER["DOCUMENT_ROOT"]);
        $option->setFontDir(
            $_SERVER["DOCUMENT_ROOT"] . "/fonts"
        );

        // generate nota by dompdf
        $dompdf = new \Dompdf\Dompdf($option);

        $dompdf->set_option('isHtml5ParserEnabled', true);
        $dompdf->loadHtml(view("generate-nota/nota-pdf", $dataView));
        $dompdf->setPaper("A4", "potrait");
        $dompdf->getOptions()->set('defaultFont', 'fonts/Sofia-Regular.ttf');
        $dompdf->render();
        $dompdf->stream("nota.pdf");
    }

    public function updateWarga()
    {
        $strFile = "";
        $arrNamaWarga = explode("\n", $this->request->getPost("nama_warga"));

        foreach($arrNamaWarga as $nama) {
            if(preg_match('/^\s*$/', $nama)) continue;

//            if(!preg_match('/^\s*=>\s*\d+\s*$/', $nama)) {
//                if(!preg_match('/=>\s*\d+/', $nama)) {
//                    return redirect()->to("/generate-nota")->with("error", "Pastikan formatnya seperti ini:<br> Nama Warga => Harga")->with("title", "Format list warga salah!");
//                }
//                $strFile .= $nama . "\n";
//            }

//            if(!preg_match('/^(?:\p{L}+\s*[.,()]*\s*)*\p{L}+\s*(?:\(\d+\))?\s*=>\s*\d+\s*$/u', $nama)) {
//                var_dump($nama);die();
            if(!preg_match('/=>\s*\d+/', $nama)) {
                return redirect()->to("/generate-nota")->with("error", "Pastikan formatnya seperti ini:<br> Nama Warga => Harga")->with("title", "Format list warga salah!");
            }
            $strFile .= $nama . "\n";
        }

        $myfile = fopen("list warga.txt", "w") or die("Unable to open file!");
        fwrite($myfile, $strFile);
        fclose($myfile);

        session()->setFlashdata("success", "Berhasil update list warga");
        return redirect()->to("/");
    }

    public function updateUsaha()
    {
        $strFile = "";
        $arrNamaUsaha = explode("\n", $this->request->getPost("nama_usaha"));

        foreach($arrNamaUsaha as $nama) {
            if(preg_match('/^\s*$/', $nama)) continue;

            if(!preg_match('/=>\s*\d+/', $nama)) {
                return redirect()->to("/generate-nota")->with("error", "Pastikan formatnya seperti ini:<br> Nama Warga => Harga")->with("title", "Format list warga salah!");
            }
            $strFile .= $nama . "\n";

//            if(!preg_match('/=>\s*\d+/', $nama)) { // ini true kalau string kosong
//                if(!preg_match('/^(?!\s*$)\w+\s*\d+\s*=>\s*\d+$/', $nama)) { // ini false kalau string kosong
//                    var_dump($nama . " salah", preg_match('/^(?:(?!\s*$).)*\w+\s*\d+\s*=>\s*\d+$/', $nama));
//                    die();
//                    return redirect()->to("/generate-nota")->with("error", "Pastikan formatnya seperti ini:<br> Nama Usaha => Harga")->with("title", "Format list usaha salah!");
//                }
//                $strFile .= $nama . "\n";
//            }
        }

        $myfile = fopen("list usaha.txt", "w") or die("Unable to open file!");
        fwrite($myfile, $strFile);
        fclose($myfile);

        session()->setFlashdata("success", "Berhasil update list usaha");
        return redirect()->to("/");
    }
}
