<?php
include_once('./_common.php');

if (!$is_member)
		goto_url(G5_BBS_URL."/login.php?url=".urlencode(G5_SHOP_URL."/mypage.php"));

$g5['title'] = '마이페이지';
include_once(G5_MSHOP_PATH.'/_head.php');

// 쿠폰
$cp_count = 0;
$sql = " select cp_id
					from {$g5['g5_shop_coupon_table']}
					where mb_id IN ( '{$member['mb_id']}', '전체회원' )
						and cp_start <= '".G5_TIME_YMD."'
						and cp_end >= '".G5_TIME_YMD."' ";
$res = sql_query($sql);

for($k=0; $cp=sql_fetch_array($res); $k++) {
	if(!is_used_coupon($member['mb_id'], $cp['cp_id']))
			$cp_count++;
}
?>

<div id="smb_my">

	<section id="smb_my_ov">
		<h1>MY PAGE</h1>
		<h2><?php echo $member['mb_name'] ?><span>님</span></h2>
		<ul class="mp_lst_icon">
			<li><a href="<?php echo G5_BBS_URL; ?>/point.php" target="_blank" class="win_point"><h4><i class="point"></i>POINT</h4><span><?php echo number_format($member['mb_point']); ?></span></a></li>
			<li><a href="<?php echo G5_MSHOP_URL; ?>/cart.php"><h4><i class="cart"></i>CART</h4><span><?=get_cart_count(get_session('ss_cart_id'));?></span></a></li>
			<li><a href="<?php echo G5_SHOP_URL; ?>/coupon.php" target="_blank" class="win_coupon"><h4><i class="coupon"></i>COUPON</h4><span><?php echo number_format($cp_count); ?></span></a></li>
		</ul>
		<dl class="mp_lst_txt">
			<dt class="email">E-MAIL</dt>
			<dd>
				<?php echo ($member['mb_email'] ? $member['mb_email'] : '미등록'); ?>
			</dd>

			<dt class="tel">TEL/HP</dt>
			<dd>
				<?php if($member['mb_tel']) { ?>
				<?php echo ($member['mb_tel'] ? $member['mb_tel'].' / ' : '미등록 / '); ?>
				<?php } ?>
				<?php if($member['mb_hp']) { ?>
				<?php echo ($member['mb_hp'] ? $member['mb_hp'] : '미등록'); ?>
				<?php } ?>
			</dd>

			<dt class="address">ADDRESS</dt>
			<dd>
				<?php echo sprintf("(%s-%s)", $member['mb_zip1'], $member['mb_zip2']).' '.print_address($member['mb_addr1'], $member['mb_addr2'], $member['mb_addr3'], $member['mb_addr_jibeon']); ?>
			</dd>
		</dl>
	</section>

	<section id="smb_my_lod" class="rd_bg">
		<h2 class="rd_hd"><a href="<?php echo G5_SHOP_URL; ?>/orderinquiry.php">진행중인 주문<span>(최근 3주 기준)</span></a></h2>
		<?php
		// 최근 주문내역
		define("_ORDERINQUIRY_", true);

		include G5_MSHOP_PATH.'/orderinquiry.status.php';
		?>
	</section>

	<section id="smb_my_od" class="rd_bg">
		<h2 class="rd_hd"><a href="<?php echo G5_SHOP_URL; ?>/orderinquiry.php">최근 주문내역<span><i class="ion-android-arrow-dropright rd"></i></span></a></h2>
		<?php
		// 최근 주문내역
		define("_ORDERINQUIRY_", true);

		$limit = " limit 0, 5 ";
		include G5_MSHOP_PATH.'/orderinquiry.sub.php';
		?>
	</section>

	<section id="smb_my_wish" class="rd_bg">
		<h2 class="rd_hd"><a href="<?php echo G5_SHOP_URL; ?>/wishlist.php">최근 위시리스트</a></h2>

		<ul>
				<?php
				$sql = " select *
									 from {$g5['g5_shop_wish_table']} a,
												{$g5['g5_shop_item_table']} b
									where a.mb_id = '{$member['mb_id']}'
										and a.it_id  = b.it_id
									order by a.wi_id desc
									limit 0, 3 ";
				$result = sql_query($sql);
				for ($i=0; $row = sql_fetch_array($result); $i++)
				{
						$image_w = 50;
						$image_h = 50;
						$image = get_it_image($row['it_id'], $image_w, $image_h, true);
						$list_left_pad = $image_w + 10;
				?>

				<li style="padding-left:<?php echo $list_left_pad; ?>px">
						<div class="wish_img"><?php echo $image; ?></div>
						<div class="wish_info">
								<a href="./item.php?it_id=<?php echo $row['it_id']; ?>" class="info_link"><?php echo stripslashes($row['it_name']); ?></a>
								<span class="info_date"><?php echo substr($row['wi_time'], 2, 8); ?></span>
						</div>
				</li>

				<?php
				}

				if ($i == 0)
						echo '<li class="empty_list">위시리스트에 담긴 상품이 없네요.</li>';
				?>
		</ul>
	</section>

</div>

<script>
$(function() {
	$(".win_coupon").click(function() {
		var new_win = window.open($(this).attr("href"), "win_coupon", "left=100,top=100,width=700, height=600, scrollbars=1");
		new_win.focus();
		return false;
	});
});

function member_leave()
{
	return confirm('정말 회원에서 탈퇴 하시겠습니까?')
}
</script>

<?php
include_once(G5_MSHOP_PATH.'/_tail.php');
?>