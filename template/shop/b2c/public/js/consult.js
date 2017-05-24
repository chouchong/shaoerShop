

var submiting = false;

//操作处理开始
var OperateHandle = function () {
    function _bindEvent() {
        //咨询列表切换卡

        //显示隐藏咨询类型信息
        $("[nc_type='consultClassRadio']").first().attr("checked","checked");
        $("[nc_type='consultClassIntroduce']").hide();
        $("[nc_type='consultClassIntroduce']").first().show();

        $("[nc_type='consultClassRadio']").click(function () {
            $("[nc_type='consultClassIntroduce']").hide();
            $("#consultClassIntroduce"+$(this).val()).show();
        });

        //验证码
        $("#consultCaptchaHide").click(function(){
            $(".code").fadeOut("slow");
        });
        $("#consultCaptcha").focus(function(){
            $(".code").fadeIn("fast");
        });

        $("#consultSubmit").click(function(){
        	var goods_id=$('#goods_id').val();
        	var goods_name=$('#goods_name').val();
        	var ct_id=$('[name="classId"]:checked').val();
        	var consult_content=$('#consultContent').val();
        	var shop_id=$('#shop_id').val();
        	var randomCode=$('#consultCaptcha').val();
        	if(consult_content==""){
        		$.msg('咨询信息不可为空!');
        		return false;
        	}
        	if(randomCode==""){
        		$.msg('验证码不可为空!');
        		return false;
        	}
            $.post(shop_main+"/Goods/goodsConsultInsert",
            		{"goods_id":goods_id,
            		 "goods_name":goods_name,
            		 "ct_id":ct_id,
            		 "shop_id":shop_id,
            		 "consult_content":consult_content,
            		 "randomCode":randomCode
            		 },
            		 function(data){
            			 if(data['code']>0){
            				 $.msg('咨询信息发布成功！');
            				 location.href=shop_main+"/Goods/goodsConsult?goodsid="+goods_id;
            			 }else if(data['code']==-1){
            				 $.msg(data['message']);
            				 changeCaptcha();
            			 }
            		 },"json")
   
        });
        //更换验证码
        $('#consultCaptchaImage').click(function(){
            changeCaptcha();
        });
        $('[nc_type="consultCaptchaChange"]').click(function(){
            changeCaptcha();
        });

        //字符个数动态计算
        $("#consultContent").charCount({
            allowed: 200,
            warning: 10,
            counterContainerID:'consultCharCount',
            firstCounterText:'还可以输入',
            endCounterText:'字',
            errorCounterText:'已经超出'
        });
    }

    //外部可调用
    return {
        bindEvent: _bindEvent
    }
}();
//操作处理结束

//更换验证码
function changeCaptcha() {
    $('#consultCaptchaImage').attr('src', shop_main + '/Components/random?t=' + Math.random());
    $('#consultCaptcha').select();
}

$(function () {
    //页面绑定事件
    OperateHandle.bindEvent();

});