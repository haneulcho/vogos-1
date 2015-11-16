var option_add = false;
var supply_add = false;
var isAndroid = (navigator.userAgent.toLowerCase().indexOf("android") > -1);

$(function() {
    // 선택옵션
    /* 가상커서 ctrl keyup 이베트 대응 */
    /*
    $("select.it_option").live("keyup", function(e) {
        var sel_count = $("select.it_option").size();
        var idx = $("select.it_option").index($(this));
        var code = e.keyCode;
        var val = $(this).val();

        option_add = false;
        if(code == 17 && sel_count == idx + 1) {
            if(val == "")
                return;

            sel_option_process(true);
        }
    });
    */

    /* 키보드 접근 후 옵션 선택 Enter keydown 이벤트 대응 */
    $("select.it_option").live("keydown", function(e) {
        var sel_count = $("select.it_option").size();
        var idx = $("select.it_option").index($(this));
        var code = e.keyCode;
        var val = $(this).val();

        option_add = false;
        if(code == 13 && sel_count == idx + 1) {
            if(val == "")
                return;

            sel_option_process(true);
        }
    });

    if(isAndroid) {
        $("select.it_option").live("touchend", function() {
            option_add = true;
        });
    } else {
        $("select.it_option").live("mouseup", function() {
            option_add = true;
        });
    }

    $("select.it_option").live("change", function() {
        var sel_count = $("select.it_option").size();
        var idx = $("select.it_option").index($(this));
        var val = $(this).val();
        var it_id = $("input[name='it_id[]']").val();

        // 선택값이 없을 경우 하위 옵션은 disabled
        if(val == "") {
            $("select.it_option:gt("+idx+")").val("").attr("disabled", true);
            return;
        }

        // 하위선택옵션로드
        if(sel_count > 1 && (idx + 1) < sel_count) {
            var opt_id = "";

            // 상위 옵션의 값을 읽어 옵션id 만듬
            if(idx > 0) {
                $("select.it_option:lt("+idx+")").each(function() {
                    if(!opt_id)
                        opt_id = $(this).val();
                    else
                        opt_id += chr(30)+$(this).val();
                });

                opt_id += chr(30)+val;
            } else if(idx == 0) {
                opt_id = val;
            }

            $.post(
                "./itemoption.php",
                { it_id: it_id, opt_id: opt_id, idx: idx, sel_count: sel_count },
                function(data) {
                    $("select.it_option").eq(idx+1).empty().html(data).attr("disabled", false);

                    // select의 옵션이 변경됐을 경우 하위 옵션 disabled
                    if(idx+1 < sel_count) {
                        var idx2 = idx + 1;
                        $("select.it_option:gt("+idx2+")").val("").attr("disabled", true);
                    }
                }
            );
        } else if((idx + 1) == sel_count) { // 선택옵션처리
            if(option_add && val == "")
                return;

            var info = val.split(",");
            // 재고체크
            if(parseInt(info[2]) < 1) {
                alert("Out of Stock.\\nPlease select other items.");
                return false;
            }

            if(option_add) {
                sel_option_process(true);
            }
        }
    });

    // 추가옵션
    /* 가상커서 ctrl keyup 이베트 대응 */
    /*
    $("select.it_supply").live("keyup", function(e) {
        var $el = $(this);
        var code = e.keyCode;
        var val = $(this).val();

        supply_add = false;
        if(code == 17) {
            if(val == "")
                return;

            sel_supply_process($el, true);
        }
    });
    */

    /* 키보드 접근 후 옵션 선택 Enter keydown 이벤트 대응 */
    $("select.it_supply").live("keydown", function(e) {
        var $el = $(this);
        var code = e.keyCode;
        var val = $(this).val();

        supply_add = false;
        if(code == 13) {
            if(val == "")
                return;

            sel_supply_process($el, true);
        }
    });

    if(isAndroid) {
        $("select.it_supply").live("touchend", function() {
            supply_add = true;
        });
    } else {
        $("select.it_supply").live("mouseup", function() {
            supply_add = true;
        });
    }

    $("select.it_supply").live("change", function() {
        var $el = $(this);
        var val = $(this).val();

        if(val == "")
            return;

        if(supply_add)
            sel_supply_process($el, true);
    });

    // 수량변경 및 삭제
    $("#sit_sel_option li button").live("click", function() {
        // var mode = $(this).text();
        var mode;
        if($(this).hasClass('sit_qty_minus')) {
            mode = '감소';
        } else if($(this).hasClass('sit_qty_plus')){
            mode = '증가';
        } else {
            mode = '삭제';
        }
        var this_qty, max_qty = 9999, min_qty = 1;
        var $el_qty = $(this).closest("li").find("input[name^=ct_qty]");
        var stock = parseInt($(this).closest("li").find("input.io_stock").val());

        switch(mode) {
            case "증가":
                this_qty = parseInt($el_qty.val().replace(/[^0-9]/, "")) + 1;
                if(this_qty > stock) {
                    alert("You've reached the limit for this item.");
                    this_qty = stock;
                }

                if(this_qty > max_qty) {
                    this_qty = max_qty;
                    alert("Please specify a quantity less than "+number_format(String(max_qty))+" in a product.");
                }

                $el_qty.val(this_qty);
                price_calculate();
                break;

            case "감소":
                this_qty = parseInt($el_qty.val().replace(/[^0-9]/, "")) - 1;
                if(this_qty < min_qty) {
                    this_qty = min_qty;
                    alert("Please specify a quantity larger than "+number_format(String(min_qty))+" in a product.");
                }
                $el_qty.val(this_qty);
                price_calculate();
                break;

            case "삭제":
                if(confirm("Delete selected items?")) {
                    var $el = $(this).closest("li");
                    var del_exec = true;

                    if($("#sit_sel_option .sit_spl_list").size() > 0) {
                        // 선택옵션이 하나이상인지
                        if($el.hasClass("sit_opt_list")) {
                            if($(".sit_opt_list").size() <= 1)
                                del_exec = false;
                        }
                    }

                    if(del_exec) {
                        $el.closest("li").remove();
                        price_calculate();
                    } else {
                        alert("Please specify a quantity larger than 0 in a product.");
                        return false;
                    }
                }
                break;

            default:
                alert("We could not process your request.\\nPlease try again.");
                break;
        }
    });

    // 수량직접입력
    $("input[name^=ct_qty]").live("keyup", function() {
        var val= $(this).val();

        if(val != "") {
            if(val.replace(/[0-9]/g, "").length > 0) {
                alert("Please check a quantity.");
                $(this).val(1);
            } else {
                var d_val = parseInt(val);
                if(d_val < 1 || d_val > 9999) {
                    alert("Please specify a quantity to enable the 'Add To Shopping Bag' button.");
                    $(this).val(1);
                } else {
                    var stock = parseInt($(this).closest("li").find("input.io_stock").val());
                    if(d_val > stock) {
                        alert("You've reached the limit for this item.");
                        $(this).val(stock);
                    }
                }
            }

            price_calculate();
        }
    });
});

// 선택옵션 추가처리
function sel_option_process(add_exec)
{
    var it_price = parseFloat($("input#it_price").val());
    var id = "";
    var value, info, sel_opt, item, price, stock, run_error = false;
    var option = sep = "";
    info = $("select.it_option:last").val().split(",");

    $("select.it_option").each(function(index) {
        value = $(this).val();
        item = $(this).closest("tr").find("th label").text();

        if(!value) {
            run_error = true;
            return false;
        }

        // 옵션선택정보
        sel_opt = value.split(",")[0];

        if(id == "") {
            id = sel_opt;
        } else {
            id += chr(30)+sel_opt;
            sep = " / ";
        }

        option += sep + item + ": " + sel_opt;
    });

    if(run_error) {
        alert("Please select: "+item);
        return false;
    }

    price = info[1];
    stock = info[2];

    // 금액 음수 체크
    if(it_price + parseFloat(price) < 0) {
        alert("Please enter valid number.");
        return false;
    }

    if(add_exec) {
        if(same_option_check(option))
            return;

        add_sel_option(0, id, option, price, stock);
    }
}

// 추가옵션 추가처리
function sel_supply_process($el, add_exec)
{
    var val = $el.val();
    var item = $el.closest("tr").find("th label").text();

    if(!val) {
        alert("Please select: "+item);
        return;
    }

    var info = val.split(",");

    // 재고체크
    if(parseInt(info[2]) < 1) {
        alert(info[0]+"is not available!");
        return false;
    }

    var id = item+chr(30)+info[0];
    var option = item+": "+info[0];
    var price = info[1];
    var stock = info[2];

    // 금액 음수 체크
    if(parseFloat(price) < 0) {
        alert("Please enter valid number.");
        return false;
    }

    if(add_exec) {
        if(same_option_check(option))
            return;

        add_sel_option(1, id, option, price, stock);
    }
}

// 선택된 옵션 출력
function add_sel_option(type, id, option, price, stock)
{
    var item_code = $("input[name='it_id[]']").val();
    var opt = "";
    var li_class = "sit_opt_list";
    if(type)
        li_class = "sit_spl_list";

    var opt_prc;
    if(parseFloat(price) >= 0)
        opt_prc = "(+"+number_format(String(price), 2, '.', ',');
    else
        opt_prc = "("+number_format(String(price), 2, '.', ',');

    opt += "<li class=\""+li_class+"\">";
    opt += "<input type=\"hidden\" name=\"io_type["+item_code+"][]\" value=\""+type+"\">";
    opt += "<input type=\"hidden\" name=\"io_id["+item_code+"][]\" value=\""+id+"\">";
    opt += "<input type=\"hidden\" name=\"io_value["+item_code+"][]\" value=\""+option+"\">";
    opt += "<input type=\"hidden\" class=\"io_price\" value=\""+price+"\">";
    opt += "<input type=\"hidden\" class=\"io_stock\" value=\""+stock+"\">";
    opt += "<span class=\"sit_opt_subj\">"+option+"</span>";
    if(parseFloat(price) > 0) {
        opt += "<span class=\"sit_opt_prc\">"+opt_prc+"</span>";    
    }
    opt += "<div>";
    opt += "<button type=\"button\" class=\"sit_qty_minus btn_frmline\"><i class=\"ion-android-arrow-dropdown\"></i></button>";
    opt += "<input type=\"text\" name=\"ct_qty["+item_code+"][]\" value=\"1\" class=\"frm_input\" size=\"5\">";
    opt += "<button type=\"button\" class=\"sit_qty_plus btn_frmline\"><i class=\"ion-android-arrow-dropup\"></i></button>";
    opt += "<button type=\"button\" class=\"sit_opt_del btn_frmline\"><i class=\"ion-ios-trash-outline\"></i></button></div>";
    opt += "</li>";

    if($("#sit_sel_option > ul").size() < 1) {
        $("#sit_sel_option").html("<ul id=\"sit_opt_added\"></ul>");
        $("#sit_sel_option > ul").html(opt);
    } else{
        if(type) {
            if($("#sit_sel_option .sit_spl_list").size() > 0) {
                $("#sit_sel_option .sit_spl_list:last").after(opt);
            } else {
                if($("#sit_sel_option .sit_opt_list").size() > 0) {
                    $("#sit_sel_option .sit_opt_list:last").after(opt);
                } else {
                    $("#sit_sel_option > ul").html(opt);
                }
            }
        } else {
            if($("#sit_sel_option .sit_opt_list").size() > 0) {
                $("#sit_sel_option .sit_opt_list:last").after(opt);
            } else {
                if($("#sit_sel_option .sit_spl_list").size() > 0) {
                    $("#sit_sel_option .sit_spl_list:first").before(opt);
                } else {
                    $("#sit_sel_option > ul").html(opt);
                }
            }
        }
    }

    price_calculate();
}

// 동일선택옵션있는지
function same_option_check(val)
{
    var result = false;
    $("input[name^=io_value]").each(function() {
        if(val == $(this).val()) {
            result = true;
            return false;
        }
    });

    if(result)
        alert(" You have already added '"+val+"'");

    return result;
}

// 가격계산
function price_calculate()
{
    var it_price = parseFloat($("input#it_price").val());

    if(isNaN(it_price))
        return;

    var $el_prc = $("input.io_price");
    var $el_qty = $("input[name^=ct_qty]");
    var $el_type = $("input[name^=io_type]");
    var price, type, qty, total = 0;

    $el_prc.each(function(index) {
        price = parseFloat($(this).val());
        qty = parseInt($el_qty.eq(index).val());
        type = $el_type.eq(index).val();

        if(type == "0") { // 선택옵션
            total += (it_price + price) * qty;
        } else { // 추가옵션
            total += price * qty;
        }
    });

    $("#sit_tot_price").empty().html("$"+number_format(String(total), 2, '.', ','));
}

// php chr() 대응
function chr(code)
{
    return String.fromCharCode(code);
}