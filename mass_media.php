<?php
require('./db.php');
$db = new DB('localhost','root','root','mass_media');
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
    list($date,$content,$id,$annonce,,$title,,,$year) = $arr;
    $date = date('20y-m-d', $date);
    $template = " 
    INSERT INTO `new`(`id`,`Title`, `Date`, `Post Type`, 
                      `Рубрики`, `content_visible`, `Status`, 
                      `Author ID`, `Author Username`, `Author Email`, `Parent`, 
                      `Parent Slug`, `Order`, `Comment Status`, `Ping Status`, `Post Modified Date`) 
    VALUES             ($id,'$title','$date','post','$year',
                        '$content','publish','1','admin','i-nominator@yandex.ru',
                        '0','0','0','open','open',
                        '2023-08-26')";
    return $template;
}

//echo '<pre>';
//print_r ($id);
//echo '</pre>';
