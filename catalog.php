<?php
require('./db.php');

const MAIN_HOST = 'https://vitanova.ru/';
$db = new DB('localhost','root','root','convert');

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
        // if ($sql == -1) {
        //     continue;
        // }
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
    list($id,,$isbn,$name,$author,,$artist,,$artist2,,$artist3,,$artist4,,,,$s_disc,$disc,,,$photo,$price,$s_price,$category,,,$link,,$pages,$year,,$images,,$type,,,,$tirage,,,,,$title,$keywords,$description) = $arr;
    // if($name !== 'ПОТЕРЯННЫЙ РАЙ') {
    //     return false;
    // }

    $quth_db = new DB('localhost','root','root','vitanova2');

    $about_book = "SELECT * FROM `text_blocks` WHERE catalog_id = $id ORDER by pos ASC";

    // if($id !== '3363') {
    //     return false;
    // }


    $db = new DB('localhost','root','root','convert');
        $all = mysqli_fetch_all($quth_db->query($about_book),1);
        list($tir,$num,$auth,$bible,
        $from_translater_small,$about_artist_small,$from_translater,$about_artist,$show_book_url,
        $add_info_0_caption, $add_info_1_caption, $any_text) = ['','','','','','','','','', '', '', []];
        $add_info_len = count($all);
        $add_infos = "";
        $add_info_values = "";


        if (count($all) > 0) {
            

            
            foreach($all as $item) {
                if ($item['name'] == 'ОТ ПЕРЕВОДЧИКА') {
                    $from_translater_small = $item['short_value'];
                    $from_translater = $item['value'];
                    $add_info_1_caption = 'ОТ ПЕРЕВОДЧИКА';
                }
                if ($item['name'] == 'О ХУДОЖНИКЕ') {
                    $about_artist_small = $item['short_value'];
                    $about_artist = $item['value'];
                    $add_info_0_caption = 'О ХУДОЖНИКЕ';
    
                }
                if (preg_match('/О ХУДОЖНИКЕ/', $item['short_value'])){
                    if (strpos($item['short_value'], 'О ХУДОЖНИКЕ</span></a></p>') !== false) {
                        if((strpos($item['short_value'], 'О ХУДОЖНИКЕ</span></a></p>') + strlen('О ХУДОЖНИКЕ</span></a></p>') ) ==strlen($item['short_value'])) {
                            //echo 'fuck'."\n"."\n"."\n"."\n";
                            continue;
                        } else {
                            $about_artist_small = explode('О ХУДОЖНИКЕ</span></a></p>',$item['short_value'])[1];
                    $add_info_0_caption = 'О ХУДОЖНИКЕ';

                            continue;
                        }
                    }
                    if (strpos($item['short_value'], 'О ХУДОЖНИКЕ</span></a></span>') !== false) {
                        $about_artist_small = explode('О ХУДОЖНИКЕ</span></a></span>',$item['short_value'])[1];
                    $add_info_0_caption = 'О ХУДОЖНИКЕ';

                        continue;
                    }
                    if (strpos($item['short_value'], 'О ХУДОЖНИКЕ </span></a><br />') !== false) {
                        $about_artist_small = explode('О ХУДОЖНИКЕ </span></a><br />',$item['short_value'])[1];
                    $add_info_0_caption = 'О ХУДОЖНИКЕ';

                        continue;
                    }
                    if (strpos($item['short_value'], 'О ХУДОЖНИКЕ</span></a><br />') !== false) {
                        $about_artist_small = explode('О ХУДОЖНИКЕ</span></a><br />',$item['short_value'])[1];
                    $add_info_0_caption = 'О ХУДОЖНИКЕ';

                        continue;
                    }

                    if (strpos($item['short_value'], 'О ХУДОЖНИКЕ</span></a><br />') !== false) {
                        $about_artist_small = explode('О ХУДОЖНИКЕ</span></a><br />',$item['short_value'])[1];
                    $add_info_0_caption = 'О ХУДОЖНИКЕ';

                        continue;
                    }

                    if (strpos($item['short_value'], 'О ХУДОЖНИКЕ</a></p>') !== false) {
                        $about_artist_small = explode('О ХУДОЖНИКЕ</a></p>',$item['short_value'])[1];
                    $add_info_0_caption = 'О ХУДОЖНИКЕ';

                        continue;
                    }

                    if (strpos($item['short_value'], 'О ХУДОЖНИКЕ</span></a>') !== false) {
                        $about_artist_small = explode('О ХУДОЖНИКЕ</span></a>',$item['short_value'])[1];
                    $add_info_0_caption = 'О ХУДОЖНИКЕ';

                        continue;
                    }

                    if (strpos($item['short_value'], 'О ХУДОЖНИКЕ</a><br /><br />') !== false) {
                        $about_artist_small = explode('О ХУДОЖНИКЕ</a><br /><br />',$item['short_value'])[1];
                    $add_info_0_caption = 'О ХУДОЖНИКЕ';

                        continue;
                    }

                    if (strpos($item['short_value'], 'О ХУДОЖНИКЕ</span></span>') !== false) {
                        $about_artist_small = explode('О ХУДОЖНИКЕ</span></span>',$item['short_value'])[1];
                    $add_info_0_caption = 'О ХУДОЖНИКЕ';

                        continue;
                    }

                    if (strpos($item['short_value'], 'О ХУДОЖНИКЕ</a></span></span></p>') !== false) {
                        $about_artist_small = explode('О ХУДОЖНИКЕ</a></span></span></p>',$item['short_value'])[1];
                    $add_info_0_caption = 'О ХУДОЖНИКЕ';

                        continue;
                    }
                    if (strpos($item['short_value'], 'О ХУДОЖНИКЕ</div>') !== false) {
                        $about_artist_small = explode('О ХУДОЖНИКЕ</div>',$item['short_value'])[1];
                    $add_info_0_caption = 'О ХУДОЖНИКЕ';

                        continue;
                    }
                    if (strpos($item['short_value'], 'О ХУДОЖНИКЕ</a></span></span></p>') !== false) {
                        $about_artist_small = explode('О ХУДОЖНИКЕ</a></span></span></p>',$item['short_value'])[1];
                    $add_info_0_caption = 'О ХУДОЖНИКЕ';

                        continue;
                    }
                    $about_artist_small = explode('</a></span></p>',$item['short_value'])[1];
                    $about_artist = $item['value'];
                    $add_info_0_caption = 'О ХУДОЖНИКЕ';

                }
                if (preg_match('/ПОСМОТРЕТЬ КНИГУ/', $item['short_value'])){
                    $show_book_url = @explode('"',@explode('href="',$item['short_value'])[1])[0];
                    continue;

                }

                if (preg_match('/НУМЕРОВАННОЕ ИЗДАНИЕ/', $item['short_value'])){
                    $num = @explode('"',@explode('href="',$item['short_value'])[1])[0];
                    continue;

                }
                if (preg_match('/БИБЛИОТЕКА ВЕЛИКИХ ПРОИЗВЕДЕНИЙ/', $item['short_value'])){
                    $bible = @explode('"',@explode('href="',$item['short_value'])[1])[0];
                    continue;

                }
                if (preg_match('/ТИРАЖНОЕ ИЗДАНИЕ/', $item['short_value'])){
                    $tir = @explode('"',@explode('href="',$item['short_value'])[1])[0];
                    continue;

                }
                if (preg_match('/АВТОРСКИЙ ПЕРЕПЛЕТ/', $item['short_value'])){
                    $auth = @explode('"',@explode('href="',$item['short_value'])[1])[0];
                    continue;

                }
                $any_text[] = [$item['name'],str_replace('uploaded/', 'wp-content/uploads/2023/uploaded/', $item['short_value']),str_replace('uploaded/', 'wp-content/uploads/2023/uploaded/    ', $item['value'])];
            }
            $any_text[] = [$add_info_0_caption,$about_artist_small,$about_artist];
            $any_text[] = [$add_info_1_caption,$from_translater_small,$from_translater];

            if (count($any_text) > 0) {
                $set_headers = [];
                $i = 0;
                $meta_add_info_caption = 'field_6508aac5f4784';
                $meta_add_info_text = 'field_6508aadbf4785';
                $meta_add_info_text_hidden = 'field_6508ab0cf4786';
                foreach($any_text as $text){
                    list($title, $short, $full) = $text;
                    $headers = "`Мета: add_info_$i"."_caption`,`Мета: add_info_$i"."_text`,`Мета: add_info_$i"."_text_hidden`, `Мета: _add_info_$i"."_caption`,`Мета: _add_info_$i"."_text`,`Мета: _add_info_$i"."_text_hidden`";
                    $values = "'$title','$short','$full', '$meta_add_info_caption','$meta_add_info_text','$meta_add_info_text_hidden'";
                    $add_infos .= $headers.',';
                    $add_info_values .= $values.',';
                    
                    $i++;
                }
                
                $headers_split = explode(',', str_replace('`',"'",$add_infos));

                    foreach($headers_split as $tr) {
                        if (!$tr) {
                            continue;
                        }
                        $sql = "SHOW COLUMNS FROM `new` where field = $tr";
                            $result = mysqli_fetch_all($db->query($sql),1);
                            if (count($result) <= 0) {
                                $tr = str_replace("'","`", $tr);
                                $new_column = "ALTER TABLE new ADD $tr TEXT NOT NULL ";
                                $r = $db->query($new_column);
                            }
                    }
            }
        }
       
    $toms_sql = "SELECT * FROM `toms` WHERE cat_id = $id ORDER by pos ASC";
    $get_toms = mysqli_fetch_all($quth_db->query($toms_sql),1);
    $toms = [['isbn' => $isbn, 'pages' => $pages, 'pictures' => $images]];


    
    
    for ($i=0; $i < count($get_toms); $i++) {
        $toms[] = array('isbn' => $get_toms[$i]['isbn'], 'pages' => $get_toms[$i]['pages'], 'pictures' => $get_toms[$i]['images']);        
    }
    // if ($id == 3325) {
    //     var_dump($toms);
    //     return false;
        

    // } else {
    //     return -1;
    // }

    $sql_get_author = 'SELECT name from cat2auths where cat_id ='.$id;
    $author = $author == '' ? (count(mysqli_fetch_all($quth_db->query($sql_get_author),1)) ? mysqli_fetch_all($quth_db->query($sql_get_author),1)[0]['name'] : '') : $author;
    $parsedInfo = getParse($category);
    if ($parsedInfo[0] == 'Misc' || $photo == '') {
        return false;
    }
    $category = $parsedInfo[0];
    $link = $parsedInfo[1].$link.'/';

    $is_to_buy = $type == 1 ? 1 : ($type == 2 ? 0 : 'backorder');
    $is_to_backorder = 0;

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

    $meta_tir = 'field_6502cae4a5d31';
    $meta_num = 'field_6502cb19a5d32';
    $meta_auth = 'field_650884503cf73';
    $meta_bible = 'field_6502cbc9ee3d5';


    $s_price = $s_price == 0 ? '' : $s_price;
    $title = $title ? $title : $name;

    $specs_volumes_0_isbn = @$toms[0]['isbn'];

    $tom1_pages = @$toms[1]['pages'];
    $tom1_pics = @$toms[1]['pictures'];
    $tom1_isbn = @$toms[1]['isbn'];
    $tom1_pages_meta = $tom1_pages ? 'field_6501fe5fe8a62' : '';
    $tom1_pics_meta = $tom1_pics ? 'field_6501fe74e8a63' : '';
    $tom1_isbn_meta = $tom1_isbn ? 'field_65658ddd524b0' : '';

    $tom2_pages = @$toms[2]['pages'];
    $tom2_pics = @$toms[2]['pictures'];
    $tom2_isbn = @$toms[2]['isbn'];
    $tom2_pages_meta = $tom2_pages ? 'field_6501fe5fe8a62' : '';
    $tom2_pics_meta = $tom2_pics ? 'field_6501fe74e8a63' : '';
    $tom2_isbn_meta = $tom2_isbn ? 'field_65658ddd524b0' : '';

    $tom3_pages = @$toms[3]['pages'];
    $tom3_pics = @$toms[3]['pictures'];
    $tom3_isbn = @$toms[3]['isbn'];
    $tom3_pages_meta = $tom3_pages ? 'field_6501fe5fe8a62' : '';
    $tom3_pics_meta = $tom3_pics ? 'field_6501fe74e8a63' : '';
    $tom3_isbn_meta = $tom3_isbn ? 'field_65658ddd524b0' : '';

    $tom4_pages = @$toms[4]['pages'];
    $tom4_pics = @$toms[4]['pictures'];
    $tom4_isbn = @$toms[4]['isbn'];
    $tom4_pages_meta = $tom4_pages ? 'field_6501fe5fe8a62' : '';
    $tom4_pics_meta = $tom4_pics ? 'field_6501fe74e8a63' : '';
    $tom4_isbn_meta = $tom4_isbn ? 'field_65658ddd524b0' : '';


    $toms_count = count($toms);


    $head = "`ID`, `Тип`, `Имя`, `Опубликован`, `Рекомендуемый?`, `Видимость в каталоге`, `Краткое описание`, 
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
 `Мета: _seo_description`,
 `Мета: tirazhnoe_izdanie`,`Мета: numerovannoe_izdanie`,`Мета: avtorskiy_pereplet`,`Мета: biblioteka_velikih_proizvedeniy`,
 `Мета: _tirazhnoe_izdanie`,`Мета: _numerovannoe_izdanie`,`Мета: _avtorskiy_pereplet`,`Мета: _biblioteka_velikih_proizvedeniy`,

 `Мета: specs_volumes_0_isbn`,`Мета: _specs_volumes_0_pictures`,`Мета: _specs_volumes_0_isbn`,
 `Мета: specs_volumes_1_pages`,`Мета: specs_volumes_1_pictures`,`Мета: specs_volumes_1_isbn`,`Мета: _specs_volumes_1_pages`,`Мета: _specs_volumes_1_pictures`,`Мета: _specs_volumes_1_isbn`,
 `Мета: specs_volumes_2_pages`,`Мета: specs_volumes_2_pictures`,`Мета: specs_volumes_2_isbn`,`Мета: _specs_volumes_2_pages`,`Мета: _specs_volumes_2_pictures`,`Мета: _specs_volumes_2_isbn`,
 `Мета: specs_volumes_3_pages`,`Мета: specs_volumes_3_pictures`,`Мета: specs_volumes_3_isbn`,`Мета: _specs_volumes_3_pages`,`Мета: _specs_volumes_3_pictures`,`Мета: _specs_volumes_3_isbn`,
 `Мета: specs_volumes_4_pages`,`Мета: specs_volumes_4_pictures`,`Мета: specs_volumes_4_isbn`,`Мета: _specs_volumes_4_pages`,`Мета: _specs_volumes_4_pictures`,`Мета: _specs_volumes_4_isbn`, `Мета: review_book`, `Мета: _review_book`,
$add_infos

`Мета: add_info`, `Мета: _add_info`
";
$values = "
'$id','simple','$name','1','0','visible','$s_disc','taxable','$is_to_buy','$is_to_backorder','0','1','$s_price','$price','$category','$photo','0',
     '$author','$year','$isbn','$tirage','$toms_count','','$disc','$pages','$images','$keywords','$description', '$title', '$link','$meta_year',
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
'$meta_seo_description',
'$tir','$num','$auth','$bible',
'$meta_tir','$meta_num','$meta_auth','$meta_bible',

'$specs_volumes_0_isbn','field_6501fe74e8a63','field_65658ddd524b0',
'$tom1_pages','$tom1_pics','$tom1_isbn','$tom1_pages_meta','$tom1_pics_meta','$tom1_isbn_meta',
'$tom2_pages','$tom2_pics','$tom2_isbn','$tom2_pages_meta','$tom2_pics_meta','$tom2_isbn_meta',
'$tom3_pages','$tom3_pics','$tom3_isbn','$tom3_pages_meta','$tom3_pics_meta','$tom3_isbn_meta',
'$tom4_pages','$tom4_pics','$tom4_isbn','$tom4_pages_meta','$tom4_pics_meta','$tom4_isbn_meta',
'$show_book_url', 'field_6502c87bfff18',
$add_info_values
'$add_info_len','field_6508aa9ff4783'
"; 
    $template = "INSERT INTO `new`($head) VALUES ($values)";
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
            return ['Тиражные издания > Героический зал','katalog/tirazhnie_izdaniya/'];
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
        case '67':
            return ['Нумерованные издания > Рукописи','katalog/numerovannie_izdaniya/rukopisi/'];
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

        case '75':
            return ['Галлерея > Иллюстрации','galereya/illyustratsii/'];

        case '127':
            return ['Графика','katalog/tirazhnie_izdaniya/'];

        case '229':
            return ['Библиотека великих писателей','katalog/biblioteka_velikih_pisateley/'];

        case '188':
            return ['Библиотека великих произведений','katalog/biblioteka_velikih_proizvedeniy/'];


        case '250':
            return ['Интернет-магазин > Акции > Праздник каждый день','internet_magazin/aktsii/prazdnik_kazhdiy_den/'];

        // case '188':
        //     return ['Библиотека великих произведений','katalog/biblioteka_velikih_proizvedeniy/'];

        // case '188':
        //     return ['Библиотека великих произведений','katalog/biblioteka_velikih_proizvedeniy/'];
            

//        case '312':
//            return 'Планы издательства 2020';
//
//        case '':
//            return '';
        default:
            return ['Misc','katalog/misc/'];
    }
}

function validateColumn($col_name) {
    $sql = "SHOW COLUMNS FROM `new` where field = '$col_name'";
}

//echo '<pre>';
//print_r ($id);
//echo '</pre>';


//ALTER TABLE `new`  ADD `Мета: specs_volumes_2_pages` TEXT NOT NULL  AFTER `Мета: _specs_volumes_1_isbn`,  ADD `Мета: specs_volumes_2_pictures` TEXT NOT NULL  AFTER `Мета: specs_volumes_2_pages`,  ADD `Мета: specs_volumes_2_isbn` TEXT NOT NULL  AFTER `Мета: specs_volumes_2_pictures`,  ADD `Мета: _specs_volumes_2_pages` TEXT NOT NULL  AFTER `Мета: specs_volumes_2_isbn`,  ADD `Мета: _specs_volumes_2_pictures` TEXT NOT NULL  AFTER `Мета: _specs_volumes_2_pages`,  ADD `Мета: _specs_volumes_2_isbn` TEXT NOT NULL  AFTER `Мета: _specs_volumes_2_pictures`;