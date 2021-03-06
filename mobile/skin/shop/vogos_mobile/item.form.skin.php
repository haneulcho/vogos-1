<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_MSHOP_SKIN_URL.'/style.css">', 0);
add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_SKIN_URL.'/magnific-popup.css">', 0);
add_javascript('<script src="'.G5_SHOP_SKIN_URL.'/js/jquery.primarycolor.min.js"></script>', 10);
add_javascript('<script src="'.G5_SHOP_SKIN_URL.'/js/jquery.magnific-popup.min.js"></script>', 0);
?>

<form name="fitem" method="post" action="<?php echo $action_url; ?>" onsubmit="return fitem_submit(this);">
<input type="hidden" name="it_id[]" value="<?php echo $it_id; ?>">
<input type="hidden" name="sw_direct">
<input type="hidden" name="url">

<div id="sit_ov_title" class="fixed_top">
    <div class="fullWidth">
        <div class="sit_left">
            <?php
            if ($prev_href || $next_href) {
                echo $prev_href.$prev_title.$prev_href2;
            }
            ?>
        </div>
        <div class="sit_right">
            <?php
            if ($prev_href || $next_href) {
                echo $next_href.$next_title.$next_href2;
            }
            ?>
        </div>
    </div>
</div>

<div id="sit_ov_title">
    <div class="sit_title">
        <h2><?php echo stripslashes($it['it_name']); ?>
        <?php
            if ($is_admin) {
                echo '<span class="sit_admin"><a href="'.G5_ADMIN_URL.'/shop_admin/itemform.php?w=u&amp;it_id='.$it_id.'" class="btn_admin" target="_blank">상품 관리</a></span>';
            }
        ?>
        </h2>
    </div>
</div>

<?php
if(!empty($it['it_2'])) { // 모바일일 때
    $video_src = $it['it_2'];
    $video_frame = "<video id=\"vogos_runway\" class=\"video\" width=\"300\" height=\"536\" controls=\"\" poster=\"data:image/gif,AAAA\"><source src=\"".$video_src."\" type=\"video/mp4\"></video>";
} else { // PC일 때
    $video_src = 'https://player.vimeo.com/video/'.$it['it_1'].'?autoplay=1&loop=0&color=333333&title=0&byline=0&portrait=0';
    $video_frame = "<iframe src=\"".$video_src."\" width=\"300\" height=\"536\" frameborder=\"0\" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>";
}
?>

<section id="sit_ov_bg">
<div id="sit_ov_wrap" class="fullWidth">

    <!-- //SK Planet 타일 서비스 : TO DO -->
    <?php if($is_admin) { ?>
    <div id="sk_test">
        <div style="position: relative; min-width: 90px; max-width: 495px; min-height: 160px; max-height: 880px; ">
            <div style="width: 100%; height: 0%; padding-bottom: 143%; position: relative;">
                <iframe style="left: 0px; top: 0px; width: 100%; height: 100%; position: absolute;" height="100%" src="https://dev.lean.co.kr/xd/web/v/502 " frameBorder="0" width="100%" scrolling="no" allowfullscreen=""></iframe>
            </div>
        </div>
    </div>
    <?php } ?>

    <!-- 상품이미지 미리보기 시작 { -->
    <div id="sit_pvi">
        <?php if(!empty($it['it_1'])) { ?>
            <div id="sit_pvi_video">
                <a class="play_video" href="<?php echo $video_src; ?>"><img src="<?php echo G5_SHOP_SKIN_URL; ?>/img/btn_view_runway.jpg"></a>
            </div>
        <?php } ?>
        <div id="sit_pvi_big" class="zoom-gallery">
        <?php
        $big_img_count = 0;
        $thumbnails = array();
        for($i=1; $i<=6; $i++) {
            if(!$it['it_img'.$i])
                continue;
            if($i == 1) {
                $img = get_it_thumbnail($it['it_img'.$i], 450, 1170);
            } else {
                $img = get_it_thumbnail($it['it_img'.$i], $default['de_simg_width'], $default['de_simg_height']);
            }

            if($img) {
                // 썸네일
                $thumb = get_it_thumbnail($it['it_img'.$i], 70, 95);
                $thumbnails[] = $thumb;
                $big_img_count++;

                echo '<a href="'.G5_DATA_URL.'/item/'.$it['it_img'.$i].'" target="_blank" title="'.$it['it_name'].'">'.$img.'</a>';
            }
        }

        if($big_img_count == 0) {
            echo '<img src="'.G5_SHOP_URL.'/img/no_image.gif" alt="">';
        }
        ?>
        </div>
        <?php
        // 썸네일
        $thumb1 = true;
        $thumb_count = 0;
        $total_count = count($thumbnails);
        if($total_count > 0) {
            echo '<ul id="sit_pvi_thumb">';
            foreach($thumbnails as $val) {
                $thumb_count++;
                $sit_pvi_last ='';
                if ($thumb_count % 5 == 0) $sit_pvi_last = 'class="li_last"';
                    echo '<li '.$sit_pvi_last.'>';
                    //echo '<a href="'.G5_SHOP_URL.'/largeimage.php?it_id='.$it['it_id'].'&amp;no='.$thumb_count.'" target="_blank" class="popup_item_image img_thumb">'.$val.'<span class="sound_only"> '.$thumb_count.' open to new window</span></a>';
                    echo '<a href="#" class="popup_item_image img_thumb">'.$val.'<span class="sound_only"> '.$thumb_count.' open to new window</span></a>';
                    echo '</li>';
            }
            echo '</ul>';
        }
        ?>
    </div>
    <!-- } 상품이미지 미리보기 끝 -->

    <!-- 상품 요약정보 및 구매 시작 { -->
    <section id="sit_ov">
        <div class="sit_it_basic">
            <p><?php echo $it['it_basic']; ?></p>
            <?php
                if(!empty($it['it_img11'])) {
                    $color_img = get_it_thumbnail($it['it_img11'], 59, 80);
                    echo '<div class="color_img">';
                    echo '<a href="'.G5_DATA_URL.'/item/'.$it['it_img11'].'" target="_blank" title="'.$it['it_name'].'">'.$color_img.'</a>';
                    echo '</div>';
                }
            ?>
        </div>

        <?php
        if($option_item) {
        ?>
        <!-- 선택옵션 시작 { -->
        <?php
            if(!empty($it['it_img11'])) {
                echo '<section style="min-height:70px;">';
            } else {
                echo '<section>';
            }
        ?>
            <h3 class="sound_only">Select Options</h3>
            <table class="sit_ov_tbl">
            <colgroup>
                <col class="grid_3">
                <col>
            </colgroup>
            <tbody>
            <?php // 선택옵션
            echo $option_item;
            ?>
            </tbody>
            </table>
        </section>
        <!-- } 선택옵션 끝 -->
        <?php
        }
        ?>

        <?php
        if($supply_item) {
        ?>
        <!-- 추가옵션 시작 { -->
        <section>
            <h3>추가옵션</h3>
            <table class="sit_ov_tbl">
            <colgroup>
                <col class="grid_3">
                <col>
            </colgroup>
            <tbody>
            <?php // 추가옵션
            echo $supply_item;
            ?>
            </tbody>
            </table>
        </section>
        <!-- } 추가옵션 끝 -->
        <?php
        }
        ?>

        <?php if ($is_orderable) { ?>
        <!-- 선택된 옵션 시작 { -->
        <section id="sit_sel_option">
            <h3>선택된 옵션</h3>
            <?php
            if(!$option_item) {
                if(!$it['it_buy_min_qty'])
                    $it['it_buy_min_qty'] = 1;
            ?>
            <ul id="sit_opt_added">
                <li class="sit_opt_list">
                    <input type="hidden" name="io_type[<?php echo $it_id; ?>][]" value="0">
                    <input type="hidden" name="io_id[<?php echo $it_id; ?>][]" value="">
                    <input type="hidden" name="io_value[<?php echo $it_id; ?>][]" value="<?php echo $it['it_name']; ?>">
                    <input type="hidden" class="io_price" value="0">
                    <input type="hidden" class="io_stock" value="<?php echo $it['it_stock_qty']; ?>">
                    <span class="sit_opt_subj"><?php echo $it['it_name']; ?></span>
                    <span class="sit_opt_prc">(+0원)</span>
                    <div>
                        <label for="ct_qty_<?php echo $i; ?>" class="sound_only">수량</label>
                        <input type="text" name="ct_qty[<?php echo $it_id; ?>][]" value="<?php echo $it['it_buy_min_qty']; ?>" id="ct_qty_<?php echo $i; ?>" class="frm_input" size="5">
                        <button type="button" class="sit_qty_plus btn_frmline">증가</button>
                        <button type="button" class="sit_qty_minus btn_frmline">감소</button>
                    </div>
                </li>
            </ul>
            <script>
            $(function() {
                price_calculate();
            });
            </script>
            <?php } ?>
        </section>
        <!-- } 선택된 옵션 끝 -->

        <div id="sit_ov_total">
            <?php if($is_orderable) { ?>
            <p id="sit_opt_info">
                Item Options: <?php echo $option_count; ?>, More Options: <?php echo $supply_count; ?>
            </p>
            <?php } ?>

            <h3 id="sit_title"><?php echo stripslashes($it['it_name']); ?> <span class="sound_only">Item Information &amp; Form</span></h3>

            <?php if (!$it['it_use']) { // 판매가능이 아닐 경우 ?>
            This Product is currently unavailable.
            <?php } // 시중가격 끝 ?>
            <div class="sit_ov_unit">
                <span class="price_unit">UNIT PRICE</span>
                <span class="price_unit_num"><?php echo display_price(get_price($it)); ?></span>
            </div>
            <div class="sit_ov_total">
                <span class="price_total">SUBTOTAL</span>
                <input type="hidden" id="it_price" value="<?php echo get_price($it); ?>">
                <div id="sit_tot_price" class="price_total_num">
                    <?php echo display_price(get_price($it)); ?>
                </div>
            </div>
        </div> <!-- sit_ov_total END -->


        <!-- 총 구매액 -->
        <?php } ?>

        <?php if($is_soldout) { ?>
        <p id="sit_ov_soldout">Out of Stock. Please select other items.</p>
        <?php } ?>

        <div id="sit_ov_btn">
            <?php if ($is_orderable) { ?>
            <input type="submit" onclick="document.pressed=this.value;" value="BUY NOW" id="sit_btn_buy">
            <?php } ?>
        </div>

        <script>
        // 상품보관
        function item_wish(f, it_id)
        {
            f.url.value = "<?php echo G5_SHOP_URL; ?>/wishupdate.php?it_id="+it_id;
            f.action = "<?php echo G5_SHOP_URL; ?>/wishupdate.php";
            f.submit();
        }

        // 추천메일
        function popup_item_recommend(it_id)
        {
            if (!g5_is_member)
            {
                if (confirm("회원만 추천하실 수 있습니다."))
                    document.location.href = "<?php echo G5_BBS_URL; ?>/login.php?url=<?php echo urlencode(G5_SHOP_URL."/item.php?it_id=$it_id"); ?>";
            }
            else
            {
                url = "./itemrecommend.php?it_id=" + it_id;
                opt = "scrollbars=yes,width=616,height=420,top=10,left=10";
                popup_window(url, "itemrecommend", opt);
            }
        }

        // 재입고SMS 알림
        function popup_stocksms(it_id)
        {
            url = "<?php echo G5_SHOP_URL; ?>/itemstocksms.php?it_id=" + it_id;
            opt = "scrollbars=yes,width=616,height=420,top=10,left=10";
            popup_window(url, "itemstocksms", opt);
        }
        </script>

    <?php
    // 상품 상세정보
    $info_skin = $skin_dir.'/item.info.skin.php';
    if(!is_file($info_skin))
        $info_skin = G5_SHOP_SKIN_PATH.'/item.info.skin.php';
    include $info_skin;
    ?>

    </section>
    <!-- } 상품 요약정보 및 구매 끝 -->
</div> <!-- sit_ov_wrap END -->

<?php if ($default['de_rel_list_use']) { ?>
<!-- 관련상품 시작 { -->
    <?php
    $rel_skin_file = $skin_dir.'/'.$default['de_rel_list_skin'];
    if(!is_file($rel_skin_file))
        $rel_skin_file = G5_SHOP_SKIN_PATH.'/'.$default['de_rel_list_skin'];

    $sql = " select b.* from {$g5['g5_shop_item_relation_table']} a left join {$g5['g5_shop_item_table']} b on (a.it_id2=b.it_id) where a.it_id = '{$it['it_id']}' and b.it_use='1' ";
    $list = new item_list($rel_skin_file, $default['de_rel_list_mod'], 0, $default['de_rel_img_width'], $default['de_rel_img_height']);
    $list->set_query($sql);
    echo $list->run();
    ?>
<!-- } 관련상품 끝 -->
<?php } ?>

</section> <!-- sit_ov_bg END -->

</form>


<script>
$(function(){
    // 스크롤시 이전, 다음 상품 버튼 상단에 정렬
    $('#main').addClass('inItem');
    $(window).scroll(function() {
        $('.fixed_top').css('top', $(this).scrollTop() + 45 + 'px');
    });

    // 큰 이미지 배경색 추출 플러그인
    var originColor;
    function changeColor() {
        $("#sit_pvi_big a:eq(0) img").primaryColor(function(color) {
                $('#sit_ov_bg').css('background-color', 'rgb('+color+')');
                originColor = color;
            }
        );
    }

    $(window).load(function() {
        changeColor();
        // 상품이미지 미리보기 (썸네일에 마우스 오버시에서 클릭시로 수정)
        $("#sit_pvi .img_thumb").bind("click focus", function(e){
            e.preventDefault();
            var idx = $("#sit_pvi .img_thumb").index($(this));
            if(idx == 0) {
            // 첫번째 이미지 선택시 배경 원복
                $('#sit_ov_bg').css('background-color', 'rgb('+originColor+')');
            } else {
                $('#sit_ov_bg').css('background-color', '#ffffff');
            }
            $("#sit_pvi_big a.visible").removeClass("visible").fadeOut('fast', function() {
                $("#sit_pvi_big a:eq("+idx+")").addClass("visible").hide().filter(":not(:animated)").fadeIn('fast');            
            });
        });
    });


    // 상품이미지 첫번째 링크
    $("#sit_pvi_big a:first").addClass("visible");

    // 상품이미지 클릭시 lightbox 생성
    $(document).ready(function() {
        $('.zoom-gallery').magnificPopup({
            delegate: 'a',
            type: 'image',
            closeOnContentClick: true,
            closeBtnInside: false,
            mainClass: 'mfp-with-zoom mfp-img-mobile',
            image: {
            verticalFit: true,
            titleSrc: function(item) {
              return item.el.attr('title');
            }
            },
            gallery: {
            enabled: true
            },
            zoom: {
            enabled: true,
            duration: 300, // don't foget to change the duration also in CSS
            opener: function(element) {
              return element.find('img');
            }
            }
          
        });

        // 동영상 플레이 스크립트
        $videoWrap = $('#sit_pvi_big');
        $video_frame = <?php echo json_encode($video_frame); ?>;
        $('.play_video').click(function(e) {
            e.preventDefault();
            if(!$(this).hasClass('active')){
                $(this).addClass('active');
                $("body, html").animate({
                    scrollTop: 112
                }, 600);
                $videoWrap.fadeIn(400).prepend($video_frame);

                var $vogos_runway = $('#vogos_runway')[0];
                if ($vogos_runway.paused) {
                    $vogos_runway.play();                    
                    $vogos_runway.onloadstart = function() {
                        $('#vogos_runway').addClass('loading');
                        console.log('onloadstart');
                    };
                    $vogos_runway.oncanplay = function() {
                        $('#vogos_runway').removeClass('loading');
                        console.log('oncanplay');
                    };
                } else {
                    $vogos_runway.pause();
                }
            } else {
                close_video();
                $('.play_video').removeClass('active');
            }
        });

        function close_video() {
            $('#sit_pvi_big').children('video').remove();
            $("body, html").animate({
                scrollTop: 0
            }, 600);
        }

        $('.color_img').magnificPopup({
            delegate: 'a',
            type: 'image',
            closeOnContentClick: true,
            closeBtnInside: false,
            mainClass: 'mfp-with-zoom mfp-img-mobile',
            image: {
            verticalFit: true,
            titleSrc: function(item) {
              return item.el.attr('title');
            }
            },
            gallery: {
            enabled: false
            },
            zoom: {
            enabled: true,
            duration: 300, // don't foget to change the duration also in CSS
            opener: function(element) {
              return element.find('img');
            }
            }
          
        });       
    });



    // 상품이미지 크게보기
/*    $(".popup_item_image").click(function() {
        var url = $(this).attr("href");
        var top = 10;
        var left = 10;
        var opt = 'scrollbars=yes,top='+top+',left='+left;
        popup_window(url, "largeimage", opt);

        return false;
    });*/
});


// 바로구매, 장바구니 폼 전송
function fitem_submit(f)
{
    if (document.pressed == "ADD TO CART") {
        f.sw_direct.value = 0;
    } else { // 바로구매
        f.sw_direct.value = 1;
    }

    // 판매가격이 0 보다 작다면
    if (document.getElementById("it_price").value < 0) {
        alert("An error occured. Please contact to us.");
        return false;
    }

    if($(".sit_opt_list").size() < 1) {
        alert("Please select an option.");
        return false;
    }

    var val, io_type, result = true;
    var sum_qty = 0;
    var min_qty = parseInt(<?php echo $it['it_buy_min_qty']; ?>);
    var max_qty = parseInt(<?php echo $it['it_buy_max_qty']; ?>);
    var $el_type = $("input[name^=io_type]");

    $("input[name^=ct_qty]").each(function(index) {
        val = $(this).val();

        if(val.length < 1) {
            alert("Please enter item quantity you selected.");
            result = false;
            return false;
        }

        if(val.replace(/[0-9]/g, "").length > 0) {
            alert("Please check a quantity.\nYou can use only number.");
            result = false;
            return false;
        }

        if(parseInt(val.replace(/[^0-9]/g, "")) < 1) {
            alert("Please enter quantity at least one.");
            result = false;
            return false;
        }

        io_type = $el_type.eq(index).val();
        if(io_type == "0")
            sum_qty += parseInt(val);
    });

    if(!result) {
        return false;
    }

    if(min_qty > 0 && sum_qty < min_qty) {
        alert("The quantity requested is not available. Please enter a lower quantity.");
        return false;
    }

    if(max_qty > 0 && sum_qty > max_qty) {
        alert("The quantity requested is not available. Please enter a lower quantity.");
        return false;
    }

    return true;
}
</script>