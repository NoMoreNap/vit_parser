<?php
require('./db.php');
$db = new DB('localhost:3307','root','123','lui1');

$errors = array();
try {
    $all = "SELECT * FROM old";
    $all = mysqli_fetch_all($db->query($all),1);
    $i = 1;
    $k = 0;
    $sql = "delete from new";
    $db->query($sql);
    foreach ($all as $item) {
        $sql = getSqlRequest($item);
        if(!$sql) {
            $k++;
            continue;
        }
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
    echo $k;

} catch(Exception $error) {
    echo $error;
};

//foreach ($errors as $error) {
//    echo $error['id']."\n";
//}

function getSqlRequest($data) {
    $arr = array();
    foreach ($data as $item => $value) {
        $arr[] = $value;
    }
    // SELECT * FROM `old` WHERE author = '' and `artist` = '' and `artist2` = '' and `artist3` = '' and `artist4` = ''
    list($id,,$isbn,$name,$author,,$artist,,$artist2,,$artist3,,$artist4,,,,$s_disc,$disc,,,$photo,$price,$s_price,$category,,,$link,,$pages,$year,,$images,,,,,,$tirage,,,,,$title,$keywords,$description) = $arr;
    $quth_db = new DB('localhost:3307','root','123','transfer');
    $sql_get_author = 'SELECT name from cat2auths where cat_id ='.$id;
    $author = $author == '' ? (count(mysqli_fetch_all($quth_db->query($sql_get_author),1)) ? mysqli_fetch_all($quth_db->query($sql_get_author),1)[0]['name'] : '') : $author;
    $parsedInfo = getParse($category);
    $category = $parsedInfo[0];
    $link = $parsedInfo[1].$link.'/';

    // META
    $meta_year = 'field_6501fd7be8a5e';
    $meta_isbn = 'field_6501fdd5e8a5f';
    $meta_editions = 'field_6501fdf3e8a60';
    $meta_specs_volumes_0_pages = 'field_6501fe5fe8a62';
    $meta_author = 'field_6501fc85e8a5a';
    $meta_specs_volumes = 'field_6501fe24e8a61';
    $meta_specs = 'field_6501fd48e8a5d';
    $meta_details = 'field_6502050bf0e52';
    $meta_artist = 'field_6525139a39a69';
    $meta_seo_title = 'field_64f20237ffe89';
    $meta_seo_keywords = 'field_64f2027affe8b';
    $meta_seo_description = 'field_64f20250ffe8a';
    //
    if (!$photo) {
        return false;
    }
    $s_price = $s_price == 0 ? '' : $s_price;
    $title = $title ? $title : $name;
    $template = "INSERT INTO `new`
    (`ID`, `Тип`, `Имя`, `Опубликован`, `Рекомендуемый?`, `Видимость в каталоге`, `Краткое описание`, 
     `Статус налога`, `В наличии?`, `Возможен ли предзаказ?`, `Продано индивидуально?`, `Разрешить отзывы от клиентов?`, 
     `Акционная цена`, `Базовая цена`, `Категории`, `Изображения`, `Позиция`,
     `Мета: author`,`Мета: specs_year`,
     `Мета: specs_isbn`,`Мета: specs_edition`,`Мета: specs_volumes`, 
     `Мета: specs`,`Мета: details`, `Мета: specs_volumes_0_pages`, `Мета: specs_volumes_0_pictures`, `Мета: seo_keywords`, `Мета: seo_description`, `Мета: seo_title`
     ,`Мета: custom_permalink`,  `Мета: _specs_year`,
  `Мета: _specs_isbn`,
  `Мета: _specs_edition`,
  `Мета: _specs_volumes_0_pages`,
  `Мета: _author`,
  `Мета: _specs_volumes`,
  `Мета: _specs`,
  `Мета: _details`,
  `Мета: _artist`,
  `Мета: _seo_title`,
  `Мета: _seo_keywords`,
  `Мета: _seo_description`) VALUES 
    ('$id','simple','$name','1','0','visible','$s_disc','taxable','1','0','0','1','$s_price','$price','$category','$photo','0',
     '$author','$year','$isbn','$tirage','1','','$disc','$pages','$images','$keywords','$description', '$title', '$link','$meta_year',
'$meta_isbn',
'$meta_editions',
'$meta_specs_volumes_0_pages',
'$meta_author',
'$meta_specs_volumes',
'$meta_specs',
'$meta_details',
'$meta_artist',
'$meta_seo_title',
'$meta_seo_keywords',
'$meta_seo_description')";
    return $template;
}

function getParse($category) {
    switch ($category) {
        case '182':
            return ['Новые поступления', 'katalog/new'];
        case '128':
            return ['Тиражные издания > Парадный зал', 'katalog/tirazhnie_izdaniya/paradniy_zal/'];
        case '52':
            return ['Тиражные издания > Будуар','katalog/tirazhnie_izdaniya/buduar/'];
        case '19':
            return ['Тиражные издания > Читальный зал','katalog/tirazhnie_izdaniya/chitalniy_zal/'];
        case '20':
            return ['Тиражные издания > Волшебный зал','katalog/tirazhnie_izdaniya/volshebniy_zal/'];
        case '17':
            return ['Тиражные издания > Рукописи','katalog/tirazhnie_izdaniya/rukopisi/'];
        case '201':
            return ['Тиражные издания > Священные тексты','katalog/tirazhnie_izdaniya/svyachshennie_teksti/'];
        case '138':
            return ['Тиражные издания > Философский зал','katalog/tirazhnie_izdaniya/filosofskiy_zal/'];
        case '51':
            return ['Тиражные издания > Героический зал','katalog/tirazhnie_izdaniya//'];
        case '16':
            return ['Тиражные издания > Жизнеописания','katalog/tirazhnie_izdaniya/geroicheskiy_zal/'];
        case '53':
            return ['Тиражные издания > Малый зал','katalog/tirazhnie_izdaniya/maliy_zal/'];
        case '202':
            return ['Тиражные издания > Библиотека великих писателей','katalog/tirazhnie_izdaniya/biblioteka_velikih_pisateley/'];
        case '56':
            return ['Тиражные издания > Отдельные издания','katalog/tirazhnie_izdaniya/otdelnie_izdaniya/'];
        case '55':
            return ['Тиражные издания > Детский зал','katalog/tirazhnie_izdaniya/detyam/'];
        case '54':
            return ['Тиражные издания > Книга художника','katalog/tirazhnie_izdaniya/kniga_hudozhnika/'];
        case '234':
            return ['Тиражные издания > Новая Библиотека поэта','katalog/tirazhnie_izdaniya/novaya_biblioteka_poeta/'];
        case '58':
            return ['Тиражные издания > Альбомы','katalog/tirazhnie_izdaniya/albomi/'];
        case '57':
            return ['Тиражные издания > Варварская лира','katalog/tirazhnie_izdaniya/varvarskaya_lira/'];

        case '68':
            return ['Нумерованные издания > Парадный зал','katalog/numerovannie_izdaniya/paradniy_zal/'];
        case '69':
            return ['Нумерованные издания > Читальный зал','katalog/numerovannie_izdaniya/chitalniy_zal/'];
        case '72':
            return ['Нумерованные издания > Будуар','katalog/numerovannie_izdaniya/buduar/'];
        case '70':
            return ['Нумерованные издания > Волшебный зал','katalog/numerovannie_izdaniya/volshebniy_zal/'];
        case '67':
            return ['Нумерованные издания > Рукописи','katalog/numerovannie_izdaniya/rukopisi/'];
        case '73':
            return ['Нумерованные издания > Малый зал','katalog/numerovannie_izdaniya/maliy_zal/'];
        case '71':
            return ['Нумерованные издания > Героический зал','katalog/numerovannie_izdaniya/geroicheskiy_zal/'];
        case '47':
            return ['Нумерованные издания > Отдельные издания','katalog/numerovannie_izdaniya/otdelnie_izdaniya/'];
        case '74':
            return ['Нумерованные издания > Внесерийные издания','katalog/numerovannie_izdaniya/vneseriynie_izdaniya/'];
        case '139':
            return ['Нумерованные издания > Философский зал','katalog/numerovannie_izdaniya/filosofskiy_zal/'];
        case '226':
            return ['Нумерованные издания > Священные тексты','katalog/numerovannie_izdaniya/svyachshennie_teksti/'];

        case '13':
            return ['Авторский переплет','katalog/avtorskiy_pereplet/'];

        case '149':
            return ['Арт-проекты > Графика','katalog/art_proekti/grafika/'];
        case '160':
            return ['Арт-проекты > Отдельные проекты','katalog/art_proekti/otdelnie_proekti/'];
        case '59':
            return ['Арт-проекты > Фарфор','katalog/art_proekti/farfor/'];

        case '15':
            return ['Сувениры','katalog/suveniri/'];

        case '':
            return ['','katalog/'];

        case '127':
            return ['Графика','katalog/tirazhnie_izdaniya/'];

        case '229':
            return ['Библиотека великих писателей','katalog/biblioteka_velikih_pisateley/'];

        case '188':
            return ['Библиотека великих произведений','katalog/biblioteka_velikih_proizvedeniy/'];

//        case '312':
//            return 'Планы издательства 2020';
//
//        case '':
//            return '';
        default:
            return ['Misc','katalog/misc/'];
    }
}

//echo '<pre>';
//print_r ($id);
//echo '</pre>';
