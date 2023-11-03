<?php
require('./db.php');
$db = new DB('localhost','root','root','convert');
const DOMEN = 'http://localhost:8888';

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
    list($id,,$isbn,$name,$author,,,,,,,,,,,,$s_disc,$disc,,,$photo,$price,$s_price,$category,,,$link,,$pages,$year,,$images,,,,,,$tirage,,,,,$title,$keywords,$description) = $arr;
    $category = getCategory($category);
//    $photo = $photo ? "wp-content/uploads/2023/20/$photo" : '';
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
     `Мета: specs`,`Мета: details`, `Мета: specs_volumes_0_pages`, `Мета: specs_volumes_0_pictures`, `Мета: seo_keywords`, `Мета: seo_description`, `Мета: seo_title`) VALUES 
    ('$id','simple','$name','1','0','visible','$s_disc','taxable','1','0','0','1','$s_price','$price','$category','$photo','0',
     '$author','$year','$isbn','$tirage','1','','$disc','$pages','$images','$keywords','$description', '$title')";
    return $template;
}

function getCategory($category) {
    switch ($category) {
        case '182':
            return 'Новые поступления';
        case '128':
            return 'Тиражные издания > Парадный зал';
        case '52':
            return 'Тиражные издания > Будуар';
        case '19':
            return 'Тиражные издания > Читальный зал';
        case '20':
            return 'Тиражные издания > Волшебный зал';
        case '17':
            return 'Тиражные издания > Рукописи';
        case '201':
            return 'Тиражные издания > Священные тексты';
        case '138':
            return 'Тиражные издания > Философский зал';
        case '51':
            return 'Тиражные издания > Героический зал';
        case '16':
            return 'Тиражные издания > Жизнеописания';
        case '53':
            return 'Тиражные издания > Малый зал';
        case '202':
            return 'Тиражные издания > Библиотека великих писателей';
        case '56':
            return 'Тиражные издания > Отдельные издания';
        case '55':
            return 'Тиражные издания > Детский зал';
        case '54':
            return 'Тиражные издания > Книга художника';
        case '234':
            return 'Тиражные издания > Новая Библиотека поэта';
        case '58':
            return 'Тиражные издания > Альбомы';
        case '57':
            return 'Тиражные издания > Варварская лира';

        case '68':
            return 'Нумерованные издания > Парадный зал';
        case '69':
            return 'Нумерованные издания > Читальный зал';
        case '72':
            return 'Нумерованные издания > Будуар';
        case '70':
            return 'Нумерованные издания > Волшебный зал';
        case '67':
            return 'Нумерованные издания > Рукописи';
        case '73':
            return 'Нумерованные издания > Малый зал';
        case '71':
            return 'Нумерованные издания > Героический зал';
        case '47':
            return 'Нумерованные издания > Отдельные издания';
        case '74':
            return 'Нумерованные издания > Внесерийные издания';
        case '139':
            return 'Нумерованные издания > Философский зал';
        case '226':
            return 'Нумерованные издания > Священные тексты';

        case '13':
            return 'Авторский переплет';

        case '149':
            return 'Арт-проекты > Графика';
        case '160':
            return 'Арт-проекты > Отдельные проекты';
        case '59':
            return 'Арт-проекты > Фарфор';

        case '15':
            return 'Сувениры';

        case '':
            return '';

        case '127':
            return 'Графика';

        case '229':
            return 'Библиотека великих писателей';

        case '188':
            return 'Библиотека великих произведений';

//        case '312':
//            return 'Планы издательства 2020';
//
//        case '':
//            return '';
        default:
            return 'Misc';
    }
}

//echo '<pre>';
//print_r ($id);
//echo '</pre>';
