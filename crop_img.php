<?php

function crop_img ($img_name) {
    $prefix= __DIR__.'/18/';


    $filename=$prefix.$img_name;


    $isize = getimagesize($filename);


    $width = 150;
    $dsp = 10;
    $vdsp = 10;
    $dsp = 0;
    $vdsp = 0;
    if ($isize[0]>$isize[1]){
        $otn        = $width/$isize[0];
        $new_height = intval($isize[1] * $otn);

        $thumb = imagecreatetruecolor($width, $new_height);


        if ($isize[2]==1) $source = imagecreatefromgif($filename);
        if ($isize[2]==2) $source = imagecreatefromjpeg($filename);
        if ($isize[2]==3) $source = imagecreatefrompng($filename);


        imagecopyresampled($thumb, $source, 0, 0, 0, 0, $width, $new_height, $isize[0], $isize[1]);

        $st = intval(($width - $new_height)/2)+$dsp;

        $dest = imagecreatetruecolor($width,$width);
        $color = imagecolorallocate ($thumb, 255, 240, 215);
        imagefill($dest,0,0,$color);
        imagecopyresampled($dest, $source, 0, $st, 0, 0, $width, $new_height, $isize[0], $isize[1]);
    }
    else
    {
        $otn = $width/$isize[1];
        $new_width  = intval($isize[0] * $otn);

        $thumb = imagecreatetruecolor($new_width,$width);

        if ($isize[2]==1) $source = imagecreatefromgif($filename);
        if ($isize[2]==2) $source = imagecreatefromjpeg($filename);
        if ($isize[2]==3) $source = imagecreatefrompng($filename);
        imagecopyresampled($thumb, $source, 0, 0, 0, 0, $new_width, $width, $isize[0], $isize[1]);
        $st = intval(($width - $new_width)/2)+$dsp;
        $dest = imagecreatetruecolor($width,$width);
        $color = imagecolorallocate ($thumb, 255, 240, 215);
        imagefill($dest,0,0,$color);

        @imagecopyresampled($dest, $source, 0, 0, 0, 0, $new_width, $width, $isize[0], $isize[1]);

    }
    imagejpeg($dest, "19/$img_name",100);
}

$files = scandir(__DIR__.'/18/');
$i = 0;
$errors = array();

foreach ($files as $key => $value) {
    if ($value != "." && $value != ".." && $value !== '.DS_Store') {
        try {
            crop_img($value);
            $i++;
            echo "Успешно скопирован файл $value $i\n";

        } catch (Exception $e) {
            $errors[] = $value;
            echo "Ошибка в копировании файла $value\n";
            continue;
        }
    }

}
p($errors);

function p($msg) {
    echo '<pre>';
    print_r($msg);
    echo '</pre>';
}
