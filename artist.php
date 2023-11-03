<?php
require('./db.php');
$db = new DB('localhost','root','root','artists');
$filename = __DIR__ . '/books.csv';

$errors = array();
try {
    $all = "SELECT * FROM old";
    $all = mysqli_fetch_all($db->query($all),1);
    $i = 1;
    $sql = "delete from new";
    $db->query($sql);
    foreach ($all as $item) {
        $sql = getSqlRequest($item);
        $request = $db->insert($sql);
        if ($request) {
            echo 'Успешно перенесена запись с ID: '.$item['id'].' Всего перенесено: '.$i.'/'.count($all)."\n";
            $i++;
//          break;
        } else {
            echo 'Ошибка переноса записи с ID: '.$item['id'].' Всего перенесено: '.$i."\n";
            $errors[] = $item;
        }
    }

} catch(Exception $error) {
    echo $error;
};

foreach ($errors as $error) {
    echo $error['id']."\n";
}

function getSqlRequest($data) {
    $arr = array();
    foreach ($data as $item => $value) {
        $arr[] = $value;
    }
    list($id,$name,$fullname,$descr, $photo,$is_au,$is_art,$alte,$visible) = $arr;
    $date = date('20y-m-d', time());
    $template = " 
    INSERT INTO `new`(`ID`,`Title`, `Content`, `Excerpt`, 
                      `Date`, `Post Type`, `about_0_paragraph`) 
    VALUES             ($id,'$name','','','$date',
                        'artist','$descr')";
    return $template;
}

//echo '<pre>';
//print_r ($id);
//echo '</pre>';
