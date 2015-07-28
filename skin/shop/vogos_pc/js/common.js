$(function(){
// #ft_totop 클릭하면 최상단으로 이동
$('#ft_totop').click(function(e) {
	e.preventDefault();
	$("html, body").animate({
		scrollTop: 0
	}, 600);
});

});