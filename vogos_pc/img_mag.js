$(function(){
	var opt = {
		smallSrc : sSrc,
		smallWidth : Number(sWidth),
		smallHeight : Number(sHeight),
		
		bigSrc : bSrc,
		bigWidth : Number(bWidth),
		bigHeight : Number(bHeight)
	};

	var oWin = $(window);
	var owraper = $("#sit_pvi");
	var oSmall = $("#sit_pvi_small");
	var oBig = $("#sit_pvi_big");
	var obg = $("#bg");
	var oMask = $("#mask");
	
	var oBigImg = null;
	var oBigImgWidth = opt.bigWidth;
	var oBigImgHeight = opt.bigHeight;
	
	var iBwidth = oBig.width();
	var iBheight = oBig.height();
	
	oBig.css("display", "none");

	var owrapperOffset = owraper.offset();
	var iTop = owrapperOffset.top;
	var iLeft = owrapperOffset.left;
	var iWidth = opt.smallWidth + 32;
	var iHeight = opt.smallHeight + 32;
	//var iWidth = owraper.width();
	//var iHeight = owraper.height();
	var iSpeed = 200;
	
	var setOpa = function( o )
	{
		o.css({
			opacity : 0,
			filter : 'alpha(opacity=0)'
		});
		return o;
	};

	var imgs = function( opt )
	{
		if( jQuery.type( opt ) !== "object" ) return false;

		var oBig = $(new Image());
		oBig.attr({
			'src' : opt.bigSrc,
			'width' : opt.bigWidth,
			'height' : opt.bigHeight
		});
		
		var oSmall = $(new Image());
		oSmall.attr({
			'src' : opt.smallSrc,
			'width' : opt.smallWidth,
			'height' : opt.smallHeight
		});
		
		oBigImg = oBig;
		
		return {
			bigImg : setOpa( oBig ),
			smallImg : setOpa( oSmall )
		};
	};
	
	var append = function( o, img )
	{
		o.append( img );
		
		$(img).animate({opacity: 1},
			iSpeed*2, null, function() {
				$(this).css = ({
					opacity : '',
					filter : ''
				});
			});
	};
	
	var eventMove = function( e )
	{
		var e = e || window.event;
		
		var w = oMask.width();
		var h = oMask.height();
		var x = e.clientX - iLeft + oWin.scrollLeft() - w/2;
		var y = e.clientY - iTop + oWin.scrollTop() - h/2;

		var l = iWidth - w - 4;
		var t = iHeight - h - 4;

		if( x < 0 )
		{
			x = 0;	
		}
		else if( x > l )
		{
			x = l;
		};
		
		if( y < 0 )
		{
			y = 0;	
		}
		else if( y > t )
		{
			y = t;
		};

		oMask.css(
		{
			left : x < 0 ? 0 : x > l ? l : x,
			top : y < 0 ? 0 : y > t ? t : y
		});
		
		var bigX = x / ( iWidth - w );
		var bigY = y / ( iHeight - h );
		
		oBigImg.css(
		{
			left : bigX * ( iBwidth - oBigImgWidth ),
			top : bigY * ( iBheight - oBigImgHeight )
		});

		return false;
	};
	
	var eventOver = function()
	{
		oMask.show();
		obg.stop()
			.animate(
			{
				opacity : .1
			}, iSpeed );
		oBig.show()
			.stop()
			.animate(
			{
				opacity : 1	
			}, iSpeed/2 );
		
		return false;
	};
	
	var eventOut = function()
	{
		oMask.hide();
		obg.stop()
			.animate(
			{
				opacity : 0
			}, iSpeed/2);
			
		oBig.stop()
			.animate(
			{
				opacity : 0
			}, iSpeed, null, function()
			{
				$(this).hide();
			});
		
		return false;
	};
	
	var _init = function( object, oB, oS, callback ){
		var num = 0;
		
		oBig.css("opacity", 0);
		
		append( oB, object.bigImg );
		append( oS, object.smallImg );
		
		object.bigImg.onload = function()
		{
			num += 1;
			
			if( num === 2 )
			{ 
				callback.call( object.smallImg );
			};
		};
		
		object.smallImg.onload = function()
		{
			num += 1;
			
			if( num === 2 )
			{ 
				callback.call( object.smallImg );
			};
		};
	};
	
	_init( imgs( opt ), oBig, oSmall, function()
	{
		oWin.resize(function(){
			iTop = owraper.top();
			iLeft = owraper.left();
			// iWidth = owraper.width();
			// iHeight = owraper.height();
			iWidth = opt.smallWidth + 32;
			iHeight = opt.smallHeight + 32;
		});
		oSmall.hover( eventOver, eventOut )
			  .mousemove( eventMove );
	});
		oSmall.hover( eventOver, eventOut )
			  .mousemove( eventMove );
});