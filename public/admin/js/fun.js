// JavaScript Document

(function () {
   // window.detail_subtable = detail_subtable;
    //pay error tip
    function pay_tip_error() {
        $(".note-gotopay-tip").hide();
        $(".note-gotopay-tip-error").show();
        $(".modal-footer").show();
    }
    window.pay_tip_error = pay_tip_error;
    function pay_tip_error_close() {
        location.reload();
    }
    window.pay_tip_error_close = pay_tip_error_close;
    //select can fillout
    var sf_clicknum = 0;
    function selectfillout(obj) {
        if (sf_clicknum == 0) {
            $($(obj).parent().siblings()).show();
            sf_clicknum = 1;
        }
        else {
            $($(obj).parent().siblings()).hide();
            sf_clicknum = 0;
        }
        $($(obj).parent().siblings()).mouseover(function () {
            $(obj).show();
        })
        $($(obj).parent().siblings()).mouseleave(function () {
            $(obj).hide();
            $($(obj).parent().siblings()).hide();
            sf_clicknum = 0;
            $($(obj).parent()).mouseover(function () {
                $(obj).show();
            })
        })
        $(obj).parent().siblings().children().click(function (e) {
            var litxt;
            litxt = $(this).text()
            $(obj).siblings("input").val(litxt);
            $(this).parent().hide();
        })
    }
    window.selectfillout = selectfillout;
})();


$(function () {
    //distribution condition on off
    $("#onofcheckbox").change(function () {
        if ($(this)[0].checked) {
            $("#dis_condition").show();
        }
        else {
            $("#dis_condition").hide();
        }
    });
    $("#dis_money_input,#dis_piece_input").on("focus", function () {//fill in the input,radio is selected automatic.	
        $("input[name='disradio']").prop("checked", false);
        $(this).siblings("input:radio").prop("checked", true);
    });
    //active miaosha add		
    $("#common-select").click(function (event) {
        event.preventDefault();
        $(this).parents(".add-pro-select").hide();
        $(this).parents(".add-pro-select").next().show();
        $("#formsubmit").show();
    })
    $(".select-close").click(function () {
        $(this).parents(".pro-select-list").hide();
        $(this).parents(".pro-select-list").next(".none-tip").show();

    })
    //product addition
    $("#area-select,#procategory").on("mouseover", function () {
        $("#procategory").show();
    })

    $("#area-select,#procategory").on("mouseout", function () {
        $("#procategory").hide();
    })

    $(".input-checked").each(function (index, element) {
        if ($(this).prop("checked")) {
            $("#productcategory-selected").append("<span class='label'>" + $(this).val() + "<i class='categoryclose'></i></span>")
        }
    });
    $(".input-checked").live("change",function () {
        var $this = $(this);
        if ($this.prop("checked")) {
            $("#productcategory-selected").append("<span class='label' id="+$(this).attr("id")+">" + $this.val() + "<i class='categoryclose'></i></span>")
        }
        else {
            $("#productcategory-selected span").each(function () {
                if ($this.val() == $(this).text()) {
                    $(this).remove();
                }
            });

        }
    });
    $("#productcategory-selected").delegate(".categoryclose", "click", function () {
        var $this = $(this);
        $(this).parentsUntil("#productcategory-selected").remove();
        $("#procategory li").each(function (index, element) {
            if ($this.parent().text() == $(this).find(".input-checked").val()) {
                $(this).find(".input-checked").prop("checked", false);

            }
        });
    });
    //taobaodatefile
    $("#taobaodatefile").change(function () {
        $("#progress-out").show();
    });
    $("#close-progress").on("click", function () {
        $("#progress-out").hide();
    })
    //onlineservice
    $("#onlineservice-btnnext").on("click", function () {
        $(".step01").hide()
        $(".step02").show()
    })
    $("#onlineservice_onof_input").on("change", function () {
        if ($("#onlineservice_onof_input").prop("checked")) {
            $("#select-version").show();
        }
        else {
            $("#select-version").hide();
        }
        $("#freedownload").toggle();

    })
    if ($("#freeradio").prop("checked")) {
        if ($("#select-version").css("display") == "block") {
            $("#freedownload").show();
        }
        $("#chargebuy").hide()
    }
    else {
        $("#freedownload").hide();
        $("#chargebuy").show()
    }
    $("input[name='selectdown']").on("change", function () {
        $("#freedownload").toggle();
        $("#chargebuy").toggle()

    })
    $(".btn-buy").on("click", function (event) {
        event.preventDefault();
        $("#chargebuy").hide();
        $("#chargedownload").show();
    })
    $("#freeradio").on("click", function () {
        $("#chargebuy,#chargedownload").hide();

    })
    $("#btn-addpeople").on("click", function (event) {
        event.preventDefault();
        $(".alert-addpeople-form").toggle()
    })
    $(".btn-buy-cancle").on("click", function () {
        event.preventDefault();
        $(".alert-addpeople-form").hide()
    })
    //product-qr-print
    $("#produced-qr-btn").on("click", function () {
        $(".product-qr-print").fadeIn();
    })
    $("#product-qr-print-close").on("click", function () {
        $(".product-qr-print").fadeOut();
    })
    //active miaosha edit product
    if ($("#prospec-all").prop('checked')) {
        $(".spec-list").hide()
    }
    else {
        $(".spec-list").show()
    }
    $("input[name='spec-radio']").on("change", function () {
        if ($("#prospec-all").prop('checked')) {
            $(".spec-list").hide()
        }
        else {
            $(".spec-list").show()
        }
    })
    //01 input chart number  point
    var pointnumber
    if ($("input[data-inputlength='point']").val() == undefined) {
        pointnumber = 0;
    }
    else {
        pointnumber = 6 - $("input[data-inputlength='point']").val().length;
    }
    if (pointnumber < 0) { pointnumber = 0 }
    $("input[data-inputlength='point']").parent().siblings(".tip01").children(".leave").text(pointnumber);
    $("input[data-inputlength='point']").on("keyup", function () {
        var pointnumber = 6 - $("input[data-inputlength='point']").val().length;
        if (pointnumber < 0) { pointnumber = 0 }
        $(this).parent().siblings(".tip01").children(".leave").text(pointnumber);
    })
    $("input[data-inputlength='point']").on("blur", function () {
        var pointsubstring = $(this).val().substring(0, 6);
        $(this).val(pointsubstring)
    })

    //01 input describe number  describe
    var describenumber
    if ($("input[data-inputlength='describe']").val() == undefined) {
        describenumber = 0;
    }
    else {
        describenumber = 16 - $("input[data-inputlength='describe']").val().length;
    }
    if (describenumber < 0) { describenumber = 0 }
    $("input[data-inputlength='describe']").parent().siblings(".tip02").children(".leave").text(describenumber);
    $("input[data-inputlength='describe']").on("keyup", function () {
        var describenumber = 16 - $("input[data-inputlength='describe']").val().length;
        if (describenumber < 0) { describenumber = 0 }
        $(this).parent().siblings(".tip02").children(".leave").text(describenumber);
    })
    $("input[data-inputlength='describe']").on("blur", function () {
        var describesubstring = $(this).val().substring(0, 16);
        $(this).val(describesubstring)
    })
    //02 input chart number  point
    var pointnumber02
    if ($("input[data-inputlength='point02']").val() == undefined) {
        pointnumber02 = 0;
    }
    else {
        pointnumber02 = 6 - $("input[data-inputlength='point02']").val().length;
    }
    if (pointnumber02 < 0) { pointnumber02 = 0 }
    $("input[data-inputlength='point02']").parent().siblings(".tip01").children(".leave").text(pointnumber02);
    $("input[data-inputlength='point02']").on("keyup", function () {
        var pointnumber02 = 6 - $("input[data-inputlength='point02']").val().length;
        if (pointnumber02 < 0) { pointnumber02 = 0 }
        $(this).parent().siblings(".tip01").children(".leave").text(pointnumber02);
    })
    $("input[data-inputlength='point02']").on("blur", function () {
        var pointsubstring02 = $(this).val().substring(0, 6);
        $(this).val(pointsubstring02)
    })
    //02 input describe number  describe
    var describenumber02
    if ($("input[data-inputlength='describe02']").val() == undefined) {
        describenumber02 = 0;
    }
    else {
        describenumber02 = 16 - $("input[data-inputlength='describe02']").val().length;
    }
    if (describenumber02 < 0) { describenumber02 = 0 }
    $("input[data-inputlength='describe02']").parent().siblings(".tip02").children(".leave").text(describenumber02);
    $("input[data-inputlength='describe02']").on("keyup", function () {
        var describenumber02 = 16 - $("input[data-inputlength='describe02']").val().length;
        if (describenumber02 < 0) { describenumber02 = 0 }
        $(this).parent().siblings(".tip02").children(".leave").text(describenumber02);
    })
    $("input[data-inputlength='describe02']").on("blur", function () {
        var describesubstring02 = $(this).val().substring(0, 16);
        $(this).val(describesubstring02)
    })

    //03 input chart number  point
    var pointnumber03
    if ($("input[data-inputlength='point03']").val() == undefined) {
        pointnumber03 = 0;
    }
    else {
        pointnumber03 = 6 - $("input[data-inputlength='point03']").val().length;
    }
    if (pointnumber03 < 0) { pointnumber03 = 0 }
    $("input[data-inputlength='point03']").parent().siblings(".tip01").children(".leave").text(pointnumber03);
    $("input[data-inputlength='point03']").on("keyup", function () {
        var pointnumber03 = 6 - $("input[data-inputlength='point03']").val().length;
        if (pointnumber03 < 0) { pointnumber03 = 0 }
        $(this).parent().siblings(".tip01").children(".leave").text(pointnumber03);
    })
    $("input[data-inputlength='point03']").on("blur", function () {
        var pointsubstring03 = $(this).val().substring(0, 6);
        $(this).val(pointsubstring03)
    })
    //03 input describe number  describe
    var describenumber03
    if ($("input[data-inputlength='describe03']").val() == undefined) {
        describenumber03 = 0;
    }
    else {
        describenumber03 = 16 - $("input[data-inputlength='describe03']").val().length;
    }
    if (describenumber03 < 0) { describenumber03 = 0 }
    $("input[data-inputlength='describe03']").parent().siblings(".tip02").children(".leave").text(describenumber03);
    $("input[data-inputlength='describe03']").on("keyup", function () {
        var describenumber03 = 16 - $("input[data-inputlength='describe03']").val().length;
        if (describenumber03 < 0) { describenumber03 = 0 }
        $(this).parent().siblings(".tip02").children(".leave").text(describenumber03);
    })
    $("input[data-inputlength='describe03']").on("blur", function () {
        var describesubstring03 = $(this).val().substring(0, 16);
        $(this).val(describesubstring03)
    })
    //input flag number  describe
    var flag
    if ($("input[data-inputlength='flag']").val() == undefined) {
        flag = 0;
    }
    else {
        flag = 20 - $("input[data-inputlength='flag']").val().length;
    }
    if (flag < 0) { flag = 0 }
    $("input[data-inputlength='flag']").parent().siblings(".tip01").children(".leave").text(flag);
    $("input[data-inputlength='flag']").on("keyup", function () {
        var flag = 20 - $("input[data-inputlength='flag']").val().length;
        if (flag < 0) { flag = 0 }
        $(this).parent().siblings(".tip01").children(".leave").text(flag);
    })
    $("input[data-inputlength='flag']").on("blur", function () {
        var flag = $(this).val().substring(0, 20);
        $(this).val(flag)
    })
    //online service
    $("#onlineserver-submit").on("click", function () {
        $(".step01").hide();
        $(".step02").show();
        $(this).hide();
    })
    //active youhuiquan addd
    $("#buy-span,#sale-span").click(function (e) {
        var idfull;
        idfull = e.target.id;
        var idfron
        idfron = idfull.split("-");
        $("[id$='-span']").removeClass("current");
        $("#" + idfull).addClass("current");
        idfullform = idfron[0] + "-form";
        $("[id$='-form']").hide();
        $("#" + idfullform).show();
    })
    //order search more
    var searchcn = 0;
    $(".search-more").on("click", function () {
        if (searchcn == 0) {
            $(".search-more i").removeClass("arrow-down");
            $(".left-form-more").slideDown();
            $(".search-more span").text("收起")
            $(".search-more i").addClass("arrow-up");
            searchcn = 1;
        }
        else {
            $(".search-more i").removeClass("arrow-up");
            $(".left-form-more").slideUp()
            $(".search-more span").text("展开")
            $(".search-more i").addClass("arrow-down");
            searchcn = 0;
        }

    })
    //order physical
    function physical_showfull(obj) {
        $(".sourcewaybill").hide();
        $(obj).siblings().removeClass("current")
        $(obj).find(".sourcewaybill").show();
        $(obj).addClass("current")
    }
    window.physical_showfull = physical_showfull;

    //tlt 0603 radio-choice
    $("[data-choice='radio'] input:radio").on('click', function () {
        var m = ".radio-info" + "." + $(this).attr("class");       
        $(".radio-info").css("display", "none");
        $(m).css("display", "block");
    })
    //qr code typesest
    $("#divBlock").bind("mousedown", function (e) {
        var xo = e.pageX;
        var yo = e.pageY;
        var bX = $("#imgBox").offset().left;
        var bY = $("#imgBox").offset().top;
        var imgLeft = $("#header").position().left;
        var imgTop = $("#header").position().top;
        var nameLeft = $("#name").position().left;
        var nameTop = $("#name").position().top;
        var logoLeft = $("#logo").position().left;
        var logoTop = $("#logo").position().top;
        var codeLeft = $("#code").position().left;
        var codeTop = $("#code").position().top;
        if (((xo - bX) > imgLeft) && ((xo - bX) < imgLeft + 45) && ((yo - bY) > imgTop) && ((yo - bY) < imgTop + 45)) {//头像位置
            $("#divBlock").bind("mousemove", function (e) {
                var x = e.pageX;
                var y = e.pageY;
                $("#header").css("left", x - bX - (xo - bX) + imgLeft);
                $("#header").css("top", y - bY - (yo - bY) + imgTop);

            });
        };
        if (((xo - bX) > nameLeft) && ((xo - bX) < nameLeft + $("#name").width()) && ((yo - bY) > nameTop) && ((yo - bY) < nameTop + $("#name").height())) {//昵称位置
            $("#divBlock").bind("mousemove", function (e) {
                var x = e.pageX;
                var y = e.pageY;
                $("#name").css("left", x - bX - (xo - bX) + nameLeft);
                $("#name").css("top", y - bY - (yo - bY) + nameTop);

            });
        };
        if (((xo - bX) > logoLeft) && ((xo - bX) < logoLeft + $("#logo").width()) && ((yo - bY) > logoTop) && ((yo - bY) < logoTop + $("#logo").height())) {//LOGO位置
            $("#divBlock").bind("mousemove", function (e) {
                var x = e.pageX;
                var y = e.pageY;
                $("#logo").css("left", x - bX - (xo - bX) + logoLeft);
                $("#logo").css("top", y - bY - (yo - bY) + logoTop);

            });
        };
        if (((xo - bX) > codeLeft) && ((xo - bX) < codeLeft + $("#code").width()) && ((yo - bY) > codeTop) && ((yo - bY) < codeTop + $("#code").height())) {//二维码位置
            $("#divBlock").bind("mousemove", function (e) {
                var x = e.pageX;
                var y = e.pageY;
                $("#code").css("left", x - bX - (xo - bX) + codeLeft);
                $("#code").css("top", y - bY - (yo - bY) + codeTop);
            });
        };
    });
    $("#divBlock").bind("mouseup mouseout", function () {
        $("#divBlock").unbind("mousemove");        
    });
    //$("#divBlock").bind("mousemove", function (e) {//鼠标放上去效果
    //    var xo = e.pageX;
    //    var yo = e.pageY;
    //    var bX = $("#imgBox").offset().left;
    //    var bY = $("#imgBox").offset().top;
    //    var imgLeft = $("#header").position().left;
    //    var imgTop = $("#header").position().top;
    //    var nameLeft = $("#name").position().left;
    //    var nameTop = $("#name").position().top;
    //    var logoLeft = $("#logo").position().left;
    //    var logoTop = $("#logo").position().top;
    //    var codeLeft = $("#code").position().left;
    //    var codeTop = $("#code").position().top;
    //    if (((xo - bX) > imgLeft) && ((xo - bX) < imgLeft + 45) && ((yo - bY) > imgTop) && ((yo - bY) < imgTop + 45)) {//头像位置
    //        $("#header").css({
    //            "margin": "0",
    //            "border-width": "2px",
    //            "border-color": "#fa0",
    //            "border-style": "dashed"
    //        })
    //    }
    //    if (((xo - bX) < imgLeft) || ((xo - bX) > imgLeft + 45) || ((yo - bY) < imgTop) || ((yo - bY) > imgTop + 45)) {//头像位置
    //        $("#header").css({
    //            "border-width": "0px",
    //            "border-color": "#fa0",
    //            "border-style": "dashed"
    //        })
    //    }
    //})
   
    $("#bgfile").on("change", function () {//上传背景
        var fileurl = $(this).val().split("\\");
        $("#imgBox").css("background-image", "url(../../content/imagesv2/" + fileurl[fileurl.length - 1] + ")")
    })
    $("#name-color").on("change", function () {//昵称字颜色
        var name_color = $(this).val();
        $("#name").css("color", name_color)
    })
    $("#name-size").on("change", function () {//昵称字大小
        var name_size = $(this).val()/2.0;
        $("#name").css("font-size", name_size+"px")
    })
    $("#logosh").on("change", function () {//是否显示LOGO  
        $("#logo").toggle();
    })
    

})
