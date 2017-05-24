//这个文件是生成商品添加、编辑页面的商品属性和规格的js文件

var jsonPropertyByCategoty; //一个类目下所有的属性（全局变量）

function GetProperty(containerID, categoryID) {
    $("#" + containerID + "").html(""); //重新加载属性，将原有属性清空
    $("#foodSecurityContainer").css("display", "none"); //初始时,将食品安全输入信息框隐藏
    $.ajax({
        url: "../../Category/Properties",
        type: "get",
        data: { "categoryID": categoryID },
        async: false,
        success: function (res) {
            if (res.length != 2) {//等于2时是空数组“[]”
                var jsonRes = JSON.parse(res);
                for (var i = 0; i < jsonRes.length; i++) {
                    var $currentObj = jsonRes[i];
                    var $propertyElement;

                    //if (parseInt($currentObj.PropertyID) != 20000) {//20000是淘宝的“品牌”这一属性的ID，品牌做特殊处理，不是品牌的做下面的循环
                    //    if (parseInt($currentObj.PropertyID) != 6939376 && parseInt($currentObj.PropertyID) != 6932208) {
                    //        if ($currentObj.IsEnumProp == true && $currentObj.IsInputProp == true && $currentObj.IsMust == true) {//可填可选必需

                    //            $propertyElement = $("<li class='list-li'><div class='float-l w130'>      <span class='star'>*</span><label>" + $currentObj.PropertyName + "</label></div><div class='float-l'><select class='w230' id='property" + $currentObj.PropertyID + "' onchange='GetSubProperty(event," + categoryID + ")' onpropertychange='GetSubProperty(event," + categoryID + ")'><option></option></select></div><div class='float-l'><span class='prompt'></span></div></li>");
                    //        } else if ($currentObj.IsEnumProp == true && $currentObj.IsInputProp == true && $currentObj.IsMust == false) {//可填可选

                    //            $propertyElement = $("<li class='list-li'><div class='float-l w130'>      <span class='star'></span><label>" + $currentObj.PropertyName + "</label></div><div class='float-l'><select class='w230' id='property" + $currentObj.PropertyID + "' onchange='GetSubProperty(event," + categoryID + ")' onpropertychange='GetSubProperty(event," + categoryID + ")'><option></option></select></div><div class='float-l'><span class='prompt'></span></div></li>");
                    //        } else
                    //            if ($currentObj.IsEnumProp == true && $currentObj.IsInputProp == false && $currentObj.IsMust == true) {//不可填可选必需

                    //                $propertyElement = $("<li class='list-li'><div class='float-l w130'>      <span class='star'>*</span><label>" + $currentObj.PropertyName + "</label></div><div class='float-l'><select class='w230' id='property" + $currentObj.PropertyID + "' onchange='GetSubProperty(event," + categoryID + ")' onpropertychange='GetSubProperty(event," + categoryID + ")'><option></option></select></div><div class='float-l'><span class='prompt'></span></div></li>");
                    //            } else if ($currentObj.IsEnumProp == true && $currentObj.IsInputProp == false && $currentObj.IsMust == false) {//不可填可选

                    //                $propertyElement = $("<li class='list-li'><div class='float-l w130'>      <span class='star'></span><label>" + $currentObj.PropertyName + "</label></div><div class='float-l'><select class='w230' id='property" + $currentObj.PropertyID + "' onchange='GetSubProperty(event," + categoryID + ")' onpropertychange='GetSubProperty(event," + categoryID + ")'><option></option></select></div><div class='float-l'><span class='prompt'></span></div></li>");
                    //            } else if ($currentObj.IsEnumProp == false && $currentObj.IsInputProp == true && $currentObj.IsMust == true) {//可填不可选必需

                    //                $propertyElement = $("<li class='list-li'><div class='float-l w130'>      <span class='star'>*</span><label>" + $currentObj.PropertyName + "</label></div><div class='float-l'><input class='w230' id='property" + $currentObj.PropertyID + "' type='text'/></div><div class='float-l'><span class='prompt'></span></div></li>");
                    //            } else if ($currentObj.IsEnumProp == false && $currentObj.IsInputProp == true && $currentObj.IsMust == false) {//可填不可选

                    //                $propertyElement = $("<li class='list-li'><div class='float-l w130'>      <span class='star'></span><label>" + $currentObj.PropertyName + "</label></div><div class='float-l'><input class='w230' id='property" + $currentObj.PropertyID + "' type='text'/></div><div class='float-l'><span class='prompt'></span></div></li>");
                    //            } else if ($currentObj.IsItemProp == true) {//是例举项，下面循环出它的子项checkbox或radio(暂未生效2013.12.29记录)
                    //                $propertyElement = $("<div class='itemPropertyContainer' style='clear:both;'><div style='width:130px;text-align:left;float:left;margin-top: 10px;'>" + $currentObj.PropertyName + ":</div>  <div  style='width:700px;float:left;' id='property" + $currentObj.PropertyID + "'></div></div>");
                    //            }
                    //    } else 
                    if (parseInt($currentObj.PropertyID) == 6939376) {//食品类

                        $propertyElement = $("<li class='list-li'><div class='float-l w130'>      <span class='star'>*</span><label>" + $currentObj.PropertyName + "</label></div><div class='float-l'><select  class='w230' id='brandProperty" + $currentObj.PropertyID + "' onchange='OperateStarMark(event),GetSubProperty(event," + categoryID + ")' onpropertychange='OperateStarMark(event),GetSubProperty(event," + categoryID + ")'><option></option></select></div><div class='float-l'><span class='prompt'></span></div></li>");
                        $("#foodSecurityContainer").css("display", "block");
                        $("#" + containerID + "").append($propertyElement);
                    } else if (parseInt($currentObj.PropertyID) == 6932208) {//(婴幼儿)奶粉等

                        $propertyElement = $("<li class='list-li'><div class='float-l w130'>      <span class='star'>*</span><label>" + $currentObj.PropertyName + "</label></div><div class='float-l'><select  class='w230' id='brandProperty" + $currentObj.PropertyID + "'><option></option></select></div><div class='float-l'><span class='prompt'></span></div></li>");
                        $("#foodSecurityContainer").css("display", "block");
                        $("#" + containerID + "").append($propertyElement);

                    }

                    else {//“品牌”属性的处理

                        var strRes = JSON.stringify(jsonRes);
                        strRes = strRes.replace(/\"/g, "\\\"");
                        if ($currentObj.IsMust == true && $currentObj.IsInputProp == true && $currentObj.IsEnumProp == true) {//可选可输必填

                            $propertyElement = $("<li class='list-li'><div class='float-l w130'>      <span class='star'>*</span><label>" + $currentObj.PropertyName + "</label></div><div class='float-l'><input class='w230' type='text' onclick='SelectBrandValue(event)' onblur='UserDefineBrand(event)' onchange='GetChildTemplate(event,\"" + strRes + "\");GetSubPropertyForBrand(event," + categoryID + ");' onpropertychange='GetChildTemplate(event,\"" + strRes + "\");GetSubPropertyForBrand(event," + categoryID + ");' id='brandProperty" + $currentObj.PropertyID + "'  value='可直接输入或选择' key='" + $currentObj.PropertyID + "' /><div id='dvBrandPropertyValue" + $currentObj.PropertyID + "' style='width:400px;  height:auto;max-height:350px; overflow-y:auto;overflow-x:hidden; border:1px solid #cccccc;background-color:white;  position:absolute; z-index:10; display:none;' ></div></div><div class='float-l'><span class='prompt'></span></div></li>");
                        } else if ($currentObj.IsMust == false && $currentObj.IsInputProp == true && $currentObj.IsEnumProp == true) {//可选可输非必填

                            $propertyElement = $("<li class='list-li'><div class='float-l w130'>      <span class='star'></span><label>" + $currentObj.PropertyName + "</label></div><div class='float-l'><input class='w230' type='text' onclick='SelectBrandValue(event)' onblur='UserDefineBrand(event)' onchange='GetChildTemplate(event,\"" + strRes + "\");GetSubPropertyForBrand(event," + categoryID + ");' onpropertychange='GetChildTemplate(event,\"" + strRes + "\");GetSubPropertyForBrand(event," + categoryID + ")' id='brandProperty" + $currentObj.PropertyID + "' value='可直接输入或选择' key='" + $currentObj.PropertyID + "' /><div id='dvBrandPropertyValue" + $currentObj.PropertyID + "' style='width:400px;  height:auto;max-height:350px; overflow-y:auto;overflow-x:hidden; border:1px solid #cccccc;background-color:white;  position:absolute; z-index:10; display:none;' ></div></div><div class='float-l'><span class='prompt'></span></div></li>");
                        } else if ($currentObj.IsEnumProp == true && $currentObj.IsInputProp == false && $currentObj.IsMust == false) {//不可填可选

                            $propertyElement = $("<li class='list-li'><div class='float-l w130'>      <span class='star'></span><label>" + $currentObj.PropertyName + "</label></div><div class='float-l'><select class='w230' id='brandProperty" + $currentObj.PropertyID + "' onchange='GetSubProperty(event," + categoryID + ")' onpropertychange='GetSubProperty(event," + categoryID + ")'><option></option></select></div><div class='float-l'><span class='prompt'></span></div></li>");
                        } else if ($currentObj.IsEnumProp == true && $currentObj.IsInputProp == false && $currentObj.IsMust == true) {//不可填可选必需

                            $propertyElement = $("<li class='list-li'><div class='float-l w130'>      <span class='star'>*</span><label>" + $currentObj.PropertyName + "</label></div><div class='float-l'><select class='w230' id='brandProperty" + $currentObj.PropertyID + "' onchange='GetSubProperty(event," + categoryID + ")' onpropertychange='GetSubProperty(event," + categoryID + ")'><option></option></select></div><div class='float-l'><span class='prompt'></span></div></li>");
                        }
                        $("#" + containerID + "").append($propertyElement);
                        //加载品牌的选择值
                        $.ajax({
                            url: "../../Category/PropertyValues",
                            type: "get",
                            data: { "categoryID": categoryID, "propertyID": $currentObj.PropertyID },
                            async: false,
                            success: function (res2) {
                                var jsonRes2 = JSON.parse(res2);
                                for (var j = 0; j < jsonRes2.length; j++) {
                                    var $brandValue = $("<div id='" + jsonRes2[j].PropertyValueID + "' key='" + $currentObj.PropertyID + "' style='width:100%;height:auto;line-height:20px;' onclick='SelectThisBrand(event)' isParent='" + jsonRes2[j].IsParent + "'>" + jsonRes2[j].ValueName + "</div>")
                                    //alert(jsonRes2[j].ValueName);
                                    $("#dvBrandPropertyValue" + $currentObj.PropertyID).append($brandValue);
                                }
                            },
                            error: function () {
                                $(".Loading").removeClass("style0green style0yellow").addClass("style0red");
                                $("#operateTip").html("error").change();
                            }
                        })
                        //}
                    }

                    if ($currentObj.IsEnumProp == true) {//如果是下拉框，循环出它下面的项
                        $.ajax({
                            url: "../../Category/PropertyValues",
                            type: "get",
                            data: { "categoryID": categoryID, "propertyID": $currentObj.PropertyID },
                            async: false,
                            success: function (res2) {
                                var jsonRes2 = JSON.parse(res2);
                                for (var j = 0; j < jsonRes2.length; j++) {
                                    var $option2 = $("<option value='" + jsonRes2[j].PropertyValueID + "' isParent='" + jsonRes2[j].IsParent + "'>" + jsonRes2[j].ValueName + "</option>"); //属性的ID和值都存在option中,isParent为true的项要加载它的子项
                                    $("#brandProperty" + jsonRes2[j].PropertyID + "").append($option2);
                                }
                            },
                            error: function () {
                                $(".Loading").removeClass("style0green style0yellow").addClass("style0red");
                                $("#operateTip").html("error").change();
                            }
                        })
                    }
                    if ($currentObj.IsItemProp == true && $currentObj.IsMulti == true) {//例举项，可多选，用复选框
                        $.ajax({
                            url: "../../Category/PropertyValues",
                            type: "get",
                            data: { "categoryID": categoryID, "propertyID": $currentObj.PropertyID },
                            async: false,
                            success: function (res2) {
                                var jsonRes2 = JSON.parse(res2);
                                for (var j = 0; j < jsonRes2.length; j++) {
                                    var $checkbox = $("<div style='float:left;width:150px;height:35px;line-height:35px;'><input type='checkbox' value='" + jsonRes2[j].PropertyValueID + "'/> <span>" + jsonRes2[j].ValueName + "</span></div>");
                                    $("#brandProperty" + jsonRes2[j].PropertyID + "").append($checkbox);
                                }
                            },
                            error: function () {
                                $(".Loading").removeClass("style0green style0yellow").addClass("style0red");
                                $("#operateTip").html("error").change();
                            }
                        })
                    } else if ($currentObj.IsItemProp == true && $currentObj.IsMulti == false) {//例举项，不可多选，用单选框
                        $.ajax({
                            url: "../../Category/PropertyValues",
                            type: "get",
                            data: { "categoryID": categoryID, "propertyID": $currentObj.PropertyID },
                            async: false,
                            success: function (res2) {
                                var jsonRes2 = JSON.parse(res2);
                                for (var j = 0; j < jsonRes2.length; j++) {
                                    var $radio = $("<div style='float:left;width:150px;height:35px;line-height:35px;'><input type='radio' name='checkItem' value='" + jsonRes2[j].PropertyValueID + "'/> <span>" + jsonRes2[j].ValueName + "</span></div>");
                                    $("#brandProperty" + jsonRes2[j].PropertyID + "").append($radio);
                                }
                            },
                            error: function () {
                                $(".Loading").removeClass("style0green style0yellow").addClass("style0red");
                                $("#operateTip").html("error").change();
                            }
                        })
                    }

                }
            }
        },
        error: function () {
            $(".Loading").removeClass("style0green style0yellow").addClass("style0red");
            $("#operateTip").html("获取类目属性出错").change();
        }
    })


    //为二级属性添加这段方法，取出该类目下所有的商品属性
    $.ajax({
        url: "../../Category/GetAllPropertiesByCategory",
        type: "get",
        data: { "categoryID": categoryID },
        async: false,
        success: function (res) {
            //alert(res);
            jsonPropertyByCategoty = JSON.parse(res);
        },
        error: function () {
            $(".Loading").removeClass("style0green style0yellow").addClass("style0red");
            $("#operateTip").html("获取类目全部属性时出错").change();
        }
    })
}

function GetSpec(containerID, categoryID) {
    $("#" + containerID + "").html(""); //重新加载规格，将原有规格清空
    if (containerID == "specContainer") {
        InitSelectThisSpec(containerID); //重新加载规格，将原有规格组合表格#specCombineTable清空
    }

    $.ajax({
        url: "../../Category/Specs",
        type: "get",
        data: { "categoryID": categoryID },
        async: false,
        success: function (res) {
            if (res.length != 2) {//等于2时是空数组“[]”
                //                var $contentTitle = $("<div style='font-size:14pt;font-weight:600;'>商品规格:</div>")
                //                $("#" + containerID + "").append($contentTitle);
                if (categoryID == 50015594) {//为汽车类目是只加载颜色分类
                    res = '[{"SpecID":1627207,"SpecName":"颜色分类","IsMulti":true,"IsMust":false}]';
                }
                var jsonRes = JSON.parse(res);
                for (var i = 0; i < jsonRes.length; i++) {

                    var $div = "";
                    if (jsonRes[i].IsMulti == true) {//是可多选的
                        if (jsonRes[i].IsMust == true) {//是必填的

                            $div = $("<li class='list-li'><div id='specID" + jsonRes[i].SpecID + "' class='float-l w130 specName'>      <span class='star'>*</span><label>" + jsonRes[i].SpecName + "</label></div><div class='float-l specValueContainer'style='width:700px;float:left;' id='spec" + jsonRes[i].SpecID + "'></div><div class='float-l'><span class='prompt'></span></div></li>");
                        } else {//不是必填的

                            $div = $("<li class='list-li'><div id='specID" + jsonRes[i].SpecID + "' class='float-l w130 specName'>      <span class='star'></span><label>" + jsonRes[i].SpecName + "</label></div><div class='float-l specValueContainer'style='width:700px;float:left;' id='spec" + jsonRes[i].SpecID + "'></div><div class='float-l'><span class='prompt'></span></div></li>");
                        }
                    } else {
                        $div = $("<div>不可多选的规格，待修改</div>");
                    }
                    $("#" + containerID + "").append($div);
                    //if (jsonRes[i].SpecName != "适用车型" || jsonRes[i].SpecName != "适合车系") {//不加载适合车系
                    $.ajax({
                        url: "../../Category/SpecValues",
                        type: "get",
                        data: { "categoryID": categoryID, "specID": jsonRes[i].SpecID },
                        async: false,
                        success: function (res2) {
                            if (res2 != null) {
                                var jsonRes2 = JSON.parse(res2);
                                for (var j = 0; j < jsonRes2.length; j++) {
                                    var $specValue = $("<div style='float:left;width:150px;height:35px;line-height:35px;'><input type='checkbox' value='" + jsonRes2[j].SpecValueID + "' onclick='SelectThisSpec(event," + categoryID + ",\"" + containerID + "\")' IsAllowAlias='" + jsonRes2[j].IsAllowAlias + "'/> <span>" + jsonRes2[j].SpecValue + "</span><input type='text' value='" + jsonRes2[j].SpecValue + "' style='width:110px; display:none;' onblur='ChangeThisSpecName(event,\"" + containerID + "\")' /></div>");
                                    $("#" + containerID + " #spec" + jsonRes2[j].SpecID + "").append($specValue);
                                }
                            }
                        },
                        error: function () {
                            $(".Loading").removeClass("style0green style0yellow").addClass("style0red");
                            $("#operateTip").html("error").change();
                        }
                    })
                }
                //}
            }
        },
        error: function () {
            $(".Loading").removeClass("style0green style0yellow").addClass("style0red");
            $("#operateTip").html("获取类目规格出错").change();
        }
    })


}

//重新选择商品类目即意味着商品规格的重新加载，所以要将SelectThisSpec()方法用到的全局变量初始化
function InitSelectThisSpec(containerID) {
    clickTimes = 0;
    createFlag = 0;
    $("#specColorTable").css("display", "none"); //设置颜色图片编辑表格隐藏
    $("#specColorTable tr:not(:first)").remove();
    $("#specCombineTable tr:not(:first)").remove();
    $("#specCombineTable tr:first td").remove();
}

//初始化分销规格显示模块
function InitSelectThisSpecForDestributon(containerID) {
    clickTimes = 0;
    createFlag = 0;

    $("#specCombineTable tr:not(:first)").remove();
    $("#specCombineTable tr:first td").remove();
}

//初始化淘宝规格显示模块
function InitSelectThisSpecForTaobao(containerID) {
    clickTimes = 0;
    createFlag = 0;

    $("#specCombineTable tr:not(:first)").remove();
    $("#specCombineTable tr:first td").remove();

    $(".prompt:last", $(".specContainerForTaobao")).text(""); //清除规格组合表的提示信息
}

var clickTimes = 0; //标记点击规格checkbox的点击次数
var createFlag = 0; //标记表头行是否已经创建
function SelectThisSpec(event, categoryID, containerID) {
    if (containerID != "specContainerForDestribution") { //-----------------------------------------------不是分销的规格组合表
        event = event ? event : window.event;
        var eventSrc = event.srcElement ? event.srcElement : event.target;

        //是否支持自定义规格别名
        if ($(eventSrc).attr("checked") == "checked") {
            //点选一个规格值，将其值可编辑（span隐藏，input文本框显示）
            $("label", $(eventSrc).parent()).hide();
            $("input[type=text]", $(eventSrc).parent()).css("display", "inline");
        } else {
            //取消一个规格值，将其值可编辑（span显示，input文本框隐藏）
            $("label", $(eventSrc).parent()).css("display", "inline");
            $("input[type=text]", $(eventSrc).parent()).css("display", "none");
        }


        clickTimes++;
        if (eventSrc != undefined) {
            var $specID = $(eventSrc).parent().parent().parent().attr("id");
            if ($specID == "1627207") {
                var flag = 0;
                $("#spec1627207 input[type=checkbox]").each(function () { //遍历所有的颜色规格，淘宝的颜色规格ID固定是1627207
                    if ($(this).attr("checked") == "checked") {
                        flag++;
                    }
                })
                //if (flag == 0) {
                //    $("#specColorTable").css("display", "none"); //根据上面遍历的结果，设置颜色图片编辑表格的显示/隐藏
                //} else {
                //    //$("#specColorTable").css("display", "block");//---------------------------------自定义规格图片功能暂时没有实现，先注释掉了
                //    $("#specColorTable").css("display", "none");
                //}

                ////颜色图片编辑表格行的增减
                //if ($(eventSrc).attr("checked") == "checked") {
                //    var tr = $("<tr><td id='" + $(eventSrc).val() + "' style='width:120px;'>" + $(eventSrc).siblings("span").text() + "</td><td><input type='file' /></td></tr>");
                //    $("#specColorTable").append(tr);
                //} else {
                //    $("#specColorTable td").each(function () {
                //        if ($(this).attr("id") == $(eventSrc).val()) {
                //            $(this).parent("tr").remove();
                //        }
                //    })
                //}
            }
        }

        //所有规格checkbox点击触发
        //$("#specCombineTable").text("");
        var flag = 0;
        var flag2 = 0;
        var flag3 = 0;
        // $("#specCombineTable").append(tr);
        $("." + containerID + " #" + containerID + " .control-label").each(function () {
            flag++;
            flag2 = 0;
            var text = $(this).text();
            $("input[type=checkbox]", $(this).parent()).each(function () {
                if ($(this).attr("checked") == "checked") {
                    flag2++;
                }
            });
            if (flag2 > 0) {
                flag3++;
            }
            if (clickTimes == 1) {
                var td = $("<th>" + $(this).text() + "</th>");
                $("#specCombineTable tr:first").append(td);
            }
        });

        if (flag == flag3 && createFlag == 0) {//flag == flag3 表示所有的规格都选全了 createFlag == 0表示还没有创建过表头行
            var td = $("<th style='display:none;'>SKU标签</th><th>价格<input type='checkbox' onclick='SetSamePrice(event,\"" + containerID + "\")'/></th><th>数量</th><th>商家编码</th>");
            $(" #specCombineTable tr:first").append(td);
            createFlag = 1;
        }

        if (flag == flag3) { //所有的规格信息都至少选择了一项，让规格编辑表格显示，否则隐藏
            $("#specCombineTable").show();
        } else {
            $(" #specCombineTable").hide();
            $(".prompt", $(" #specCombineTable").parents("li")).text(""); //表格隐藏时将提示信息清空
        }

        //创建规格填写行（即#specCombineTable里面的除了表头以外的数据行）
        var v1 = []; v2 = []; v3 = []; v4 = []; v5 = []; //假设最多有五个规格
        var spec = $("#" + containerID + " .control-label");
        var specID = 0;
        //    var dd1 = spec[0]; dd2 = spec[1]; dd3 = spec[2]; dd4 = spec[3]; dd5 = spec[4];
        //var dd1 = $(spec[0]); dd2 = spec[1]; dd3 = $(spec[2]); dd4 = spec[3]; dd5 = spec[4];
        if (spec[0] != undefined) {
            $("input[type=checkbox]", $(spec[0]).parent()).each(function () {
                specID = $(spec[0]).attr("id").replace(/\D/g, '');
                if ($(this).attr("checked") == "checked") {
                    var key0 = $(this).val();
                    var value0 = $(this).siblings("input").val();
                    var json0 = { key: key0, value: value0, specID: specID };
                    v1.push(json0);
                }
            })
            if (spec[1] != undefined) {
                $("input[type=checkbox]", $(spec[1]).parent()).each(function () {
                    specID = $(spec[1]).attr("id").replace(/\D/g, '');
                    if ($(this).attr("checked") == "checked") {
                        var key1 = $(this).val();
                        var value1 = $(this).siblings("input").val();
                        var json1 = { key: key1, value: value1, specID: specID };
                        v2.push(json1);
                    }
                })
                if (spec[2] != undefined) {
                    $("input[type=checkbox]", $(spec[2]).parent()).each(function () {
                        specID = $(spec[2]).attr("id").replace(/\D/g, '');
                        if ($(this).attr("checked") == "checked") {
                            var key2 = $(this).val();
                            var value2 = $(this).siblings("input").val();
                            var json2 = { key: key2, value: value2, specID: specID };
                            v3.push(json2);
                        }
                    })
                    if (spec[3] != undefined) {
                        $("input[type=checkbox]", $(spec[3]).parent()).each(function () {
                            specID = $(spec[3]).attr("id").replace(/\D/g, '');
                            if ($(this).attr("checked") == "checked") {
                                var key3 = $(this).val();
                                var value3 = $(this).siblings("input").val();
                                var json3 = { key: key3, value: value3, specID: specID };
                                v4.push(json3);
                            }
                        })
                        if (spec[4] != undefined) {
                            $("input[type=checkbox]", $(spec[4]).parent()).each(function () {
                                specID = $(spec[4]).attr("id").replace(/\D/g, '');
                                if ($(this).attr("checked") == "checked") {
                                    var key4 = $(this).val();
                                    var value4 = $(this).siblings("input").val();
                                    var json4 = { key: key4, value: value4, specID: specID };
                                    v5.push(json4);
                                }
                            })
                        }
                    }
                }
            }
        }

        if (flag == flag3) {
            if ($(eventSrc).attr("checked") == "checked") {
                var existed = false;
                if (v1.length > 0 && v2.length == 0) {//只有一个规格
                    for (var i = 0; i < v1.length; i++) {
                        //看表格里是否已经存在该行，如果存在了就不添加这一行了
                        existed = false;
                        $(" #specCombineTable tr td[id]").each(function () {
                            if ($(this).attr("id") == v1[i].key) existed = true;
                        })
                        if (existed == false) {
                            var tr = $("<tr><td id='" + v1[i].key + "' specID='" + v1[i].specID + "' class='specMark'>" + v1[i].value + "</td><td style='display:none;' id='" + v1[i].key + "' class='specConbineMark'>" + v1[i].value + "</td><td><input id='txtPrice' class='input-mini' type='text' /></td><td><input id='txtCount' class='input-mini' type='text' onblur='SumProductCount(\"" + containerID + "\")' /></td><td><input class='input-mini' id='txtProductCode' type='text' /><input class='thisSKUCode' type='hidden' /></td></tr>");
                            $(" #specCombineTable").append(tr);
                        }
                    }
                } else if (v2.length > 0 && v3.length == 0) {//有两个规格
                    for (var i = 0; i < v1.length; i++) {
                        for (var j = 0; j < v2.length; j++) {
                            //看表格里是否已经存在该行，如果存在了就不添加这一行了
                            existed = false;
                            $(" #specCombineTable tr td[id]").each(function () {
                                if ($(this).attr("id") == v1[i].key + "-" + v2[j].key) existed = true;
                            })
                            if (existed == false) {
                                var tr = $("<tr><td id='" + v1[i].key + "' specID='" + v1[i].specID + "' class='specMark'>" + v1[i].value + "</td><td id='" + v2[j].key + "' specID='" + v2[j].specID + "' class='specMark'>" + v2[j].value + "</td><td style='display:none;' id='" + v1[i].key + "-" + v2[j].key + "' class='specConbineMark'>" + v1[i].value + "-" + v2[j].value + "</td><td><input id='txtPrice' class='input-mini' type='text' onblur='PriceFormat(event)' /></td><td><input class='input-mini' id='txtCount' type='text' onblur='SumProductCount(\"" + containerID + "\")' /></td><td><input class='input-mini' id='txtProductCode' type='text' /><input class='thisSKUCode' type='hidden' /></td></tr>");
                                $(" #specCombineTable").append(tr);
                            }
                        }
                    }
                } else if (v3.length > 0 && v4.length == 0) {//有三个规格
                    for (var i = 0; i < v1.length; i++) {
                        for (var j = 0; j < v2.length; j++) {
                            for (var k = 0; k < v3.length; k++) {
                                existed = false;
                                $(" #specCombineTable tr td[id]").each(function () {
                                    if ($(this).attr("id") == v1[i].key + "-" + v2[j].key + "-" + v3[k].key) existed = true;
                                })
                                if (existed == false) {
                                    var tr = $("<tr><td id='" + v1[i].key + "' specID='" + v1[i].specID + "' class='specMark'>" + v1[i].value + "</td><td id='" + v2[j].key + "' specID='" + v2[j].specID + "' class='specMark'>" + v2[j].value + "</td><td id='" + v3[k].key + "' specID='" + v3[k].specID + "' class='specMark'>" + v3[k].value + "</td><td style='display:none;' id='" + v1[i].key + "-" + v2[j].key + "-" + v3[k].key + "' class='specConbineMark'>" + v1[i].value + "-" + v2[j].value + "-" + v3[k].value + "</td><td><input id='txtPrice' class='input-mini' type='text' onblur='PriceFormat(event)' /></td><td><input class='input-mini' id='txtCount' type='text' onblur='SumProductCount(\"" + containerID + "\")'/></td><td><input class='input-mini' id='txtProductCode' type='text' /><input class='thisSKUCode' type='hidden' /></td></tr>");
                                    $(" #specCombineTable").append(tr);
                                }
                            }
                        }
                    }

                } else if (v4.length > 0 && v5.length == 0) {//有四个规格
                    for (var i = 0; i < v1.length; i++) {
                        for (var j = 0; j < v2.length; j++) {
                            for (var k = 0; k < v3.length; k++) {
                                for (var m = 0; m < v4.length; m++) {
                                    existed = false;
                                    $(" #specCombineTable tr td[id]").each(function () {
                                        if ($(this).attr("id") == v1[i].key + "-" + v2[j].key + "-" + v3[k].key + "-" + v4[m].key) existed = true;
                                    })
                                    if (existed == false) {
                                        var tr = $("<tr><td id='" + v1[i].key + "' specID='" + v1[i].specID + "' class='specMark'>" + v1[i].value + "</td><td id='" + v2[j].key + "' specID='" + v2[j].specID + "' class='specMark'>" + v2[j].value + "</td><td id='" + v3[k].key + "' specID='" + v3[k].specID + "' class='specMark'>" + v3[k].value + "</td><td id='" + v4[m].key + "' specID='" + v4[m].specID + "' class='specMark'>" + v4[m].value + "</td><td style='display:none;' id='" + v1[i].key + "-" + v2[j].key + "-" + v3[k].key + "-" + v4[m].key + "' class='specConbineMark'>" + v1[i].value + "-" + v2[j].value + "-" + v3[k].value + "-" + v4[m].value + "</td><td><input id='txtPrice' class='input-mini' type='text' onblur='PriceFormat(event)' /></td><td><input class='input-mini' id='txtCount' type='text' onblur='SumProductCount(\"" + containerID + "\")' /></td><td><input id='txtProductCode' class='input-mini' type='text' /><input class='thisSKUCode' type='hidden' /></td></tr>");
                                        $(" #specCombineTable").append(tr);
                                    }
                                }
                            }
                        }
                    }

                } else if (v5.length > 0) {//有五个规格
                    for (var i = 0; i < v1.length; i++) {
                        for (var j = 0; j < v2.length; j++) {
                            for (var k = 0; k < v3.length; k++) {
                                for (var m = 0; m < v4.length; m++) {
                                    for (var n = 0; n < v5.length; n++) {
                                        existed = false;
                                        $(" #specCombineTable tr td[id]").each(function () {
                                            if ($(this).attr("id") == v1[i].key + "-" + v2[j].key + "-" + v3[k].key + "-" + v4[m].key + "-" + v5[n].key) existed = true;
                                        })
                                        if (existed == false) {
                                            var tr = $("<tr><td id='" + v1[i].key + "' specID='" + v1[i].specID + "' class='specMark'>" + v1[i].value + "</td><td id='" + v2[j].key + "' specID='" + v2[j].specID + "' class='specMark'>" + v2[j].value + "</td><td id='" + v3[k].key + "' specID='" + v3[k].specID + "' class='specMark'>" + v3[k].value + "</td><td id='" + v4[m].key + "' specID='" + v4[m].specID + "' class='specMark'>" + v4[m].value + "</td><td id='" + v5[n].key + "' specID='" + v5[n].specID + "' class='specMark'>" + v5[n].value + "</td><td style='display:none;' id='" + v1[i].key + "-" + v2[j].key + "-" + v3[k].key + "-" + v4[m].key + "-" + v5[n].key + "' class='specConbineMark'>" + v1[i].value + "-" + v2[j].value + "-" + v3[k].value + "-" + v4[m].value + "-" + v5[n].value + "</td><td><input id='txtPrice' class='input-mini' type='text' onblur='PriceFormat(event)'/></td><td><input id='txtCount' class='input-mini' type='text' onblur='SumProductCount(\"" + containerID + "\")'/></td><td><input class='input-mini' id='txtProductCode' type='text' /><input class='thisSKUCode' type='hidden' /></td></tr>");
                                            $(" #specCombineTable").append(tr);
                                        }
                                    }
                                }
                            }
                        }
                    }

                }

                //点击规格组合之后，如果规格组合表格显示，将商品数量文本框设为只读，它的值有sku表格中的数量相加得到
                if ($(" #specCombineTable").css("display") == "block") {
                    $("#txtProductCount").attr("readonly", "readonly");
                }


            } else {//取消一个规格值，将表格中含有该属性的tr去除
                var itsID = $(eventSrc).val();
                $(" #specCombineTable tr td[id]").each(function () {
                    if ($(this).attr("id") == itsID) {
                        $(this).parent("tr").remove();
                    }
                })

            }
        }



    } else { //------------------------------------------------------------------------------------------是分销的规格组合表
        event = event ? event : window.event;
        var eventSrc = event.srcElement ? event.srcElement : event.target;

        clickTimes++;

        var $specID = $(eventSrc).parent().parent().attr("id");
        if ($specID == "1627207") {
            var flag = 0;
            $("#" + containerID + " #spec1627207 input[type=checkbox]").each(function () {//遍历所有的颜色规格，淘宝的颜色规格ID固定是1627207
                if ($(this).attr("checked") == "checked") {
                    flag++;
                }
            })
            if (flag == 0) {
                $("#specColorTable").css("display", "none"); //根据上面遍历的结果，设置颜色图片编辑表格的显示/隐藏
            } else {
                //$("#specColorTable").css("display", "block");//---------------------------------自定义规格图片功能暂时没有实现，先注释掉了
                $("#specColorTable").css("display", "none");
            }

            //颜色图片编辑表格行的增减
            if ($(eventSrc).attr("checked") == "checked") {
                var tr = $("<tr><td id='" + $(eventSrc).val() + "' style='width:120px;'>" + $(eventSrc).siblings("span").text() + "</td><td><input type='file' /></td></tr>");
                $("#specColorTable").append(tr);
            } else {
                $("#specColorTable td").each(function () {
                    if ($(this).attr("id") == $(eventSrc).val()) {
                        $(this).parent("tr").remove();
                    }
                });
            };
        }

        //所有规格checkbox点击触发
        //$("#specCombineTable").text("");
        var flag = 0;
        var flag2 = 0;
        var flag3 = 0;
        // $("#specCombineTable").append(tr);
        $("." + containerID + " #" + containerID + " .specName").each(function () {
            flag++;
            flag2 = 0;
            var text = $(this).text();
            $("input[type=checkbox]", $(this).parent()).each(function () {
                if ($(this).attr("checked") == "checked") {
                    flag2++;
                }
            });
            if (flag2 > 0) {
                flag3++;
            }
            if (clickTimes == 1) {
                var td = $("<td>" + $(this).text() + "</td>");
                $(" #specCombineTable tr:first").append(td);
            }
        });

        if (flag == flag3 && createFlag == 0) {
            var td = $("<td style='display:none;'>SKU标签</td><td>代销商采购价<input id='cbxDaixiaoPrice' type='checkbox' onclick='SetSamePrice(event,\"" + containerID + "\")'/></td><td>经销商采购价<input id='cbxJingxiaoPrice' type='checkbox' onclick='SetSamePrice(event,\"" + containerID + "\")'/></td><td>建议零售价<input id='cbxLingshouPrice' type='checkbox' onclick='SetSamePrice(event,\"" + containerID + "\")'/></td><td>数量</td><td>商家编码</td>");
            $(" #specCombineTable tr:first").append(td);
            createFlag = 1;
        }

        if (flag == flag3) { //所有的规格信息都至少选择了一项，让规格编辑表格显示，否则隐藏
            $(" #specCombineTable").css("display", "block");
        } else {
            $(" #specCombineTable").css("display", "none");
        }

        //创建规格填写行（即#specCombineTable里面的除了表头以外的数据行）
        var v1 = []; v2 = []; v3 = []; v4 = []; v5 = []; //假设最多有五个规格
        var spec = $("#" + containerID + " .specName");
        var specID = 0;
        //    var dd1 = spec[0]; dd2 = spec[1]; dd3 = spec[2]; dd4 = spec[3]; dd5 = spec[4];
        //var dd1 = $(spec[0]); dd2 = spec[1]; dd3 = $(spec[2]); dd4 = spec[3]; dd5 = spec[4];
        if (spec[0] != undefined) {
            $("input[type=checkbox]", $(spec[0]).parent()).each(function () {
                specID = $(spec[0]).attr("id").replace(/\D/g, '');
                if ($(this).attr("checked") == "checked") {
                    var key0 = $(this).val();
                    var value0 = $(this).siblings("input").val();
                    var json0 = { key: key0, value: value0, specID: specID };
                    v1.push(json0);
                }
            });
            if (spec[1] != undefined) {
                $("input[type=checkbox]", $(spec[1]).parent()).each(function () {
                    specID = $(spec[1]).attr("id").replace(/\D/g, '');
                    if ($(this).attr("checked") == "checked") {
                        var key1 = $(this).val();
                        var value1 = $(this).siblings("input").val();
                        var json1 = { key: key1, value: value1, specID: specID };
                        v2.push(json1);
                    }
                });
                if (spec[2] != undefined) {
                    $("input[type=checkbox]", $(spec[2]).parent()).each(function () {
                        specID = $(spec[2]).attr("id").replace(/\D/g, '');
                        if ($(this).attr("checked") == "checked") {
                            var key2 = $(this).val();
                            var value2 = $(this).siblings("input").val();
                            var json2 = { key: key2, value: value2, specID: specID };
                            v3.push(json2);
                        }
                    });
                    if (spec[3] != undefined) {
                        $("input[type=checkbox]", $(spec[3]).parent()).each(function () {
                            specID = $(spec[3]).attr("id").replace(/\D/g, '');
                            if ($(this).attr("checked") == "checked") {
                                var key3 = $(this).val();
                                var value3 = $(this).siblings("input").val();
                                var json3 = { key: key3, value: value3, specID: specID };
                                v4.push(json3);
                            }
                        });
                        if (spec[4] != undefined) {
                            $("input[type=checkbox]", $(spec[4]).parent()).each(function () {
                                specID = $(spec[4]).attr("id").replace(/\D/g, '');
                                if ($(this).attr("checked") == "checked") {
                                    var key4 = $(this).val();
                                    var value4 = $(this).siblings("input").val();
                                    var json4 = { key: key4, value: value4, specID: specID };
                                    v5.push(json4);
                                }
                            });
                        }
                    }
                }
            }
        }

        if (flag == flag3) {
            if ($(eventSrc).attr("checked") == "checked") {
                var existed = false;
                if (v1.length > 0 && v2.length == 0) {//只有一个规格
                    for (var i = 0; i < v1.length; i++) {
                        //看表格里是否已经存在该行，如果存在了就不添加这一行了
                        existed = false;
                        $(" #specCombineTable tr td[id]").each(function () {
                            if ($(this).attr("id") == v1[i].key) existed = true;
                        })
                        if (existed == false) {
                            var tr = $("<tr><td id='" + v1[i].key + "' specID='" + v1[i].specID + "' class='specMark'>" + v1[i].value + "</td><td style='display:none;' id='" + v1[i].key + "' class='specConbineMark'>" + v1[i].value + "</td><td><input id='txtDaixiaoPrice' type='text' onblur='PriceFormat(event)'/></td><td><input id='txtJingxiaoPrice' type='text' onblur='PriceFormat(event)'/></td><td><input id='txtLingshouPrice' type='text' onblur='PriceFormat(event)' readonly='readonly'/></td><td><input id='txtCount' type='text' onblur='SumProductCount(\"" + containerID + "\")' /></td><td><input id='txtProductCode' type='text' /><input class='thisSKUCode' type='hidden' /></td></tr>");
                            $(" #specCombineTable").append(tr);
                        }
                    }
                } else if (v2.length > 0 && v3.length == 0) {//有两个规格
                    for (var i = 0; i < v1.length; i++) {
                        for (var j = 0; j < v2.length; j++) {
                            //看表格里是否已经存在该行，如果存在了就不添加这一行了
                            existed = false;
                            $("#specCombineTable tr td[id]").each(function () {
                                if ($(this).attr("id") == v1[i].key + "-" + v2[j].key) existed = true;
                            })
                            if (existed == false) {
                                var tr = $("<tr><td id='" + v1[i].key + "' specID='" + v1[i].specID + "' class='specMark'>" + v1[i].value + "</td><td id='" + v2[j].key + "' specID='" + v2[j].specID + "' class='specMark'>" + v2[j].value + "</td><td style='display:none;' id='" + v1[i].key + "-" + v2[j].key + "' class='specConbineMark'>" + v1[i].value + "-" + v2[j].value + "</td><td><input id='txtDaixiaoPrice' type='text' onblur='PriceFormat(event)'/></td><td><input id='txtJingxiaoPrice' type='text' onblur='PriceFormat(event)'/></td><td><input id='txtLingshouPrice' type='text' onblur='PriceFormat(event)' readonly='readonly'/></td><td><input id='txtCount' type='text' onblur='SumProductCount(\"" + containerID + "\")' /></td><td><input id='txtProductCode' type='text' /><input class='thisSKUCode' type='hidden' /></td></tr>");
                                $("#specCombineTable").append(tr);
                            }
                        }
                    }
                } else if (v3.length > 0 && v4.length == 0) {//有三个规格
                    for (var i = 0; i < v1.length; i++) {
                        for (var j = 0; j < v2.length; j++) {
                            for (var k = 0; k < v3.length; k++) {
                                existed = false;
                                $("#specCombineTable tr td[id]").each(function () {
                                    if ($(this).attr("id") == v1[i].key + "-" + v2[j].key + "-" + v3[k].key) existed = true;
                                })
                                if (existed == false) {
                                    var tr = $("<tr><td id='" + v1[i].key + "' specID='" + v1[i].specID + "' class='specMark'>" + v1[i].value + "</td><td id='" + v2[j].key + "' specID='" + v2[j].specID + "' class='specMark'>" + v2[j].value + "</td><td id='" + v3[k].key + "' specID='" + v3[k].specID + "' class='specMark'>" + v3[k].value + "</td><td style='display:none;' id='" + v1[i].key + "-" + v2[j].key + "-" + v3[k].key + "' class='specConbineMark'>" + v1[i].value + "-" + v2[j].value + "-" + v3[k].value + "</td><td><input id='txtDaixiaoPrice' type='text' onblur='PriceFormat(event)'/></td><td><input id='txtJingxiaoPrice' type='text' onblur='PriceFormat(event)'/></td><td><input id='txtLingshouPrice' type='text' onblur='PriceFormat(event)' readonly='readonly'/></td><td><input id='txtCount' type='text' onblur='SumProductCount(\"" + containerID + "\")'/></td><td><input id='txtProductCode' type='text' /><input class='thisSKUCode' type='hidden' /></td></tr>");
                                    $("#specCombineTable").append(tr);
                                }
                            }
                        }
                    }

                } else if (v4.length > 0 && v5.length == 0) {//有四个规格
                    for (var i = 0; i < v1.length; i++) {
                        for (var j = 0; j < v2.length; j++) {
                            for (var k = 0; k < v3.length; k++) {
                                for (var m = 0; m < v4.length; m++) {
                                    existed = false;
                                    $("#specCombineTable tr td[id]").each(function () {
                                        if ($(this).attr("id") == v1[i].key + "-" + v2[j].key + "-" + v3[k].key + "-" + v4[m].key) existed = true;
                                    })
                                    if (existed == false) {
                                        var tr = $("<tr><td id='" + v1[i].key + "' specID='" + v1[i].specID + "' class='specMark'>" + v1[i].value + "</td><td id='" + v2[j].key + "' specID='" + v2[j].specID + "' class='specMark'>" + v2[j].value + "</td><td id='" + v3[k].key + "' specID='" + v3[k].specID + "' class='specMark'>" + v3[k].value + "</td><td id='" + v4[m].key + "' specID='" + v4[m].specID + "' class='specMark'>" + v4[m].value + "</td><td style='display:none;' id='" + v1[i].key + "-" + v2[j].key + "-" + v3[k].key + "-" + v4[m].key + "' class='specConbineMark'>" + v1[i].value + "-" + v2[j].value + "-" + v3[k].value + "-" + v4[m].value + "</td><td><input id='txtDaixiaoPrice' type='text' onblur='PriceFormat(event)'/></td><td><input id='txtJingxiaoPrice' type='text' onblur='PriceFormat(event)'/></td><td><input id='txtLingshouPrice' type='text' onblur='PriceFormat(event)' readonly='readonly'/></td><td><input id='txtCount' type='text' onblur='SumProductCount(\"" + containerID + "\")' /></td><td><input id='txtProductCode' type='text' /><input class='thisSKUCode' type='hidden' /></td></tr>");
                                        $("#specCombineTable").append(tr);
                                    }
                                }
                            }
                        }
                    }

                } else if (v5.length > 0) {//有五个规格
                    for (var i = 0; i < v1.length; i++) {
                        for (var j = 0; j < v2.length; j++) {
                            for (var k = 0; k < v3.length; k++) {
                                for (var m = 0; m < v4.length; m++) {
                                    for (var n = 0; n < v5.length; n++) {
                                        existed = false;
                                        $("#specCombineTable tr td[id]").each(function () {
                                            if ($(this).attr("id") == v1[i].key + "-" + v2[j].key + "-" + v3[k].key + "-" + v4[m].key + "-" + v5[n].key) existed = true;
                                        })
                                        if (existed == false) {
                                            var tr = $("<tr><td id='" + v1[i].key + "' specID='" + v1[i].specID + "' class='specMark'>" + v1[i].value + "</td><td id='" + v2[j].key + "' specID='" + v2[j].specID + "' class='specMark'>" + v2[j].value + "</td><td id='" + v3[k].key + "' specID='" + v3[k].specID + "' class='specMark'>" + v3[k].value + "</td><td id='" + v4[m].key + "' specID='" + v4[m].specID + "' class='specMark'>" + v4[m].value + "</td><td id='" + v5[n].key + "' specID='" + v5[n].specID + "' class='specMark'>" + v5[n].value + "</td><td style='display:none;' id='" + v1[i].key + "-" + v2[j].key + "-" + v3[k].key + "-" + v4[m].key + "-" + v5[n].key + "' class='specConbineMark'>" + v1[i].value + "-" + v2[j].value + "-" + v3[k].value + "-" + v4[m].value + "-" + v5[n].value + "</td><td><input id='txtDaixiaoPrice' type='text' onblur='PriceFormat(event)'/></td><td><input id='txtJingxiaoPrice' type='text' onblur='PriceFormat(event)'/></td><td><input id='txtLingshouPrice' type='text' onblur='PriceFormat(event)' readonly='readonly'/></td><td><input id='txtCount' type='text' onblur='SumProductCount(\"" + containerID + "\")'/></td><td><input id='txtProductCode' type='text' /><input class='thisSKUCode' type='hidden' /></td></tr>");
                                            $("#specCombineTable").append(tr);
                                        }
                                    }
                                }
                            }
                        }
                    }

                }

                //点击规格组合之后，如果规格组合表格显示，将商品数量文本框设为只读，它的值有sku表格中的数量相加得到
                if ($("#specCombineTable").css("display") == "block") {
                    $("#txtProductCount").attr("readonly", "readonly");
                }


            } else {//取消一个规格值，将表格中含有该属性的tr去除
                var itsID = $(eventSrc).val();
                $("#specCombineTable tr td[id]").each(function () {
                    if ($(this).attr("id") == itsID) {
                        $(this).parent("tr").remove();
                    }
                })

            }

        }

    }


    //取消一个规格值，如果规格组合表格不显示了，取消商品数量的readonly
    if ($("#specCombineTable").css("display") == "none") {
        $("#txtProductCount").removeAttr("readonly");
        //如果规格组合表格不显示了,它里面的数据行去除
        $("#specCombineTable tr:not(:first)").remove();
    }



    //匹配渠道商品sku的商家编码（不匹配平台，平台是可以手输修改的）
    if (containerID != "specContainer") {
        if ($("#specCombineTable tr", $(eventSrc).parent().parent().parent().parent().parent()).length > 1) {
            $("#specCombineTable tr:not(:first)", $(eventSrc).parent().parent().parent().parent().parent()).each(function () {
                var specValueMark = $("td[class=specConbineMark]", $(this)).attr("id");
                var goodsNo = "";
                $(".specContainer #specCombineTable tr:not(:first)").each(function () {
                    var specValueMark2 = $("td[class=specConbineMark]", $(this)).attr("id");
                    if (specValueMark == specValueMark2) {
                        goodsNo = $("#txtProductCode", $(this)).val();
                    }
                })
                $("#txtProductCode", $(this)).val(goodsNo).attr("disabled", "disabled");
            })
        }
    }

    //规格组合表所在ul的显示和隐藏控制
    if ($("#specCombineTable").css("display") == "block") {
        $("#specCombineTable").parents("ul").show();
    } else {
        $("#specCombineTable").parents("ul").hide();
    }
}

//将价格设置为一致
function SetSamePrice(event, containerID) {
    event = event ? event : window.event;
    var eventSrc = event.srcElement ? event.srcElement : event.target;
    if ($(eventSrc).attr("checked") == "checked") {//是选中的时候才去设置同样的值
        if ($(eventSrc).attr("id") == "cbxDaixiaoPrice") {
            var basePrice = $("#specCombineTable #txtDaixiaoPrice:first").val();
            var reg = /\./g;
            if (!reg.test(basePrice)) {
                basePrice = basePrice + ".00";
            }
            $("#specCombineTable #txtDaixiaoPrice").each(function () {
                $(this).val(basePrice);
            })
        } else if ($(eventSrc).attr("id") == "cbxJingxiaoPrice") {
            var basePrice = $("#specCombineTable #txtJingxiaoPrice:first").val();
            var reg = /\./g;
            if (!reg.test(basePrice)) {
                basePrice = basePrice + ".00";
            }
            $("#specCombineTable #txtJingxiaoPrice").each(function () {
                $(this).val(basePrice);
            })
        } else if ($(eventSrc).attr("id") == "cbxLingshouPrice") {
            var basePrice = $("#specCombineTable #txtLingshouPrice:first").val();
            var reg = /\./g;
            if (!reg.test(basePrice)) {
                basePrice = basePrice + ".00";
            }
            $("#specCombineTable #txtLingshouPrice").each(function () {
                $(this).val(basePrice);
            })
        } else {
            var basePrice = $("#specCombineTable #txtPrice:first").val();
            var reg = /\./g;
            if (!reg.test(basePrice)) {
                basePrice = basePrice + ".00";
            }
            $("#specCombineTable #txtPrice").each(function () {
                $(this).val(basePrice);
            })
        }
    }
}

function SumProductCount(containerID) {
    if (containerID == "specContainer") {
        var sumCount = 0;
        $("#specCombineTable tr input[id=txtCount]").each(function () {
            var count = $(this).val() == "" ? 0 : $(this).val();
            sumCount += parseInt(count);
        })
        $("#txtProductCount").val(sumCount);
    }
}

//选择品牌文本框点击
function SelectBrandValue(event) {
    stopBubble(event);
    event = event ? event : window.event;
    var eventSrc = event.srcElement ? event.srcElement : event.target;
    var key = $(eventSrc).attr("key");
    if ($("#dvBrandPropertyValue" + key + " div").length > 0) {//有可选择的品牌才显示
        $("#dvBrandPropertyValue" + key).css("display", "block");
    }

    if ($(eventSrc).val() == "可直接输入或选择") {
        $(eventSrc).val("");
    }
}

//自定义品牌，要消除原先选择的品牌ID
function UserDefineBrand(event) {
    event = event ? event : window.event;
    var eventSrc = event.srcElement ? event.srcElement : event.target;
    var thisBrandName = $(eventSrc).val();
    var key = $(eventSrc).attr("key");
    var flag = 0;
    var tempID = 0;
    $("#dvBrandPropertyValue" + key + " div").each(function () {
        if ($(this).text() == thisBrandName) {
            flag++;
            tempID = $(this).attr("id");
        }
    })
    if (flag == 0) {//没有找到匹配项
        $(eventSrc).attr("brandid", "0");
    } else {  //找到了匹配项
        $(eventSrc).attr("brandid", tempID);
    }
}

//阻止事件冒泡
function stopBubble(e) {
    if (e && e.stopPropagation)
        e.stopPropagation();
    else
        window.event.cancelBubble = true;
}

//选择了这个品牌
function SelectThisBrand(event) {
    event = event ? event : window.event;
    var eventSrc = event.srcElement ? event.srcElement : event.target;
    var brandID = $(eventSrc).attr("id");
    var brandName = $(eventSrc).text();
    var key = $(eventSrc).attr("key");
    $("#brandProperty" + key).val(brandName);
    $("#brandProperty" + key).attr("brandID", brandID);
    $("#dvBrandPropertyValue" + key).css("display", "none");
    $("#brandProperty" + key).change();
}

document.onclick = function myfunction() {
    $("div[id^=dvBrandPropertyValue]").css("display", "none");
    $("input[id^=brandProperty]").each(function () {
        if ($(this).val() == "") {
            $(this).val("可直接输入或选择");
            $(this).css("color", "Gray");
        } else if ($(this).val() == "可直接输入或选择") {
            $(this).css("color", "Gray");
        }
        else {
            $(this).css("color", "#222222");
        }
    });

}

//用户修改了规格的名称（即规格的显示文本，这个自定义的值只针对当前商品，不影响该类目的通用规格）
var markTimes = 0; //标记“绑定规格”时，一个别名文本框调用该事件的执行次数，暂时还不太清楚为什么会执行两次，我这里先让它跳过一次的执行
function ChangeThisSpecName(event, containerID) {
    //    markTimes++;
    //    if (markTimes > 1) {
    event = event ? event : window.event;
    var eventSrc = event.srcElement ? event.srcElement : event.target;
    if (eventSrc != undefined) {
        var oldSpecValue = $("span", $(eventSrc).parent()).text();
        var currentSpecValue = $(eventSrc).val().replace(/^\s/g, "").replace(/\s$/g, "");

        var regXiexian = /[\/]/g;

        var specValueID = $("input[type=checkbox]", $(eventSrc).parent()).val();
        if (currentSpecValue != "" && currentSpecValue != oldSpecValue) {
            //alert(currentSpecValue);

            if ($("input[type=checkbox]", $(eventSrc).parent()).attr("checked") == "checked") {
                //更改规格组合表里的该个规格的显示文本

                $("#specCombineTable tr:not(:first)").each(function () {
                    var temp = "";
                    $(".specMark", $(this)).each(function () {
                        if ($(this).attr("id") == specValueID) {
                            temp = $(this).text();
                            $(this).text(currentSpecValue);
                        }
                    });
                    var regXiexian = /[\/]/g;
                    var testRes = regXiexian.test(temp); //有斜线的话放进正则表达式前需要对其进行转义
                    if (testRes == true) {
                        temp = temp.replace(regXiexian, "\\/");
                    }
                    temp = temp.replace(/\(/g, "\\(").replace(/\)/g, "\\)"); //对括号进行转义
                    if (temp != "") {
                        var reg = eval("/" + temp + "/g"); //temp放进正则之前对里面的斜线（如果有的话，进行转义，淘宝规格的“男装”》“针织衫/毛衣”规格有斜线）
                        testRes = reg.test($(".specConbineMark", $(this)).text());
                        if (testRes == true) {
                            $(".specConbineMark", $(this)).text($(".specConbineMark", $(this)).text().replace(reg, currentSpecValue));
                        }
                    }
                });
            }
        } else {
            $(eventSrc).val(oldSpecValue);
            currentSpecValue = oldSpecValue;

            $("#specCombineTable tr:not(:first)").each(function () {
                var temp = "";
                $(".specMark", $(this)).each(function () {
                    if ($(this).attr("id") == specValueID) {
                        temp = $(this).text();
                        $(this).text(currentSpecValue);
                    }
                });

                var regXiexian = /[\/]/g;
                var testRes = regXiexian.test(temp);
                if (testRes == true) {
                    temp = temp.replace(regXiexian, "\\/");
                }
                temp = temp.replace(/\(/g, "\\(").replace(/\)/g, "\\)"); //对括号进行转义
                if (temp != "") {
                    var reg = eval("/" + temp + "/g");
                    testRes = reg.test($(".specConbineMark", $(this)).text());
                    if (testRes == true) {
                        $(".specConbineMark", $(this)).text($(".specConbineMark", $(this)).text().replace(reg, currentSpecValue));
                    }
                }
            });
        }
    }
    //        markTimes = 0; //这是一个全局公用变量，执行完了，将值还原为0，以免影响后面的代码执行
    //    }
}

var childPropertyIDMark = 0;//兼容IE8使用, 当二级属性和三级属性的eventSrc的propertyID相等时,说明事件源识别错误,不加载三级属性
function GetChildProperty() {
    event = event ? event : window.event;
    var eventSrc = event.srcElement ? event.srcElement : event.target;
    if (eventSrc != undefined) {
        var propertyID = $(eventSrc).attr("id").replace("brandProperty", "");
        childPropertyIDMark = propertyID;
        var propertyValueID = $(eventSrc).val();

        var currentPropertyID = 0;
        for (var i = 0; i < jsonPropertyByCategoty.length; i++) {
            if (jsonPropertyByCategoty[i].ParentID == propertyID && jsonPropertyByCategoty[i].ParentVID == propertyValueID) {
                var $subProperty = $("<span class='subPropertyMark' style='margin-left:15px;'>" + jsonPropertyByCategoty[i].PropertyName + "</span>" +
                "<input class='subPropertyMark' id='brandProperty" + jsonPropertyByCategoty[i].PropertyID + "' onchange='GetSubSubProperty(event," + categoryID + ")' onpropertychange='GetSubSubProperty(event," + categoryID + ")' />");

                $(".subPropertyMark", $(eventSrc).parent()).remove();
                $(eventSrc).parent().append($subProperty);
                currentPropertyID = jsonPropertyByCategoty[i].PropertyID;
                break;
            } else {
                $(".subPropertyMark", $(eventSrc).parent()).remove();
            }
        }
        //加载二级属性的选择值
        if (currentPropertyID != 0) {
            $.ajax({
                url: "../../Category/SubPropertyValues",
                type: "get",
                data: { "categoryID": categoryID, "parentVID": propertyValueID },
                async: false,
                success: function (res2) {
                    //alert(res2);
                    if (res2.length > 2) { //没有找到一个可以兼容取二级属性全部值的方法，这里先放了两个方法，第一个根据categoryID、parentVID去取，如果这个方法没有取到，就再发一次ajax请求，如下
                        var jsonRes2 = JSON.parse(res2);
                        for (var j = 0; j < jsonRes2.length; j++) {
                            var $option2 = $("<div value='" + jsonRes2[j].ID + "' isParent='" + jsonRes2[j].IsParent + "'>" + jsonRes2[j].Name + "</div>"); //属性的ID和值都存在option中
                            $("#brandProperty" + jsonRes2[j].PropertyID + "").append($option2);
                        }
                    } else { //第一个方法没有取到二级属性信息，再利用categoryID、propertyID再发一次请求
                        $.ajax({
                            url: "../../Category/PropertyValues",
                            type: "get",
                            data: { "categoryID": categoryID, "propertyID": currentPropertyID },
                            async: false,
                            success: function (res3) {
                                var jsonRes3 = JSON.parse(res3);
                                for (var k = 0; k < jsonRes3.length; k++) {
                                    var $option3 = $("<option value='" + jsonRes3[k].PropertyValueID + "' isParent='" + jsonRes3[k].IsParent + "'>" + jsonRes3[k].ValueName + "</option>"); //属性的ID和值都存在option中
                                    $("#brandProperty" + jsonRes3[k].PropertyID + "").append($option3);
                                }
                            },
                            error: function () {
                                $(".Loading").removeClass("style0yellow style0green").addClass("style0red");
                                $("#operateTip").html("获取二级属性的选择值时出错").change();
                            }
                        });
                    }
                },
                error: function () {
                    $(".Loading").removeClass("style0yellow style0green").addClass("style0red");
                    $("#operateTip").html("获取二级属性的选择值时出错").change();
                }
            });
        }

        $("select[class=subPropertyMark]", $(eventSrc).parent()).change();

    }
}

var childPropertyIDMark = 0; //兼容IE8使用, 当二级属性和三级属性的eventSrc的propertyID相等时,说明事件源识别错误,不加载三级属性
function GetChildProperty(event, categoryID) {
    event = event ? event : window.event;
    var eventSrc = event.srcElement ? event.srcElement : event.target;
    if (eventSrc != undefined) {
        var propertyID = $(eventSrc).attr("id").replace("brandProperty", "");
        childPropertyIDMark = propertyID;
        var propertyValueID = $(eventSrc).attr("brandid");

        var currentPropertyID = 0;
        for (var i = 0; i < jsonPropertyByCategoty.length; i++) {
            if (jsonPropertyByCategoty[i].ParentID == propertyID && jsonPropertyByCategoty[i].ParentVID == propertyValueID) {
                var $subProperty = $("<span class='subPropertyMark' style='margin-left:15px;'>" + jsonPropertyByCategoty[i].PropertyName + "</span><select class='subPropertyMark' id='brandProperty" + jsonPropertyByCategoty[i].PropertyID + "' onchange='GetSubSubProperty(event," + categoryID + ")' onpropertychange='GetSubSubProperty(event," + categoryID + ")'></select>");

                $(".subPropertyMark", $(eventSrc).parent()).remove();
                $(eventSrc).parent().append($subProperty);
                currentPropertyID = jsonPropertyByCategoty[i].PropertyID;
                break;
            } else {
                $(".subPropertyMark", $(eventSrc).parent()).remove();
            }
        }
        //加载二级属性的选择值
        if (currentPropertyID != 0) {
            $.ajax({
                url: "../../Category/SubPropertyValues",
                type: "get",
                data: { "categoryID": categoryID, "parentVID": propertyValueID },
                async: false,
                success: function (res2) {
                    //alert(res2);
                    if (res2.length > 2) { //没有找到一个可以兼容取二级属性全部值的方法，这里先放了两个方法，第一个根据categoryID、parentVID去取，如果这个方法没有取到，就再发一次ajax请求，如下
                        var jsonRes2 = JSON.parse(res2);
                        for (var j = 0; j < jsonRes2.length; j++) {
                            var $option2 = $("<option value='" + jsonRes2[j].ID + "' isParent='" + jsonRes2[j].IsParent + "'>" + jsonRes2[j].Name + "</option>"); //属性的ID和值都存在option中
                            $("#brandProperty" + jsonRes2[j].PropertyID + "").append($option2);
                        }
                    } else { //第一个方法没有取到二级属性信息，再利用categoryID、propertyID再发一次请求
                        $.ajax({
                            url: "../../Category/PropertyValues",
                            type: "get",
                            data: { "categoryID": categoryID, "propertyID": currentPropertyID },
                            async: false,
                            success: function (res3) {
                                var jsonRes3 = JSON.parse(res3);
                                for (var k = 0; k < jsonRes3.length; k++) {
                                    var $option3 = $("<option value='" + jsonRes3[k].PropertyValueID + "' isParent='" + jsonRes3[k].IsParent + "'>" + jsonRes3[k].ValueName + "</option>"); //属性的ID和值都存在option中
                                    $("#brandProperty" + jsonRes3[k].PropertyID + "").append($option3);
                                }
                            },
                            error: function () {
                                $(".Loading").removeClass("style0yellow style0green").addClass("style0red");
                                $("#operateTip").html("获取二级属性的选择值时出错").change();
                            }
                        });
                    }
                },
                error: function () {
                    $(".Loading").removeClass("style0yellow style0green").addClass("style0red");
                    $("#operateTip").html("获取二级属性的选择值时出错").change();
                }
            });
        }

        $("select[class=subPropertyMark]", $(eventSrc).parent()).change();

    }
}


//加载二级属性功能
var subPropertyIDMark = 0; //兼容IE8使用, 当二级属性和三级属性的eventSrc的propertyID相等时,说明事件源识别错误,不加载三级属性
function GetSubProperty(event, categoryID) {
    event = event ? event : window.event;
    var eventSrc = event.srcElement ? event.srcElement : event.target;
    if (eventSrc != undefined) {
        var propertyID = $(eventSrc).attr("id").replace("brandProperty", "");
        subPropertyIDMark = propertyID;
        var propertyValueID = $(eventSrc).val();

        var currentPropertyID = 0;
        for (var i = 0; i < jsonPropertyByCategoty.length; i++) {
            if (jsonPropertyByCategoty[i].ParentID == propertyID && jsonPropertyByCategoty[i].ParentVID == propertyValueID) {
                var $subProperty = $("<span class='subPropertyMark' style='margin-left:15px;'>" + jsonPropertyByCategoty[i].PropertyName + "</span><select class='subPropertyMark' id='brandProperty" + jsonPropertyByCategoty[i].PropertyID + "' onchange='GetSubSubProperty(event," + categoryID + ")' onpropertychange='GetSubSubProperty(event," + categoryID + ")'></select>");

                $(".subPropertyMark", $(eventSrc).parent()).remove();
                $(eventSrc).parent().append($subProperty);
                currentPropertyID = jsonPropertyByCategoty[i].PropertyID;
                break;
            } else {
                $(".subPropertyMark", $(eventSrc).parent()).remove();
            }
        }
        //加载二级属性的选择值
        if (currentPropertyID != 0) {
            $.ajax({
                url: "../../Category/SubPropertyValues",
                type: "get",
                data: { "categoryID": categoryID, "parentVID": propertyValueID },
                async: false,
                success: function (res2) {
                    //alert(res2);
                    if (res2.length > 2) { //没有找到一个可以兼容取二级属性全部值的方法，这里先放了两个方法，第一个根据categoryID、parentVID去取，如果这个方法没有取到，就再发一次ajax请求，如下
                        var jsonRes2 = JSON.parse(res2);
                        for (var j = 0; j < jsonRes2.length; j++) {
                            var $option2 = $("<option value='" + jsonRes2[j].ID + "' isParent='" + jsonRes2[j].IsParent + "'>" + jsonRes2[j].Name + "</option>"); //属性的ID和值都存在option中
                            $("#brandProperty" + jsonRes2[j].PropertyID + "").append($option2);
                        }
                    } else { //第一个方法没有取到二级属性信息，再利用categoryID、propertyID再发一次请求
                        $.ajax({
                            url: "../../Category/PropertyValues",
                            type: "get",
                            data: { "categoryID": categoryID, "propertyID": currentPropertyID },
                            async: false,
                            success: function (res3) {
                                var jsonRes3 = JSON.parse(res3);
                                for (var k = 0; k < jsonRes3.length; k++) {
                                    var $option3 = $("<option value='" + jsonRes3[k].PropertyValueID + "' isParent='" + jsonRes3[k].IsParent + "'>" + jsonRes3[k].ValueName + "</option>"); //属性的ID和值都存在option中
                                    $("#brandProperty" + jsonRes3[k].PropertyID + "").append($option3);
                                }
                            },
                            error: function () {
                                $(".Loading").removeClass("style0yellow style0green").addClass("style0red");
                                $("#operateTip").html("获取二级属性的选择值时出错").change();
                            }
                        });
                    }
                },
                error: function () {
                    $(".Loading").removeClass("style0yellow style0green").addClass("style0red");
                    $("#operateTip").html("获取二级属性的选择值时出错").change();
                }
            });
        }

        $("select[class=subPropertyMark]", $(eventSrc).parent()).change();

    }
}

//加载三级属性功能
function GetSubSubProperty(event, categoryID) {
    event = event ? event : window.event;
    var eventSrc = event.srcElement ? event.srcElement : event.target;
    if (eventSrc != undefined) {
        var propertyID = $(eventSrc).attr("id").replace("brandProperty", "");
        if (subPropertyIDMark != propertyID) {//兼容IE8使用, 当二级属性和三级属性的eventSrc的propertyID相等时,说明事件源识别错误,不加载三级属性
            var propertyValueID = $(eventSrc).val();
            //alert(propertyValueID);
            var currentPropertyID = 0;
            for (var i = 0; i < jsonPropertyByCategoty.length; i++) {
                if (jsonPropertyByCategoty[i].ParentID == propertyID && jsonPropertyByCategoty[i].ParentVID == propertyValueID) {
                    var $subProperty = $("<span class='subSubPropertyMark'>&nbsp;" + jsonPropertyByCategoty[i].PropertyName + "</span><select class='subSubPropertyMark' id='brandProperty" + jsonPropertyByCategoty[i].PropertyID + "'></select>");
                    //            onchange='GetSubProperty(event," + categoryID + ")'
                    $(".subSubPropertyMark", $(eventSrc).parent()).remove();
                    $(eventSrc).parent().append($subProperty);
                    currentPropertyID = jsonPropertyByCategoty[i].PropertyID;
                    break;
                } else {
                    $(".subSubPropertyMark", $(eventSrc).parent()).remove();
                }
            }

            //加载三级属性的选择值
            if (currentPropertyID != 0) {
                $.ajax({
                    url: "../../Category/SubPropertyValues",
                    type: "get",
                    data: { "categoryID": categoryID, "parentVID": propertyValueID },
                    async: false,
                    success: function (res2) {
                        //alert(res2);
                        if (res2.length > 2) { //没有找到一个可以兼容取二级属性全部值的方法，这里先放了两个方法，第一个根据categoryID、parentVID去取，如果这个方法没有取到，就再发一次ajax请求，如下
                            var jsonRes2 = JSON.parse(res2);
                            for (var j = 0; j < jsonRes2.length; j++) {
                                var $option2 = $("<option value='" + jsonRes2[j].ID + "' isParent='" + jsonRes2[j].IsParent + "'>" + jsonRes2[j].Name + "</option>"); //属性的ID和值都存在option中
                                $("#brandProperty" + jsonRes2[j].PropertyID + "").append($option2);
                            }
                        } else { //第一个方法没有取到二级属性信息，再利用categoryID、propertyID再发一次请求
                            $.ajax({
                                url: "../../Category/PropertyValues",
                                type: "get",
                                data: { "categoryID": categoryID, "propertyID": currentPropertyID },
                                async: false,
                                success: function (res3) {
                                    //alert(res3);
                                    var jsonRes3 = JSON.parse(res3);
                                    for (var k = 0; k < jsonRes3.length; k++) {
                                        var $option3 = $("<option value='" + jsonRes3[k].PropertyValueID + "' isParent='" + jsonRes3[k].IsParent + "'>" + jsonRes3[k].ValueName + "</option>"); //属性的ID和值都存在option中
                                        $("#brandProperty" + jsonRes3[k].PropertyID + "").append($option3);
                                    }
                                },
                                error: function () {
                                    $(".Loading").removeClass("style0yellow style0green").addClass("style0red");
                                    $("#operateTip").html("获取三级属性的选择值时出错").change();

                                }
                            });
                        }
                    },
                    error: function () {
                        $(".Loading").removeClass("style0yellow style0green").addClass("style0red");
                        $("#operateTip").html("获取三级属性的选择值时出错").change();

                    }
                });
            }
        }
    }
}


//加载二级属性功能(品牌专用)
function GetSubPropertyForBrand(event, categoryID) {
    event = event ? event : window.event;
    var eventSrc = event.srcElement ? event.srcElement : event.target;
    if (eventSrc != undefined) {
        var currentPropertyID = 0;
        var propertyID = $(eventSrc).attr("id").replace("brandProperty", "");
        var parentVID = $(eventSrc).attr("brandid");
        //if ($(eventSrc).val() == "" || $(eventSrc).val() == "可直接输入或选择") {
        $(".subPropertyMarkForBrand", $(eventSrc).parent()).remove();
        //} else {

        for (var i = 0; i < jsonPropertyByCategoty.length; i++) {
            if (jsonPropertyByCategoty[i].ParentID == propertyID && jsonPropertyByCategoty[i].ParentVID == parentVID) {
                var subProperty = "<span class='subPropertyMarkForBrand' style='margin-left:15px;'>" + jsonPropertyByCategoty[i].PropertyName + "</span>";
                subProperty += "<input type='text'  class='subPropertyMarkForBrand' onchange='GetSubSubPropertyForBrand(event," + categoryID + ");' ";
                subProperty += " onclick='SelectBrandValue(event);' onblur='UserDefineBrand(event);' onpropertychange='GetSubSubPropertyForBrand(event," + categoryID + ");'  id='brandProperty" + jsonPropertyByCategoty[i].PropertyID + "' key='" + jsonPropertyByCategoty[i].PropertyID + "' ></input>";

                $(".subPropertyMarkForBrand").parent().remove();
                //$(eventSrc).parent().remove();
                //$(eventSrc).parent().append($subProperty);
                currentPropertyID = jsonPropertyByCategoty[i].PropertyID;
                var style = "style='width: 400px; height: auto; max-height: 350px; overflow-y: auto; overflow-x: hidden; border: 1px solid rgb(204, 204, 204); background-color: white; position: absolute; z-index: 10; display: none;'"
                var dvProperty = "<div id='dvBrandPropertyValue" + currentPropertyID + "' " + style + " ></div>";
                var insertHTML = "<div class='float-l'>" + subProperty + dvProperty + "</div>";
                //$(eventSrc).parent().append($dvProperty);
                $(insertHTML).insertAfter($(eventSrc).parent());
                break;
            }
        }
        // }

        //加载二级属性的选择值
        if (currentPropertyID != 0) {
            $.ajax({
                url: "../../Category/SubPropertyValues",
                type: "get",
                data: { "categoryID": categoryID, "parentVID": parentVID },
                async: false,
                success: function (res2) {
                    //alert(res2);
                    if (res2.length > 2) { //没有找到一个可以兼容取二级属性全部值的方法，这里先放了两个方法，第一个根据categoryID、parentVID去取，如果这个方法没有取到，就再发一次ajax请求，如下
                        var jsonRes2 = JSON.parse(res2);
                        for (var j = 0; j < jsonRes2.length; j++) {
                            var $brandValue = $("<div id='" + jsonRes2[j].ID + "' key='" + currentPropertyID + "' style='width:100%;height:20px;line-height:20px;' onclick='SelectThisBrand(event)' isParent='" + jsonRes2[j].IsParent + "'>" + jsonRes2[j].Name + "</div>")
                            //alert(jsonRes2[j].ValueName);
                            //var $option2 = $("<option value='" + jsonRes2[j].ID + "' isParent='" + jsonRes2[j].IsParent + "'>" + jsonRes2[j].Name + "</option>"); //属性的ID和值都存在option中
                            $("#dvBrandPropertyValue" + currentPropertyID).append($brandValue);

                        }
                    } else { //第一个方法没有取到二级属性信息，再利用categoryID、propertyID再发一次请求
                        $.ajax({
                            url: "../../Category/PropertyValues",
                            type: "get",
                            data: { "categoryID": categoryID, "propertyID": currentPropertyID },
                            async: false,
                            success: function (res3) {
                                var jsonRes3 = JSON.parse(res3);
                                for (var k = 0; k < jsonRes3.length; k++) {
                                    var $brandValue = $("<div id='" + jsonRes3[k].PropertyValueID + "' key='" + currentPropertyID + "' style='width:100%;height:20px;line-height:20px;' onclick='SelectThisBrand(event)' isParent='" + jsonRes3[k].IsParent + "'>" + jsonRes3[k].ValueName + "</div>")
                                    $("#dvBrandPropertyValue" + jsonRes3[k].PropertyID + "").append($brandValue);
                                }
                            },
                            error: function () {
                                $(".Loading").removeClass("style0yellow style0green").addClass("style0red");
                                $("#operateTip").html("获取二级属性的选择值时出错").change();
                            }
                        });
                    }
                },
                error: function () {
                    $(".Loading").removeClass("style0yellow style0green").addClass("style0red");
                    $("#operateTip").html("获取二级属性的选择值时出错").change();
                }
            });
        }

        $("input[class=subPropertyMarkForBrand]", $(eventSrc).parent().parent()).change();

    }

}

function SetBrandID(properyID, brandValues) {
    $("#dvBrandPropertyValue" + properyID + " div").each(function () {
        if ($(this).text() == brandValues) {
            $("#brandProperty" + properyID).attr("brandid", $(this).attr("id"));
        }
    });
}

function GetSubSubPropertyForBrand(event, categoryID) {
    event = event ? event : window.event;
    var eventSrc = event.srcElement ? event.srcElement : event.target;
    if (eventSrc != undefined) {
        var propertyID = $(eventSrc).attr("id").replace("brandProperty", "");
        if (subPropertyIDMark != propertyID) {//兼容IE8使用, 当二级属性和三级属性的eventSrc的propertyID相等时,说明事件源识别错误,不加载三级属性
            var propertyValueID = $(eventSrc).attr("brandid");
            //alert(propertyValueID);
            var currentPropertyID = 0;
            for (var i = 0; i < jsonPropertyByCategoty.length; i++) {
                if (jsonPropertyByCategoty[i].ParentID == propertyID && (jsonPropertyByCategoty[i].ParentVID == propertyValueID || propertyValueID == 0)) {
                    var subProperty = "<span style='margin-left:15px;'  class='subPropertyMarkForBrand'>&nbsp;" + jsonPropertyByCategoty[i].PropertyName + "</span>" +
                        "<input type='text' class='subPropertyMarkForBrand' id='brandProperty" + jsonPropertyByCategoty[i].PropertyID + "' onclick='SelectBrandValue(event)' onblur='UserDefineBrand(event)' " +
                        " key='" + jsonPropertyByCategoty[i].PropertyID + "' />"
                    //            onchange='GetSubProperty(event," + categoryID + ")'
                    $("#nextMenu", $(eventSrc).parent().parent()).remove();
                    //$(eventSrc).parent().append($subProperty);
                    currentPropertyID = jsonPropertyByCategoty[i].PropertyID;
                    var style = "style='width: 400px; height: auto; max-height: 350px; overflow-y: auto; overflow-x: hidden; border: 1px solid rgb(204, 204, 204); background-color: white; position: absolute; z-index: 10; display: none;'"
                    var dvProperty = "<div id='dvBrandPropertyValue" + currentPropertyID + "' " + style + " ></div>";
                    var insertHTML = "<div class='float-l' id='nextMenu'>" + subProperty + dvProperty + "</div>";
                    $(insertHTML).insertAfter($(eventSrc).parent());
                    break;
                } else {
                    $(".subSubPropertyMark", $(eventSrc).parent()).remove();
                }

            }

            //加载三级属性的选择值
            if (currentPropertyID != 0) {
                $.ajax({
                    url: "../../Category/SubPropertyValues",
                    type: "get",
                    data: { "categoryID": categoryID, "parentVID": propertyValueID },
                    async: false,
                    success: function (res2) {
                        //alert(res2);
                        if (res2.length > 2) { //没有找到一个可以兼容取二级属性全部值的方法，这里先放了两个方法，第一个根据categoryID、parentVID去取，如果这个方法没有取到，就再发一次ajax请求，如下
                            var jsonRes2 = JSON.parse(res2);
                            for (var j = 0; j < jsonRes2.length; j++) {
                                var $brandValue = $("<div id='" + jsonRes2[j].ID + "' key='" + currentPropertyID + "' " +
                                    "style='width:100%;height:auto;line-height:20px;' onclick='SelectThisBrand(event)' isParent='" + jsonRes2[j].IsParent + "'>" + jsonRes2[j].Name + "</div>");
                                //var $option2 = $("<option value='" + jsonRes2[j].ID + "' isParent='" + jsonRes2[j].IsParent + "'>" + jsonRes2[j].Name + "</option>"); //属性的ID和值都存在option中
                                $("#dvBrandPropertyValue" + currentPropertyID + "").append($brandValue);
                            }
                        } else { //第一个方法没有取到二级属性信息，再利用categoryID、propertyID再发一次请求
                            $.ajax({
                                url: "../../Category/PropertyValues",
                                type: "get",
                                data: { "categoryID": categoryID, "propertyID": currentPropertyID },
                                async: false,
                                success: function (res3) {
                                    //alert(res3);
                                    var jsonRes3 = JSON.parse(res3);
                                    for (var k = 0; k < jsonRes3.length; k++) {
                                        var $brandValue = $("<div id='" + jsonRes3[k].PropertyValueID + "' key='" + currentPropertyID + "' " +
                                    "style='width:100%;height:auto;line-height:20px;' onclick='SelectThisBrand(event)' isParent='" + jsonRes3[k].IsParent + "'>" + jsonRes3[k].ValueName + "</div>");
                                        //var $option3 = $("<option value='" + jsonRes3[k].PropertyValueID + "' isParent='" + jsonRes3[k].IsParent + "'>" + jsonRes3[k].ValueName + "</option>"); //属性的ID和值都存在option中
                                        $("#dvBrandPropertyValue" + currentPropertyID + "").append($brandValue);
                                    }
                                },
                                error: function () {
                                    $(".Loading").removeClass("style0yellow style0green").addClass("style0red");
                                    $("#operateTip").html("获取三级属性的选择值时出错").change();

                                }
                            });
                        }
                    },
                    error: function () {
                        $(".Loading").removeClass("style0yellow style0green").addClass("style0red");
                        $("#operateTip").html("获取三级属性的选择值时出错").change();

                    }
                });
            }
        }
    }
}

function GetChildTemplate(event, jsonRes) {
    event = event ? event : window.event;
    var eventSrc = event.srcElement ? event.srcElement : event.target;
    var catoryID = $(eventSrc).attr("brandid");
    var proID = $(eventSrc).attr("key");
    if ($(eventSrc).val() == "" || $(eventSrc).val() == "可直接输入或选择") {
        $(".childProperty", $(eventSrc).parent()).remove();
    } else {
        $(".childProperty", $(eventSrc).parent()).remove();
        if ($("input[class=childProperty]", $(eventSrc).parent()).val() == undefined) {
            jsonRes = JSON.parse(jsonRes);
            for (var i = 0; i < jsonRes.length; i++) {
                if (jsonRes[i].PropertyID == 20000 && proID == jsonRes[i].PropertyID && jsonRes[i].ChildTemplate != "") {
                    var childTemplate = jsonRes[i].ChildTemplate;
                    var childTemplates = childTemplate.split(';');
                    for (var j = childTemplates.length - 1; j >= 0; j--) {
                        var $childProperty = $("<span class='childProperty' style='margin-left:15px;'>" + childTemplates[j] + "</span><input type='text' class='childProperty'></input>");
                        $(eventSrc).after($childProperty);
                    }
                    break;
                }
            }
        }
    }
}

function PriceFormat(event) {
    event = event ? event : window.event;
    var eventSrc = event.srcElement ? event.srcElement : event.target;
    var price = $(eventSrc).val();
    var r = /\d+/g;
    if (r.test(price)) {
        var reg = /\./g;
        if (!reg.test(price)) {
            price = price + ".00";
        }
    }
    $(eventSrc).val(price);
}

function OperateStarMark(event) {
    event = event ? event : window.event;
    var eventSrc = event.srcElement ? event.srcElement : event.target;
    if (parseInt($(eventSrc).val()) == 28407) {
        $("#foodSecurityContainer div span[style]").each(function () {
            $(this).text("*");
        });
    } else {
        $("#foodSecurityContainer div span[style]").each(function () {
            $(this).text("");
        });
    }
}

//获取属性Value
function GetPropertyValue(categoryID) {
    var propertyEntity = new Object();
    $.ajax({
        url: "../../Category/GetPropertyByCatoryID",
        type: "get",
        data: { "catoryID": categoryID },
        async: false,
        success: function (res2) {
            //alert(res2);
            if (res2.length > 2) { //没有找到一个可以兼容取二级属性全部值的方法，这里先放了两个方法，第一个根据categoryID、parentVID去取，如果这个方法没有取到，就再发一次ajax请求，如下
                propertyEntity = JSON.parse(res2);
            }
        },
        error: function () {
            $(".Loading").removeClass("style0yellow style0green").addClass("style0red");
            $("#operateTip").html("加载属性值错误").change();
        }
    });
    return propertyEntity;
}