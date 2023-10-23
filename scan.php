<?php
require('./db.php');

function getDirContents($dir, $i) {
    $files = scandir($dir);
    $db = new DB('localhost','root','root','convert');

    foreach ($files as $key => $value) {
        $path = realpath($dir . DIRECTORY_SEPARATOR . $value);
        if (!is_dir($path)) {
            if (preg_match('/png/', $value) || preg_match('/jpg/', $value) || preg_match('/gif/', $value)) {
                //
                $isize = getimagesize($path);
                if($isize[0] == $isize[1]) {
                    continue;
                }

                $sql = "select id from new where `Изображения` = 'http://localhost:8888/wp-content/uploads/2023/19/$value'";
                $is_exist = mysqli_fetch_all($db->query($sql),1);
                if (boolval($is_exist)) {
                    $i++;
                    copy($path,"18/$value");
                    echo 'Файл '.$value.' успешно перенесен, всего перенесено: '."$i"."\n";
                }
                //;
            }
        } else if ($value != "." && $value != "..") {
            getDirContents($path, $i);
        }
    }
}


getDirContents('img/catalog', 0);