<?php
$sub_menu = '500500';
include_once('./_common.php');
include_once(G5_EDITOR_LIB);

auth_check($auth[$sub_menu], "w");

$html_title = "모델스초이스";
$g5['title'] = $html_title.' 관리';

if ($w == "u")
{
    $html_title .= " 수정";
    $readonly = " readonly";

    $sql = " select * from {$g5['g5_shop_models_table']} where mds_id = '$mds_id' ";
    $mds = sql_fetch($sql);
    if (!$mds['mds_id'])
        alert("등록된 자료가 없습니다.");

    // 등록된 이벤트 상품
    $sql = " select b.it_id, b.it_name
                from {$g5['g5_shop_models_item_table']} a left join {$g5['g5_shop_item_table']} b on ( a.it_id = b.it_id )
                where a.mds_id = '$mds_id' ";
    $res_item = sql_query($sql);
}
else
{
    $html_title .= " 입력";
    $mds['mds_skin'] = 'list.10.skin.php'; // 모델스초이스용 list.50.skin.php로 추후 수정할 것
    $mds['mds_mobile_skin'] = 'list.10.skin.php'; // 모델스초이스용 list.50.skin.php로 추후 수정할 것
    $mds['mds_use'] = 1;

    // 1.03.00
    // VOGOS 모델스초이스 이미지 기본값 변경
    // bimg는 영상 대표 이미지 사이즈, simg는 영상 캡쳐 이미지 사이즈
    $mds['mds_bimg_width']  = 350;
    $mds['mds_bimg_height'] = 490;
    $mds['mds_simg_width']  = 350;
    $mds['mds_simg_height'] = 490;
    $mds['mds_list_mod'] = 1;
    $mds['mds_list_row'] = 8;
    $mds['mds_mobile_img_width']  = 350;
    $mds['mds_mobile_img_height'] = 490;
    $mds['mds_mobile_list_mod'] = 8;
}

// 분류리스트
$category_select = '';
$sql = " select * from {$g5['g5_shop_category_table']} ";
if ($is_admin != 'super')
    $sql .= " where ca_mb_id = '{$member['mb_id']}' ";
$sql .= " order by ca_order, ca_id ";
$result = sql_query($sql);
for ($i=0; $row=sql_fetch_array($result); $i++)
{
    $len = strlen($row['ca_id']) / 2 - 1;

    $nbsp = "";
    for ($i=0; $i<$len; $i++)
        $nbsp .= "&nbsp;&nbsp;&nbsp;";

    $category_select .= "<option value=\"{$row['ca_id']}\">$nbsp{$row['ca_name']}</option>\n";
}

include_once (G5_ADMIN_PATH.'/admin.head.php');
?>

<form name="fmodelsform" action="./itemmodelsformupdate.php" onsubmit="return fmodelsform_check(this);" method="post" enctype="MULTIPART/FORM-DATA">
<input type="hidden" name="w" value="<?php echo $w; ?>">
<input type="hidden" name="mds_id" value="<?php echo $mds_id; ?>">
<input type="hidden" name="mds_item" value="">

<div class="tbl_frm01 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?></caption>
    <colgroup>
        <col class="grid_4">
        <col>
    </colgroup>
    <tbody>
    <?php if ($w == "u") { ?>
    <tr>
        <th>모델스초이스번호</th>
        <td>
            <span class="frm_ev_id"><?php echo $mds_id; ?></span>
            <a href="<?php echo G5_SHOP_URL; ?>/models.php?mds_id=<?php echo $mds['mds_id']; ?>" class="btn_frmline">게시글 바로가기</a>
        </td>
    </tr>
    <?php } ?>
    <tr>
        <th scope="row"><label for="mds_skin">출력스킨</label></th>
        <td>
            <?php echo help('기본으로 제공하는 스킨은 '.str_replace(G5_PATH.'/', '', G5_SHOP_SKIN_PATH).'/list.*.skin.php 입니다.'.PHP_EOL.G5_SHOP_DIR.'/models.php?mds_id=1234567890&amp;skin=userskin.php 처럼 직접 만든 스킨을 사용할 수도 있습니다.'); ?>
            <select name="mds_skin" id="mds_skin">
                <?php echo get_list_skin_options("^list.[0-9]+\.skin\.php", G5_SHOP_SKIN_PATH, $mds['mds_skin']); ?>
            </select>
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="mds_mobile_skin">모바일 출력스킨</label></th>
        <td>
            <?php echo help('기본으로 제공하는 스킨은 '.str_replace(G5_PATH.'/', '', G5_MSHOP_SKIN_PATH).'/list.*.skin.php 입니다.'.PHP_EOL.G5_SHOP_DIR.'/models.php?mds_id=1234567890&amp;skin=userskin.php 처럼 직접 만든 스킨을 사용할 수도 있습니다.'); ?>
            <select name="mds_mobile_skin" id="mds_mobile_skin">
                <?php echo get_list_skin_options("^list.[0-9]+\.skin\.php", G5_MSHOP_SKIN_PATH, $mds['mds_mobile_skin']); ?>
            </select>
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="mds_bimg_width">영상대표이미지 폭</label></th>
        <td>
              <input type="text" name="mds_bimg_width" value="<?php echo $mds['mds_bimg_width']; ?>" id="mds_bimg_width" required class="required frm_input" size="5"> 픽셀
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="mds_bimg_height">영상대표이미지 높이</label></th>
        <td>
          <input type="text" name="mds_bimg_height" value="<?php echo $mds['mds_bimg_height']; ?>" id="mds_bimg_height" required class="required frm_input" size="5"> 픽셀
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="mds_simg_width">영상서브캡쳐이미지 폭</label></th>
        <td>
              <input type="text" name="mds_simg_width" value="<?php echo $mds['mds_simg_width']; ?>" id="mds_simg_width" required class="required frm_input" size="5"> 픽셀
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="mds_simg_height">영상서브캡쳐이미지 높이</label></th>
        <td>
          <input type="text" name="mds_simg_height" value="<?php echo $mds['mds_simg_height']; ?>" id="mds_simg_height" required class="required frm_input" size="5"> 픽셀
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="mds_list_mod">1줄당 이미지 수</label></th>
        <td>
            <?php echo help("1행에 설정한 값만큼의 상품을 출력합니다. 스킨 설정에 따라 1행에 하나의 상품만 출력할 수도 있습니다.", 50); ?>
            <input type="text" name="mds_list_mod" value="<?php echo $mds['mds_list_mod']; ?>" id="mds_list_mod" required class="required frm_input" size="3"> 개
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="mds_list_row">이미지 줄 수</label></th>
        <td>
            <?php echo help("한 페이지에 출력할 이미지 줄 수를 설정합니다.\n한 페이지에 표시되는 상품수는 (1줄당 이미지 수 x 줄 수) 입니다."); ?>
            <input type="text" name="mds_list_row" value="<?php echo $mds['mds_list_row']; ?>" id="mds_list_row" required class="required frm_input" size="3"> 줄
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="mds_mobile_img_width">모바일 출력이미지 폭</label></th>
        <td>
              <input type="text" name="mds_mobile_img_width" value="<?php echo $mds['mds_mobile_img_width']; ?>" id="mds_mobile_img_width" required class="required frm_input" size="5"> 픽셀
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="mds_mobile_img_height">모바일 출력이미지 높이</label></th>
        <td>
          <input type="text" name="mds_mobile_img_height" value="<?php echo $mds['mds_mobile_img_height']; ?>" id="mds_mobile_img_height" required class="required frm_input" size="5"> 픽셀
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="mds_mobile_list_mod">모바일 이미지 수</label></th>
        <td>
            <?php echo help("한 페이지에 출력할 이미지 수를 설정합니다."); ?>
            <input type="text" name="mds_mobile_list_mod" value="<?php echo $mds['mds_mobile_list_mod']; ?>" id="mds_mobile_list_mod" required class="required frm_input" size="3"> 개
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="mds_use">사용</label></th>
        <td>
            <?php echo help("사용하지 않으면 레이아웃의 모델스초이스 메뉴 및 모델스초이스 관련 페이지에 접근할 수 없습니다."); ?>
            <select name="mds_use" id="mds_use">
                <option value="1" <?php echo get_selected($mds['mds_use'], 1); ?>>사용</option>
                <option value="0" <?php echo get_selected($mds['mds_use'], 0); ?>>사용안함</option>
            </select>
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="mds_subject">모델스초이스 제목</label></th>
        <td>
            <input type="text" name="mds_subject" value="<?php echo htmlspecialchars2($mds['mds_subject']); ?>" id="mds_subject" required class="required frm_input"  size="60">
        </td>
    </tr>
    <tr>
        <th scope="row">모델스초이스 관련상품</th>
        <td id="sev_it_rel" class="compare_wrap srel">

            <section class="compare_left">
                <h3>상품검색</h3>
                <span class="srel_pad">
                    <select name="ca_id" id="sch_ca_id">
                        <option value="">분류선택</option>
                        <?php echo $category_select; ?>
                    </select>
                    <label for="sch_name" class="sound_only">상품명</label>
                    <input type="text" name="sch_name" id="sch_name" class="frm_input" size="15">
                    <button type="button" id="btn_search_item" class="btn_frmline">검색</button>
                </span>
                <div id="sch_item_list" class="srel_list">
                    <p>상품의 분류를 선택하시거나 상품명을 입력하신 후 검색하여 주십시오.</p>
                </div>
            </section>

            <section class="compare_right">
                <h3>등록된 상품</h3>
                <span class="srel_pad"></span>
                <div id="reg_item_list" class="srel_sel">
                    <?php
                    for($i=0; $row=sql_fetch_array($res_item); $i++) {
                        $it_name = get_it_image($row['it_id'], 50, 50).' '.$row['it_name'];

                        if($i==0)
                            echo '<ul>';
                    ?>
                        <li>
                            <input type="hidden" name="it_id[]" value="<?php echo $row['it_id']; ?>">
                            <div class="list_item"><?php echo $it_name; ?></div>
                            <div class="list_item_btn"><button type="button" class="del_item btn_frmline">삭제</button></div>
                        </li>
                    <?php
                    }

                    if($i > 0)
                        echo '</ul>';
                    else
                        echo '<p>등록된 상품이 없습니다.</p>';
                    ?>
                </div>
            </section>
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="mds_mimg">영상대표이미지</label></th>
        <td>
            <?php echo help("모델스초이스 리스트 좌측에 업로드 한 이미지를 출력합니다."); ?>
            <input type="file" name="mds_mimg" id="mds_mimg">
            <?php
            $mimg_str = "";
            $mimg = G5_DATA_PATH.'/models/'.$mds['mds_id'].'_m';
            if (file_exists($mimg)) {
                $size = @getimagesize($mimg);
                if($size[0] && $size[0] > 750)
                    $width = 750;
                else
                    $width = $size[0];

                echo '<input type="checkbox" name="mds_mimg_del" value="1" id="mds_mimg_del"> <label for="mds_mimg_del">삭제</label>';
                $mimg_str = '<img src="'.G5_DATA_URL.'/models/'.$mds['mds_id'].'_m" width="'.$width.'" alt="">';
            }
            if ($mimg_str) {
                echo '<div class="banner_or_img">';
                echo $mimg_str;
                echo '</div>';
            }
            ?>
        </td>
    </tr>

    <!-- 모델스초이스 영상 캡쳐이미지 최대 8개까지 삽입가능하도록 -->
    <?php for($i=1; $i<=8; $i++) { ?>
    <tr>
        <th scope="row"><label for="mds_simg<?php echo $i; ?>">영상서브캡쳐이미지 <?php echo $i; ?></label></th>
        <td>
            <input type="file" name="mds_simg<?php echo $i; ?>" id="mds_simg<?php echo $i; ?>">
            <?php
            $simg_str = "";
            $simg = G5_DATA_PATH.'/models/'.$mds['mds_id'.$i].'_s';

            if (file_exists($simg)) {
                $size = @getimagesize($simg);
                if($size[0] && $size[0] > 750)
                    $width = 750;
                else
                    $width = $size[0];
                echo '<input type="checkbox" name="mds_simg'.$i.'_del" value="1" id="mds_simg'.$i.'_del"> <label for="mds_simg'.$i.'_del">삭제</label>';
                $simg_str = '<img src="'.G5_DATA_URL.'/models/'.$mds['mds_id'.$i].'_s" width="'.$width.'" alt="">';
            }
            if ($simg_str) {
                echo '<div class="banner_or_img">';
                echo $simg_str;
                echo '</div>';
            }
            ?>
        </td>
    </tr>
    <?php } ?>
    <!-- 모델스초이스 영상 캡쳐이미지 최대 8개까지 삽입가능하도록 -->

    <tr>
        <th scope="row">모델스초이스 내용<br>(=콘티, 멘트 등 html 사용가능)</th>
        <td>
            <?php echo editor_html('mds_html', get_text($mds['mds_html'], 0)); ?>
        </td>
    </tr>
    </tbody>
    </table>
</div>

<div class="btn_confirm01 btn_confirm">
    <input type="submit" value="확인" class="btn_submit" accesskey="s">
    <a href="./itemmodels.php">목록</a>
</div>
</form>

<script>
$(function() {
    $("#btn_search_item").click(function() {
        var ca_id = $("#sch_ca_id").val();
        var it_name = $.trim($("#sch_name").val());

        if(ca_id == "" && it_name == "") {
            $("#sch_item_list").html("<p>상품의 분류를 선택하시거나 상품명을 입력하신 후 검색하여 주십시오.</p>");
            return false;
        }

        $("#sch_item_list").load(
            "./itemmodelssearch.php",
            { w: "<?php echo $w; ?>", mds_id: "<?php echo $mds_id; ?>", ca_id: ca_id, it_name: it_name }
        );
    });

    $("#sch_item_list .add_item").live("click", function() {
        // 이미 등록된 상품인지 체크
        var $li = $(this).closest("li");
        var it_id = $li.find("input:hidden").val();
        var it_id2;
        var dup = false;
        $("#reg_item_list input[name='it_id[]']").each(function() {
            it_id2 = $(this).val();
            if(it_id == it_id2) {
                dup = true;
                return false;
            }
        });

        if(dup) {
            alert("이미 등록된 상품입니다.");
            return false;
        }

        var cont = "<li>"+$li.html().replace("add_item", "del_item").replace("추가", "삭제")+"</li>";
        var count = $("#reg_item_list li").size();

        if(count > 0) {
            $("#reg_item_list li:last").after(cont);
        } else {
            $("#reg_item_list").html("<ul>"+cont+"</ul>");
        }

        $li.remove();
    });

    $("#reg_item_list .del_item").live("click", function() {
        if(!confirm("상품을 삭제하시겠습니까?"))
            return false;

        $(this).closest("li").remove();

        var count = $("#reg_item_list li").size();
        if(count < 1)
            $("#reg_item_list").html("<p>등록된 상품이 없습니다.</p>");
    });
});
function fmodelsform_check(f)
{
    var item = new Array();
    var mds_item = it_id = "";

    $("#reg_item_list input[name='it_id[]']").each(function() {
        it_id = $(this).val();
        if(it_id == "")
            return true;

        item.push(it_id);
    });

    if(item.length > 0)
        mds_item = item.join();

    $("input[name=mds_item]").val(mds_item);

    <?php echo get_editor_js('mds_html'); ?>

    return true;
}

/* document.feventform.ev_subject.focus(); 포커스해제*/
</script>


<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>
