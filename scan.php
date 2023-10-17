<?php
$i = 0;
function getDirContents($dir) {
    $files = scandir($dir);

    foreach ($files as $key => $value) {
        $path = realpath($dir . DIRECTORY_SEPARATOR . $value);
        if (!is_dir($path)) {
            if (preg_match('/png/', $value) || preg_match('/jpg/', $value) || preg_match('/gif/', $value)) {
                copy($path,"img/$value");
                $i++;
                echo 'Файл '.$value.' успешно перенесен, всего перенесено: '."$value".'\n';
            }
        } else if ($value != "." && $value != "..") {
            getDirContents($path);
        }
    }
}

getDirContents('rezero');