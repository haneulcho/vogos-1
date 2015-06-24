<?php
// 분류사용, 상품사용하는 상품의 정보를 얻음
$sql = " select a.*,
				b.ca_name,
				b.ca_use
		   from {$g5['g5_shop_item_table']} a,
				{$g5['g5_shop_category_table']} b
		  where a.it_id = '$it_id'
			and a.ca_id = b.ca_id ";
$it = sql_fetch($sql);
if (!$it['it_id'])
	alert('자료가 없습니다.');
if (!($it['ca_use'] && $it['it_use'])) {
	if (!$is_admin)
		alert('판매가능한 상품이 아닙니다.');
}

// 분류 테이블에서 분류 상단, 하단 코드를 얻음
$sql = " select ca_mobile_skin_dir, ca_include_head, ca_include_tail, ca_cert_use, ca_adult_use
		   from {$g5['g5_shop_category_table']}
		  where ca_id = '{$it['ca_id']}' ";
$ca = sql_fetch($sql);


$g5['title'] = $it['it_name'].' &gt; '.$it['ca_name'];


// 관리자가 확인한 사용후기의 개수를 얻음
$sql = " select count(*) as cnt from `{$g5['g5_shop_item_use_table']}` where it_id = '{$it_id}' and is_confirm = '1' ";
$row = sql_fetch($sql);
$item_use_count = $row['cnt'];

// 상품문의의 개수를 얻음
$sql = " select count(*) as cnt from `{$g5['g5_shop_item_qa_table']}` where it_id = '{$it_id}' ";
$row = sql_fetch($sql);
$item_qa_count = $row['cnt'];

if ($default['de_mobile_rel_list_use']) {
	// 관련상품의 개수를 얻음
	$sql = " select count(*) as cnt
			   from {$g5['g5_shop_item_relation_table']} a
			   left join {$g5['g5_shop_item_table']} b on (a.it_id2=b.it_id and b.it_use='1')
			  where a.it_id = '{$it['it_id']}' ";
	$row = sql_fetch($sql);
	$item_relation_count = $row['cnt'];
}
?>

<div id="info_content">
<ul id="tab_container">
	<li class="tab_detail active"><i class="ion-ios-paper-outline"></i>Detail</li>
	<li class="tab_review"><i class="ion-ios-chatboxes-outline"></i>Review</li>
	<li class="tab_qna"><i class="ion-ios-help-outline"></i>Q&amp;A</li>
</ul>

<div id="tab_detail" class="active">
	<?php include_once(G5_MSHOP_SKIN_PATH.'/iteminfo.info.skin.php'); // include Detail ?>
</div>
<div id="tab_review">
	<?php include_once(G5_MSHOP_SKIN_PATH.'/iteminfo.itemuse.skin.php'); // Review ?>
</div>
<div id="tab_qna">
	<?php include_once(G5_MSHOP_SKIN_PATH.'/iteminfo.itemqa.skin.php'); // QNA ?>
</div>

<script type="text/javascript">
$(function(){
	// 상품 상세보기 Tab Navigation Script
	var $tabContainer = $('body').find('#tab_container');
	var $tabList = $tabContainer.find('li');

	$tabList.each(function() {
		var types = null;
		if($(this).attr('class') == 'tab_detail active') {
			types = 'tab_detail';
		} else {
			types = $(this).attr('class');
		}
		$(this).click(function() {
			$tabList.removeClass('active');
			if(!$(this).hasClass('active')) {
				$(this).addClass('active');			
			}
			showTabNav(types);
		});
	});

	function showTabNav(types) {
		$('#' + types).addClass('active');
		switch(types){
			case 'tab_detail' :
				$('#tab_review, #tab_qna').removeClass('active');
			break;
			case 'tab_review' :
				$('#tab_detail, #tab_qna').removeClass('active');
			break;
			case 'tab_qna' :
				$('#tab_detail, #tab_review').removeClass('active');
			break;
		}
	};
}); // wrraped function END
</script>





<?php
switch($info) {
	case 'dvr':
		include_once(G5_MSHOP_SKIN_PATH.'/iteminfo.delivery.skin.php');
		break;
	case 'ex':
		include_once(G5_MSHOP_SKIN_PATH.'/iteminfo.change.skin.php');
		break;
	case 'rel':
		include_once(G5_MSHOP_SKIN_PATH.'/iteminfo.relation.skin.php');
		break;
	default:
		break;
}
?>
</div> <!-- info_content END -->