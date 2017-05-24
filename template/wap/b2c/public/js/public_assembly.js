/**
 * 公用组件js
 * 李志伟
 * 2017年1月19日11:58:45
 * 现有功能：加入购物车、搜索
 */
$(function(){

	$('html').append('<div id="search_goods"></div>');
	$('html').append('<div id="detail"></div>');
	$('.custom-search-input').keyup(function(){
		var search = $(this).val();
		if(search.length > 10){
			showBox("搜索字数过多");
			$(this).val( $(this).val().substr(0,10));
		}
	})
	$('.custom-search-button').click(function(){
		
			var search = $('.custom-search-input').val();
			if(search.length > 10){
				showBox("搜索字数过多");
				//$.msg("搜索字数过多");
				return false;
			}
			var shop_id = $('.shopid').val();
			location.href= APPMAIN+"/goods/goodsSearchList?sear_name="+search+"&shop_id="+shop_id;
		
	})
})

document.onkeydown=function(event){ 
	e = event ? event :(window.event ? window.event : null); 
	if(e.keyCode==13){
		
			var search = $('.custom-search-input').val();
			var shop_id = $('.shopid').val();
			location.href= APPMAIN+"/goods/goodsSearchList?sear_name="+search+"&shop_id="+shop_id;
		
	} 
}
//加入购物车
function CartGoodsInfo(goodid){
	var uid=$('#uid').val();
	if(uid==''){
		window.location.href=APPMAIN+"/Login/index";
	}else{
		$.ajax({
			type:"post",
			url:APPMAIN+"/Goods/joinCartInfo",
			async:false,
			data:{'goods_id':goodid},
			dataType:'html',
			success:function(data){
				$('#detail').html(data);
				$('.s-buy').css('bottom',0);
			}
			
		});
	}
}
	//搜索商品
function GoodsSearch(){
	$('.head').css('z-index','0');
	$.ajax({
		type:"post",
		url:APPMAIN+"/Goods/goodsSearch",
		async:false,
		dataType:'html',
		success:function(data){

			$('#search_goods').html(data);
			$('#search_goods').show();
			$('.fixed-focus-on').hide();
		}
		
	});
	
}
