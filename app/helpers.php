<?php
    if (! function_exists('numberFormatIndo')) {
        function numberFormatIndo($value, $decimal = 0) {
            return number_format($value, $decimal, ',', '.');
        }
    }

    if (! function_exists('terbilang')) {
        function terbilang($nilai) {
            if($nilai<0) {
                $hasil = "minus ". trim(penyebut($nilai));
            } else {
                $hasil = trim(penyebut($nilai));
            }
            return $hasil;
        }
    }

    if (! function_exists('penyebut')) {
        function penyebut($nilai) {
            $nilai = abs($nilai);
            $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
            $temp = "";
            if ($nilai < 12) {
                $temp = " ". $huruf[$nilai];
            } else if ($nilai <20) {
                $temp = penyebut($nilai - 10). " belas";
            } else if ($nilai < 100) {
                $temp = penyebut($nilai/10)." puluh". penyebut($nilai % 10);
            } else if ($nilai < 200) {
                $temp = " seratus" . penyebut($nilai - 100);
            } else if ($nilai < 1000) {
                $temp = penyebut($nilai/100) . " ratus" . penyebut($nilai % 100);
            } else if ($nilai < 2000) {
                $temp = " seribu" . penyebut($nilai - 1000);
            } else if ($nilai < 1000000) {
                $temp = penyebut($nilai/1000) . " ribu" . penyebut($nilai % 1000);
            } else if ($nilai < 1000000000) {
                $temp = penyebut($nilai/1000000) . " juta" . penyebut($nilai % 1000000);
            } else if ($nilai < 1000000000000) {
                $temp = penyebut($nilai/1000000000) . " milyar" . penyebut(fmod($nilai,1000000000));
            } else if ($nilai < 1000000000000000) {
                $temp = penyebut($nilai/1000000000000) . " trilyun" . penyebut(fmod($nilai,1000000000000));
            }
            return $temp;
        }
    }

    if (! function_exists('snakeCaseToCamelCase')) {
        function snakeCaseToCamelCase($string) {
            return lcfirst(str_replace('_', '', ucwords($string, '_')));
        }
    }

    if (! function_exists('stringHasChar')) {
        function stringHasChar($string, $array, $toLower = false) {
            foreach ($array as $a) {
                if($toLower) {
                    if (strpos(strtolower($string), strtolower($a)) !== FALSE) {
                        return true;
                    }
                } else {
                    if (strpos($string, $a) !== FALSE) {
                        return true;
                    }
                }
            }

            return false;
        }
    }

    if (! function_exists('bulanReplace')) {
        function bulanReplace($string)
        {
            $search = [];
            for ($i = 1;$i <= 12; $i++) {
                $search[] = \Carbon\Carbon::createFromFormat('n', $i)->format('F');
            }
            $replace = ['Januari', 'Febuari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

            return str_replace($search, $replace, $string);
        }
    }