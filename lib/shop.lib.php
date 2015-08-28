<?php
//==============================================================================
// 쇼핑몰 라이브러리 모음 시작
//==============================================================================

/*
간편 사용법 : 상품유형을 1~5 사이로 지정합니다.
$disp = new item_list(1);
echo $disp->run();


유형+분류별로 노출하는 경우 상세 사용법 : 상품유형을 지정하는 것은 동일합니다.
$disp = new item_list(1);
// 사용할 스킨을 바꿉니다.
$disp->set_list_skin("type_user.skin.php");
// 1단계분류를 20으로 시작되는 분류로 지정합니다.
$disp->set_category("20", 1);
echo $disp->run();


분류별로 노출하는 경우 상세 사용법
// type13.skin.php 스킨으로 3개씩 2줄을 폭 150 사이즈로 분류코드 30 으로 시작되는 상품을 노출합니다.
$disp = new item_list(0, "type13.skin.php", 3, 2, 150, 0, "30");
echo $disp->run();


이벤트로 노출하는 경우 상세 사용법
// type13.skin.php 스킨으로 3개씩 2줄을 폭 150 사이즈로 상품을 노출합니다.
// 스킨의 경로는 스킨 파일의 절대경로를 지정합니다.
$disp = new item_list(0, G5_SHOP_SKIN_PATH.'/list.10.skin.php', 3, 2, 150, 0);
// 이벤트번호를 설정합니다.
$disp->set_event("12345678");
echo $disp->run();

참고) 영카트4의 display_type 함수와 사용방법이 비슷한 class 입니다.
      display_category 나 display_event 로 사용하기 위해서는 $type 값만 넘기지 않으면 됩니다.
*/

class item_list
{
    // 상품유형 : 기본적으로 1~5 까지 사용할수 있으며 0 으로 설정하는 경우 상품유형별로 노출하지 않습니다.
    // 분류나 이벤트로 노출하는 경우 상품유형을 0 으로 설정하면 됩니다.
    protected $type;

    protected $list_skin;
    protected $list_mod;
    protected $list_row;
    protected $img_width;
    protected $img_height;

    // 상품상세보기 경로
    protected $href = "";

    // select 에 사용되는 필드
    protected $fields = "*";

    // 분류코드로만 사용하는 경우 상품유형($type)을 0 으로 설정하면 됩니다.
    protected $ca_id = "";
    protected $ca_id2 = "";
    protected $ca_id3 = "";

    // 노출순서
    protected $order_by = "it_order, it_id desc";

    // 상품의 이벤트번호를 저장합니다.
    protected $event = "";

    // 스킨의 기본 css 를 다른것으로 사용하고자 할 경우에 사용합니다.
    protected $css = "";

    // 상품의 사용여부를 따져 노출합니다. 0 인 경우 모든 상품을 노출합니다.
    protected $use = 1;

    // 모바일에서 노출하고자 할 경우에 true 로 설정합니다.
    protected $is_mobile = false;

    // 기본으로 보여지는 필드들
    protected $view_it_id    = false;       // 상품코드
    protected $view_it_img   = true;        // 상품이미지
    protected $view_it_name  = true;        // 상품명
    protected $view_it_basic = true;        // 기본설명
    protected $view_it_price = true;        // 판매가격
    protected $view_it_cust_price = false;  // 소비자가
    protected $view_it_icon = false;        // 아이콘
    protected $view_sns = false;            // SNS

    // 몇번째 class 호출인지를 저장합니다.
    protected $count = 0;

    // true 인 경우 페이지를 구한다.
    protected $is_page = false;

    // 페이지 표시를 위하여 총 상품수를 구합니다.
    public $total_count = 0;

    // sql limit 의 시작 레코드
    protected $from_record = 0;

    // 외부에서 쿼리문을 넘겨줄 경우에 담아두는 변수
    protected $query = "";
            $size = @getimagesize($file);
            if($size[2] < 1 || $size[2] > 3)
                continue;

            $filename = basename($file);
            $filepath = dirname($file);
            $img_width = $size[0];
            $img_height = $size[1];

            break;
        }
    }

    if($img_width && !$height) {
        $height = round(($width * $img_height) / $img_width);
    }

    if($filename) {
        //thumbnail($filename, $source_path, $target_path, $thumb_width, $thumb_height, $is_create, $is_crop=false, $crop_mode='center', $is_sharpen=true, $um_value='80/0.5/3')
        // 보고스에서는 기본값을 is_crop = true로
        $thumb = thumbnail($filename, $filepath, $filepath, $width, $height, false, true, 'center', true, $um_value='80/0.5/3');
    }

    if($thumb) {
        $file_url = str_replace(G5_PATH, G5_URL, $filepath.'/'.$thumb);
        //$img = '<img src="'.$file_url.'" width="'.$width.'" height="'.$height.'" alt="'.$img_alt.'"';
        $img = '<img src="'.$file_url.'" alt="'.$img_alt.'"';
    } else {
        $img = '<img src="'.G5_SHOP_URL.'/img/no_image.gif" width="'.$width.'"';
        if($height)
            $img .= ' height="'.$height.'"';
        $img .= ' alt="'.$img_alt.'"';
    }

    if($img_id)
        $img .= ' id="'.$img_id.'"';
    $img .= '>';

    if($anchor)
        $img = '<a href="'.G5_SHOP_URL.'/item.php?it_id='.$it_id.'">'.$img.'</a>';

    return $img;
}

// VOGOS COLLECTION 상품 이미지를 얻는다
function get_it_image2($it_id, $width, $height=0, $anchor=false, $img_id='', $img_alt='')
{
    global $g5;

    if(!$it_id || !$width)
        return '';

    $sql = " select it_id, it_img10 from {$g5['g5_shop_item_table']} where it_id = '$it_id' ";
    $row = sql_fetch($sql);

    if(!$row['it_id'])
        return '';

    for($i=1;$i<=10; $i++) {
        $file = G5_DATA_PATH.'/item/'.$row['it_img'.$i];
        if(is_file($file) && $row['it_img'.$i]) {
            $size = @getimagesize($file);
            if($size[2] < 1 || $size[2] > 3)
                continue;

            $filename = basename($file);
            $filepath = dirname($file);
            $img_width = $size[0];
            $img_height = $size[1];

            break;
        }
    }

    if($img_width && !$height) {
        $height = round(($width * $img_height) / $img_width);
    }

    if($filename) {
        //thumbnail($filename, $source_path, $target_path, $thumb_width, $thumb_height, $is_create, $is_crop=false, $crop_mode='center', $is_sharpen=true, $um_value='80/0.5/3')
        // 보고스에서는 기본값을 is_crop = true로
        $thumb = thumbnail($filename, $filepath, $filepath, $width, $height, false, true, 'center', true, $um_value='80/0.5/3');
    }

    if($thumb) {
        $file_url = str_replace(G5_PATH, G5_URL, $filepath.'/'.$thumb);
        //$img = '<img src="'.$file_url.'" width="'.$width.'" height="'.$height.'" alt="'.$img_alt.'"';
        $img = '<img src="'.$file_url.'" alt="'.$img_alt.'"';
    } else {
        $img = '<img src="'.G5_SHOP_URL.'/img/no_image.gif" width="'.$width.'"';
        if($height)
            $img .= ' height="'.$height.'"';
        $img .= ' alt="'.$img_alt.'"';
    }

    if($img_id)
        $img .= ' id="'.$img_id.'"';
    $img .= '>';

    if($anchor)
        $img = '<a href="'.G5_SHOP_URL.'/item.php?it_id='.$it_id.'">'.$img.'</a>';

    return $img;
}


// 상품이미지 썸네일 생성
function get_it_thumbnail($img, $width, $height=0, $id='')
{
    $str = '';

    $file = G5_DATA_PATH.'/item/'.$img;
    if(is_file($file))
        $size = @getimagesize($file);

    if($size[2] < 1 || $size[2] > 3)
        return '';

    $img_width = $size[0];
    $img_height = $size[1];
    $filename = basename($file);
    $filepath = dirname($file);

    if($img_width && !$height) {
        $height = round(($width * $img_height) / $img_width);
    }

    // 기본값 is_crop = true로
    $thumb = thumbnail($filename, $filepath, $filepath, $width, $height, false, true, 'center', true, $um_value='80/0.5/3');

    if($thumb) {
        $file_url = str_replace(G5_PATH, G5_URL, $filepath.'/'.$thumb);
        $str = '<img src="'.$file_url.'" width="'.$width.'" height="'.$height.'"';
        if($id)
            $str .= ' id="'.$id.'"';
        $str .= ' alt="">';
    }

    return $str;
}


// 이미지 URL 을 얻는다.
function get_it_imageurl($it_id)
{
    global $g5;

    $sql = " select it_img1, it_img2, it_img3, it_img4, it_img5, it_img6, it_img7, it_img8, it_img9, it_img10
                from {$g5['g5_shop_item_table']}
                where it_id = '$it_id' ";
    $row = sql_fetch($sql);
    $filepath = '';

    for($i=1; $i<=10; $i++) {
        $img = $row['it_img'.$i];
        $file = G5_DATA_PATH.'/item/'.$img;
        if(!is_file($file))
            continue;

        $size = @getimagesize($file);
        if($size[2] < 1 || $size[2] > 3)
            continue;

        $filepath = $file;
        break;
    }

    if($filepath)
        $str = str_replace(G5_PATH, G5_URL, $filepath);
    else
        $str = G5_SHOP_URL.'/img/no_image.gif';

    return $str;
}


// 상품의 재고 (창고재고수량 - 주문대기수량)
function get_it_stock_qty($it_id)
{
    global $g5;

    $sql = " select it_stock_qty from {$g5['g5_shop_item_table']} where it_id = '$it_id' ";
    $row = sql_fetch($sql);
    $jaego = (int)$row['it_stock_qty'];

    // 재고에서 빼지 않았고 주문인것만
    $sql = " select SUM(ct_qty) as sum_qty
               from {$g5['g5_shop_cart_table']}
              where it_id = '$it_id'
                and io_id = ''
                and ct_stock_use = 0
                and ct_status in ('주문', '입금', '준비') ";
    $row = sql_fetch($sql);
    $daegi = (int)$row['sum_qty'];

    return $jaego - $daegi;
}


// 옵션의 재고 (창고재고수량 - 주문대기수량)
function get_option_stock_qty($it_id, $io_id, $type)
{
    global $g5;

    $sql = " select io_stock_qty
                from {$g5['g5_shop_item_option_table']}
                where it_id = '$it_id' and io_id = '$io_id' and io_type = '$type' and io_use = '1' ";
    $row = sql_fetch($sql);
    $jaego = (int)$row['io_stock_qty'];

    // 재고에서 빼지 않았고 주문인것만
    $sql = " select SUM(ct_qty) as sum_qty
               from {$g5['g5_shop_cart_table']}
              where it_id = '$it_id'
                and io_id = '$io_id'
                and io_type = '$type'
                and ct_stock_use = 0
                and ct_status in ('주문', '입금', '준비') ";
    $row = sql_fetch($sql);
    $daegi = (int)$row['sum_qty'];

    return $jaego - $daegi;
}


// 큰 이미지
function get_large_image($img, $it_id, $btn_image=true)
{
    global $g5;

    if (file_exists(G5_DATA_PATH.'/item/'.$img) && $img != '')
    {
        $size   = getimagesize(G5_DATA_PATH.'/item/'.$img);
        $width  = $size[0];
        $height = $size[1];
        $str = '<a href="javascript:popup_large_image(\''.$it_id.'\', \''.$img.'\', '.$width.', '.$height.', \''.G5_SHOP_URL.'\')">';
        if ($btn_image)
            $str .= '큰이미지</a>';
    }
    else
        $str = '';
    return $str;
}


// 금액 표시
function display_price($price, $tel_inq=false)
{
    if ($tel_inq)
        $price = '전화문의';
    else
        $price = number_format($price, 0).'원';

    return $price;
}


// 금액표시
// $it : 상품 배열
function get_price($it)
{
    global $member;

    if ($it['it_tel_inq']) return '전화문의';

    $price = $it['it_price'];

    return (int)$price;
}


// 포인트 표시
function display_point($point)
{
    return number_format($point, 0).'점';
}


// 포인트를 구한다
function get_point($amount, $point)
{
    return (int)($amount * $point / 100);
}


// 상품이미지 업로드
function it_img_upload($srcfile, $filename, $dir)
{
    if($filename == '')
        return '';

    $size = @getimagesize($srcfile);
    if($size[2] < 1 || $size[2] > 3)
        return '';

    if(!is_dir($dir)) {
        @mkdir($dir, G5_DIR_PERMISSION);
        @chmod($dir, G5_DIR_PERMISSION);
    }

    $pattern = "/[#\&\+\-%@=\/\\:;,'\"\^`~\|\!\?\*\$#<>\(\)\[\]\{\}]/";

    $filename = preg_replace("/\s+/", "", $filename);
    $filename = preg_replace( $pattern, "", $filename);

    $filename = preg_replace_callback(
                          "/[가-힣]+/",
                          create_function('$matches', 'return base64_encode($matches[0]);'),
                          $filename);

    $filename = preg_replace( $pattern, "", $filename);

    upload_file($srcfile, $filename, $dir);

    $file = str_replace(G5_DATA_PATH.'/item/', '', $dir.'/'.$filename);

    return $file;
}


// 파일을 업로드 함
function upload_file($srcfile, $destfile, $dir)
{
    if ($destfile == "") return false;
    // 업로드 한후 , 퍼미션을 변경함
    @move_uploaded_file($srcfile, $dir.'/'.$destfile);
    @chmod($dir.'/'.$destfile, G5_FILE_PERMISSION);
    return true;
}


function message($subject, $content, $align="left", $width="450")
{
    $str = "
        <table width=\"$width\" cellpadding=\"4\" align=\"center\">
            <tr><td class=\"line\" height=\"1\"></td></tr>
            <tr>
                <td align=\"center\">$subject</td>
            </tr>
            <tr><td class=\"line\" height=\"1\"></td></tr>
            <tr>
                <td>
                    <table width=\"100%\" cellpadding=\"8\" cellspacing=\"0\">
                        <tr>
                            <td class=\"leading\" align=\"$align\">$content</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr><td class=\"line\" height=\"1\"></td></tr>
        </table>
        <br>
        ";
    return $str;
}


// 시간이 비어 있는지 검사
function is_null_time($datetime)
{
    // 공란 0 : - 제거
    //$datetime = ereg_replace("[ 0:-]", "", $datetime); // 이 함수는 PHP 5.3.0 에서 배제되고 PHP 6.0 부터 사라집니다.
    $datetime = preg_replace("/[ 0:-]/", "", $datetime);
    if ($datetime == "")
        return true;
    else
        return false;
}


// 출력유형, 스킨파일, 1라인이미지수, 총라인수, 이미지폭, 이미지높이
// 1.02.01 $ca_id 추가
//function display_type($type, $skin_file, $list_mod, $list_row, $img_width, $img_height, $ca_id="")
function display_type($type, $list_skin='', $list_mod='', $list_row='', $img_width='', $img_height='', $ca_id='')
{
    global $member, $g5, $config, $default;

    if (!$default["de_type{$type}_list_use"]) return "";

    $list_skin  = $list_skin  ? $list_skin  : $default["de_type{$type}_list_skin"];
    $list_mod   = $list_mod   ? $list_mod   : $default["de_type{$type}_list_mod"];
    $list_row   = $list_row   ? $list_row   : $default["de_type{$type}_list_row"];
    $img_width  = $img_width  ? $img_width  : $default["de_type{$type}_img_width"];
    $img_height = $img_height ? $img_height : $default["de_type{$type}_img_height"];

    // 상품수
    $items = $list_mod * $list_row;

    // 1.02.00
    // it_order 추가
    $sql = " select * from {$g5['g5_shop_item_table']} where it_use = '1' and it_type{$type} = '1' ";
    if ($ca_id) $sql .= " and ca_id like '$ca_id%' ";
    $sql .= " order by it_order, it_id desc limit $items ";
    $result = sql_query($sql);
    /*
    if (!mysql_num_rows($result)) {
        return false;
    }
    */


    $s = "";
    $s .= "<html><head><meta http-equiv=\"content-type\" content=\"text/html; charset={$g5['charset']}\"><title>메일</title>\n";
    $s .= "<body>\n";
    $s .= $str;
    $s .= "</body>\n";
    $s .= "</html>";

    return $s;
}


// 타임스탬프 형식으로 넘어와야 한다.
// 시작시간, 종료시간
function gap_time($begin_time, $end_time)
{
    $gap = $end_time - $begin_time;
    $time['days']    = (int)($gap / 86400);
    $time['hours']   = (int)(($gap - ($time['days'] * 86400)) / 3600);
    $time['minutes'] = (int)(($gap - ($time['days'] * 86400 + $time['hours'] * 3600)) / 60);
    $time['seconds'] = (int)($gap - ($time['days'] * 86400 + $time['hours'] * 3600 + $time['minutes'] * 60));
    return $time;
}


// 공란없이 이어지는 문자 자르기 (wayboard 참고 (way.co.kr))
function continue_cut_str($str, $len=80)
{
    /*
    $pattern = "[^ \n<>]{".$len."}";
    return eregi_replace($pattern, "\\0\n", $str);
    */
    $pattern = "/[^ \n<>]{".$len."}/";
    return preg_replace($pattern, "\\0\n", $str);
}


// 제목별로 컬럼 정렬하는 QUERY STRING
// $type 이 1이면 반대
function title_sort($col, $type=0)
{
    global $sort1, $sort2;
    global $_SERVER;
    global $page;
    global $doc;

    $q1 = 'sort1='.$col;
    if ($type) {
        $q2 = 'sort2=desc';
        if ($sort1 == $col) {
            if ($sort2 == 'desc') {
                $q2 = 'sort2=asc';
            }
        }
    } else {
        $q2 = 'sort2=asc';
        if ($sort1 == $col) {
            if ($sort2 == 'asc') {
                $q2 = 'sort2=desc';
            }
        }
    }
    #return "$_SERVER[SCRIPT_NAME]?$q1&amp;$q2&amp;page=$page";
    return "{$_SERVER['SCRIPT_NAME']}?$q1&amp;$q2&amp;page=$page";
}


// 세션값을 체크하여 이쪽에서 온것이 아니면 메인으로
function session_check()
{
    global $g5;

    if (!trim(get_session('ss_uniqid')))
        gotourl(G5_SHOP_URL);
}


// 상품 선택옵션
function get_item_options($it_id, $subject)
{
    global $g5;

    if(!$it_id || !$subject)
        return '';

    $sql = " select * from {$g5['g5_shop_item_option_table']} where io_type = '0' and it_id = '$it_id' and io_use = '1' order by io_no asc ";
    $result = sql_query($sql);
    if(!mysql_num_rows($result))
        return '';

    $str = '';
    $subj = explode(',', $subject);
    $subj_count = count($subj);

    if($subj_count > 1) {
        $options = array();

        // 옵션항목 배열에 저장
        for($i=0; $row=sql_fetch_array($result); $i++) {
            $opt_id = explode(chr(30), $row['io_id']);
            else
                $soldout = '';

            $options[$opt_id[0]][] = '<option value="'.$opt_id[1].','.$row['io_price'].','.$io_stock_qty.'">'.$opt_id[1].$price.$soldout.'</option>';
        }
    }

    // 옵션항목 만들기
    for($i=0; $i<$subj_count; $i++) {
        $opt = $options[$subj[$i]];
        $opt_count = count($opt);
        if($opt_count) {
            $seq = $i + 1;
            $str .= '<tr>'.PHP_EOL;
            $str .= '<th><label for="it_supply_'.$seq.'">'.$subj[$i].'</label></th>'.PHP_EOL;

            $select = '<select id="it_supply_'.$seq.'" class="it_supply">'.PHP_EOL;
            $select .= '<option value="">선택</option>'.PHP_EOL;
            for($k=0; $k<$opt_count; $k++) {
                $opt_val = $opt[$k];
                if($opt_val) {
                    $select .= $opt_val.PHP_EOL;
                }
            }
            $select .= '</select>'.PHP_EOL;

            $str .= '<td class="td_sit_sel">'.$select.'</td>'.PHP_EOL;
            $str .= '</tr>'.PHP_EOL;
        }
    }

    return $str;
}


function print_item_options($it_id, $cart_id)
{
    global $g5;

    $sql = " select ct_option, ct_qty, io_price
                from {$g5['g5_shop_cart_table']} where it_id = '$it_id' and od_id = '$cart_id' order by io_type asc, ct_id asc ";
    $result = sql_query($sql);

    $str = '';
    for($i=0; $row=sql_fetch_array($result); $i++) {
        if($i == 0)
            $str .= '<ul>'.PHP_EOL;
        $price_plus = '';
        if($row['io_price'] >= 0)
            $price_plus = '+';
        $str .= '<li>'.$row['ct_option'].' '.$row['ct_qty'].'개 ('.$price_plus.display_price($row['io_price']).')</li>'.PHP_EOL;
    }

    if($i > 0)
        $str .= '</ul>';

    return $str;
}


// 일자형식변환
function date_conv($date, $case=1)
{
    if ($case == 1) { // 년-월-일 로 만들어줌
        $date = preg_replace("/([0-9]{4})([0-9]{2})([0-9]{2})/", "\\1-\\2-\\3", $date);
    } else if ($case == 2) { // 년월일 로 만들어줌
        $date = preg_replace("/-/", "", $date);
    }

    return $date;
}


// 배너출력
function display_banner($position, $skin='')
{
    global $g5;

    if (!$position) $position = '왼쪽';
    if (!$skin) $skin = 'boxbanner.skin.php';

    $skin_path = G5_SHOP_SKIN_PATH.'/'.$skin;
    if(G5_IS_MOBILE)
        $skin_path = G5_MSHOP_SKIN_PATH.'/'.$skin;

    if(file_exists($skin_path)) {
        // 접속기기
        $sql_device = " and ( bn_device = 'both' or bn_device = 'pc' ) ";
        if(G5_IS_MOBILE)
            $sql_device = " and ( bn_device = 'both' or bn_device = 'mobile' ) ";
            
        // 배너 출력
        $sql = " select * from {$g5['g5_shop_banner_table']} where '".G5_TIME_YMDHIS."' between bn_begin_time and bn_end_time $sql_device and bn_position = '$position' order by bn_order, bn_id desc ";
        $result = sql_query($sql);

        include $skin_path;
    } else {
        echo '<p>'.str_replace(G5_PATH.'/', '', $skin_path).'파일이 존재하지 않습니다.</p>';
    }
}
            }
        } else if($it['it_sc_type'] == 1) { // 무료배송
            $sendcost = 0;
        }
    }

    return $sendcost;
}


// 쿠폰 사용체크
function is_used_coupon($mb_id, $cp_id)
{
    global $g5;

    $used = false;

    $sql = " select count(*) as cnt from {$g5['g5_shop_coupon_log_table']} where mb_id = '$mb_id' and cp_id = '$cp_id' ";
    $row = sql_fetch($sql);

    if($row['cnt'])
        $used = true;

    return $used;
}

// 품절상품인지 체크
function is_soldout($it_id)
{
    global $g5;

    // 상품정보
    $sql = " select it_soldout, it_stock_qty from {$g5['g5_shop_item_table']} where it_id = '$it_id' ";
    $it = sql_fetch($sql);

    if($it['it_soldout'] || $it['it_stock_qty'] <= 0)
        return true;

    $count = 0;
    $soldout = false;

    // 상품에 선택옵션 있으면..
    $sql = " select count(*) as cnt from {$g5['g5_shop_item_option_table']} where it_id = '$it_id' and io_type = '0' ";
    $row = sql_fetch($sql);

    if($row['cnt']) {
        $sql = " select io_id, io_type, io_stock_qty
                    from {$g5['g5_shop_item_option_table']}
                    where it_id = '$it_id'
                      and io_type = '0'
                      and io_use = '1' ";
        $result = sql_query($sql);

        for($i=0; $row=sql_fetch_array($result); $i++) {
            // 옵션 재고수량
            $stock_qty = get_option_stock_qty($it_id, $row['io_id'], $row['io_type']);

            if($stock_qty <= 0)
                $count++;
        }

        // 모든 선택옵션 품절이면 상품 품절
        if($i == $count)
            $soldout = true;
    } else {
        // 상품 재고수량
        $stock_qty = get_it_stock_qty($it_id);

        if($stock_qty <= 0)
            $soldout = true;
    }

    return $soldout;
}

// 상품후기 작성가능한지 체크
function check_itemuse_write($it_id, $mb_id, $close=true)
{
    global $g5, $default, $is_admin;

    if(!$is_admin && $default['de_item_use_write'])
    {
        $sql = " select count(*) as cnt
                    from {$g5['g5_shop_cart_table']}
                    where it_id = '$it_id'
                      and mb_id = '$mb_id'
                      and ct_status = '완료' ";
        $row = sql_fetch($sql);

        if($row['cnt'] == 0)
        {
            if($close)
                alert_close('사용후기는 주문이 완료된 경우에만 작성하실 수 있습니다.');
            else
                alert('사용후기는 주문하신 상품의 상태가 완료인 경우에만 작성하실 수 있습니다.');
        }
    }
}


            $str .= ' (문의전화: '.$tel.')';
    }

    return $str;
}


// 사용후기의 확인된 건수를 상품테이블에 저장합니다.
function update_use_cnt($it_id)
{
    global $g5;
    $row = sql_fetch(" select count(*) as cnt from {$g5['g5_shop_item_use_table']} where it_id = '{$it_id}' and is_confirm = 1 ");
    return sql_query(" update {$g5['g5_shop_item_table']} set it_use_cnt = '{$row['cnt']}' where it_id = '{$it_id}' ");
}


// 사용후기의 선호도(별) 평균을 상품테이블에 저장합니다.
function update_use_avg($it_id)
{
    global $g5;
    $row = sql_fetch(" select count(*) as cnt, sum(is_score) as total from {$g5['g5_shop_item_use_table']} where it_id = '{$it_id}' ");
    $average = ($row['total'] && $row['cnt']) ? $row['total'] / $row['cnt'] : 0;
    return sql_query(" update {$g5['g5_shop_item_table']} set it_use_avg = '$average' where it_id = '{$it_id}' ");
}


//------------------------------------------------------------------------------
// 주문포인트를 적립한다.
// 설정일이 지난 포인트 부여되지 않은 배송완료된 장바구니 자료에 포인트 부여
// 설정일이 0 이면 주문서 완료 설정 시점에서 포인트를 바로 부여합니다.
//------------------------------------------------------------------------------
function save_order_point($ct_status="완료")
{
    global $g5, $default;

    $beforedays = date("Y-m-d H:i:s", ( time() - (86400 * (int)$default['de_point_days']) ) ); // 86400초는 하루
    $sql = " select * from {$g5['g5_shop_cart_table']} where ct_status = '$ct_status' and ct_point_use = '0' and ct_time <= '$beforedays' ";
    $result = sql_query($sql);
    for ($i=0; $row=sql_fetch_array($result); $i++) {
        // 회원 ID 를 얻는다.
        $od_row = sql_fetch("select od_id, mb_id from {$g5['g5_shop_order_table']} where od_id = '{$row['od_id']}' ");
        if ($od_row['mb_id'] && $row['ct_point'] > 0) { // 회원이면서 포인트가 0보다 크다면
            $po_point = $row['ct_point'] * $row['ct_qty'];
            $po_content = "주문번호 {$od_row['od_id']} ({$row['ct_id']}) 배송완료";
            insert_point($od_row['mb_id'], $po_point, $po_content, "@delivery", $od_row['mb_id'], "{$od_row['od_id']},{$row['ct_id']}");
        }
        sql_query("update {$g5['g5_shop_cart_table']} set ct_point_use = '1' where ct_id = '{$row['ct_id']}' ");
    }
}


// 배송업체 리스트 얻기
function get_delivery_company($company)
{
    $option = '<option value="">없음</option>'.PHP_EOL;
    $option .= '<option value="자체배송" '.get_selected($company, '자체배송').'>자체배송</option>'.PHP_EOL;

    $dlcomp = explode(")", str_replace("(", "", G5_DELIVERY_COMPANY));
    for ($i=0; $i<count($dlcomp); $i++) {
        if (trim($dlcomp[$i])=="") continue;
        list($value, $url, $tel) = explode("^", $dlcomp[$i]);
        $option .= '<option value="'.$value.'" '.get_selected($company, $value).'>'.$value.'</option>'.PHP_EOL;
    }

    return $option;
}

// 사용후기 썸네일 생성
function get_itemuselist_thumbnail($it_id, $contents, $thumb_width, $thumb_height, $is_create=false, $is_crop=true, $crop_mode='center', $is_sharpen=true, $um_value='80/0.5/3')
{
    global $g5, $config;
    $img = $filename = $alt = "";

    if($contents) {
        $matches = get_editor_image($contents, false);

        for($i=0; $i<count($matches[1]); $i++)
        {
            // 이미지 path 구함
            $p = parse_url($matches[1][$i]);
            if(strpos($p['path'], '/'.G5_DATA_DIR.'/') != 0)
                $data_path = preg_replace('/^\/.*\/'.G5_DATA_DIR.'/', '/'.G5_DATA_DIR, $p['path']);
            else
                $data_path = $p['path'];

            $srcfile = G5_PATH.$data_path;

            if(preg_match("/\.({$config['cf_image_extension']})$/i", $srcfile) && is_file($srcfile)) {
                $size = @getimagesize($srcfile);
                if(empty($size))
                    continue;

                $filename = basename($srcfile);
                $filepath = dirname($srcfile);

                preg_match("/alt=[\"\']?([^\"\']*)[\"\']?/", $matches[0][$i], $malt);
                $alt = get_text($malt[1]);

                break;
            }
// 구매 본인인증 체크
function shop_member_cert_check($id, $type)
{
    global $g5, $member;

    $msg = '';

    switch($type)
    {
        case 'item':
            $sql = " select ca_id, ca_id2, ca_id3 from {$g5['g5_shop_item_table']} where it_id = '$id' ";
            $it = sql_fetch($sql);

            $seq = '';
            for($i=0; $i<3; $i++) {
                $ca_id = $it['ca_id'.$seq];

                if(!$ca_id)
                    continue;

                $sql = " select ca_cert_use, ca_adult_use from {$g5['g5_shop_category_table']} where ca_id = '$ca_id' ";
                $row = sql_fetch($sql);

                // 본인확인체크
                if($row['ca_cert_use'] && !$member['mb_certify']) {
                    if($member['mb_id'])
                        $msg = '회원정보 수정에서 본인확인 후 이용해 주십시오.';
                    else
                        $msg = '본인확인된 로그인 회원만 이용할 수 있습니다.';

                    break;
                }

                // 성인인증체크
                if($row['ca_adult_use'] && !$member['mb_adult']) {
                    if($member['mb_id'])
                        $msg = '본인확인으로 성인인증된 회원만 이용할 수 있습니다.\\n회원정보 수정에서 본인확인을 해주십시오.';
                    else
                        $msg = '본인확인으로 성인인증된 회원만 이용할 수 있습니다.';

                    break;
                }

                if($i == 0)
                    $seq = 1;
                $seq++;
            }

            break;
        case 'list':
            $sql = " select * from {$g5['g5_shop_category_table']} where ca_id = '$id' ";
            $ca = sql_fetch($sql);

            // 본인확인체크
            if($ca['ca_cert_use'] && !$member['mb_certify']) {
                if($member['mb_id'])
                    $msg = '회원정보 수정에서 본인확인 후 이용해 주십시오.';
                else
                    $msg = '본인확인된 로그인 회원만 이용할 수 있습니다.';
            }

            // 성인인증체크
            if($ca['ca_adult_use'] && !$member['mb_adult']) {
                if($member['mb_id'])
                    $msg = '본인확인으로 성인인증된 회원만 이용할 수 있습니다.\\n회원정보 수정에서 본인확인을 해주십시오.';
                else
                    $msg = '본인확인으로 성인인증된 회원만 이용할 수 있습니다.';
            }

            break;
        default:
            break;
    }

    return $msg;
}


// 배송조회버튼 생성
function get_delivery_inquiry($company, $invoice, $class='')
{
    if(!$company || !$invoice)
        return '';

    $dlcomp = explode(")", str_replace("(", "", G5_DELIVERY_COMPANY));

    for($i=0; $i<count($dlcomp); $i++) {
        if(strstr($dlcomp[$i], $company)) {
            list($com, $url, $tel) = explode("^", $dlcomp[$i]);
            break;
        }
    }

    $str = '';
    if($com && $url) {
        $str .= '<a href="'.$url.$invoice.'" target="_blank"';
        if($class)
            $str .= ' class="'.$class.'"';
        $str .='>배송조회</a>';
        if($tel)
        }

        if($filename) {
            $thumb = thumbnail($filename, $filepath, $filepath, $thumb_width, $thumb_height, $is_create, $is_crop, $crop_mode, $is_sharpen, $um_value);

            if($thumb) {
                $src = G5_URL.str_replace($filename, $thumb, $data_path);
                $img = '<img src="'.$src.'" width="'.$thumb_width.'" height="'.$thumb_height.'" alt="'.$alt.'">';
            }
        }
    }

    if(!$img)
        $img = get_it_image($it_id, $thumb_width, $thumb_height);

    return $img;
}

// 장바구니 상품삭제
function cart_item_clean()
{
    global $g5, $default;

    // 장바구니 보관일
    $keep_term = $default['de_cart_keep_term'];
    if(!$keep_term)
        $keep_term = 15; // 기본값 15일

    // ct_select_time이 기준시간 이상 경과된 경우 변경
    if(defined('G5_CART_STOCK_LIMIT'))
        $cart_stock_limit = G5_CART_STOCK_LIMIT;
    else
        $cart_stock_limit = 3;

    $stocktime = 0;
    if($cart_stock_limit > 0) {
        if($cart_stock_limit > $keep_term * 24)
            $cart_stock_limit = $keep_term * 24;

        $stocktime = G5_SERVER_TIME - (3600 * $cart_stock_limit);
        $sql = " update {$g5['g5_shop_cart_table']}
                    set ct_select = '0'
                    where ct_select = '1'
                      and ct_status = '쇼핑'
                      and UNIX_TIMESTAMP(ct_select_time) < '$stocktime' ";
        sql_query($sql);
    }

    // 설정 시간이상 경과된 상품 삭제
    $statustime = G5_SERVER_TIME - (86400 * $keep_term);

    $sql = " delete from {$g5['g5_shop_cart_table']}
                where ct_status = '쇼핑'
                  and UNIX_TIMESTAMP(ct_time) < '$statustime' ";
    sql_query($sql);
}


// 모바일 PG 주문 필드 생성
function make_order_field($data, $exclude)
{
    $field = '';

    foreach($data as $key=>$value) {
        if(in_array($key, $exclude))
            continue;

        if(is_array($value)) {
            foreach($value as $k=>$v) {
                $field .= '<input type="hidden" name="'.$key.'['.$k.']" value="'.$v.'">'.PHP_EOL;
            }
        } else {
            $field .= '<input type="hidden" name="'.$key.'" value="'.$value.'">'.PHP_EOL;
        }
    }

    return $field;
}

//==============================================================================
// 쇼핑몰 라이브러리 모음 끝
//==============================================================================
?>