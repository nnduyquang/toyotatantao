integratedCKEDITOR('description-page', height = 200);
// integratedCKEDITOR('seo-description',height=200);
if ($('#btnBrowseImage').length) {
    var button1 = document.getElementById('btnBrowseImage');
    button1.onclick = function () {
        selectFileWithKCFinder('pathImage', 'showHinh');
    }
}

$('.ulti-copy').click(function () {
    var selected = [];
    $('input[type=checkbox][name=id\\[\\]]').each(function () {
        if ($(this).is(":checked")) {
            selected.push($(this).val());
        }
    });
    if (selected.length != 0) {
        $('input[name=listID]').val(selected);
        alert('Đã lưu sản phẩm');
    }
    else {
        alert('Mời bạn chọn sản phẩm');
    }
    console.log(selected);
    // alert(id[0]);
});
$('.ulti-paste').click(function () {
    if (!$('input[name=listID]').val()) {
        alert('Bạn chưa Sao Chép Hoặc Chưa chọn sản phẩm');
    }
    else {
        $('#formPaste').submit();
    }
});
// SEO
$("input[name='seo_keywords']").keyup(function () {
    var getidTitle = $("#seo-part .content .show-pattern .title");
    var getidDescription = $("#seo-part .content .show-pattern .description");
    var strKeyword = $(this).val();
    strKeyword = replace_special_character_by_comma(strKeyword);
    if (strKeyword.length > 3) {
        if (strKeyword.substr(strKeyword.length - 1)===strKeyword.substr(strKeyword.length - 2,1)) {
            strKeyword=strKeyword.substr(0,strKeyword.length - 1);
        }
    }
    $(this).val(strKeyword);
    showErrorSEO(strKeyword.toLowerCase(), getidTitle, getidDescription);
})
$("input[name='seo_title']").keyup(function () {
    var getidTitle = $("#seo-part .content .show-pattern .title");
    var getidDescription = $("#seo-part .content .show-pattern .description");
    var strKeyword = $("input[name='seo_keywords']").val();
    showErrorSEO(strKeyword.toLowerCase(), getidTitle, getidDescription);
    var getid = $("#seo-part .content .show-pattern .title");
    getid.html($(this).val());
    var titleWidth = getid.width();
    if (titleWidth > 600) {
        cutString(getid);
        var temp = getid.html().lastIndexOf(' ');
        getid.html(getid.html().substring(0, temp + 1) + '...');
    }
    resetSentence();
});


$("input[name='seo_title']").bind("paste", function (e) {
    var getid = $("#seo-part .content .show-pattern .title");
    var pasteText = e.originalEvent.clipboardData.getData('text');
    getid.html(pasteText);
    var titleWidth = getid.width();
    if (titleWidth > 600) {
        cutStringTitle(getid);
        var temp = getid.html().lastIndexOf(' ');
        getid.html(getid.html().substring(0, temp + 1) + '...');
    }
});

$("textarea[name='seo_description']").keyup(function () {
    var getid = $("#seo-part .content .show-pattern .description");
    var getidTitle = $("#seo-part .content .show-pattern .title");
    var getidDescription = $("#seo-part .content .show-pattern .description");
    var strKeyword = $("input[name='seo_keywords']").val();
    showErrorSEO(strKeyword.toLowerCase(), getidTitle, getidDescription);
    getid.html($(this).val());
    var descriptionLength = getid.html().length;
    if (descriptionLength > 150) {
        cutStringDescription(getid);
        var temp = getid.html().lastIndexOf(' ');
        getid.html(getid.html().substring(0, temp + 1) + '...');
    }
    resetSentence();
});

$("input[name='title']").keyup(function () {
    var link = change_alias($(this).val());
    link = link.replace(/\s/g, "-");
    $("span.link").html(getBaseURL() + link);
    resetSentence();
});


function cutStringTitle(element) {
    var widthStr = element.width();
    var newString = '';
    if (widthStr > 600) {
        newString = element.html().substring(0, element.html().length - 1);
        element.html(newString);
        cutStringTitle(element);
    }
}

function cutStringDescription(element) {
    var descriptionLength = element.html().length;
    if (descriptionLength > 150) {
        element.html(element.html().substring(0, element.html().length - 1));
        cutStringDescription(element);
    }
}

function showErrorSEO(strKeyword, getidTitle, getidDescription) {
    var li = "";
    $("ul.error-notice").css("display", 'block');
    if (strKeyword.length > 3) {
        var listKeywords = strKeyword.trim().split(',');
        listKeywords.forEach(function (i, idx, array) {
            if (!isNullOrEmpty(i)) {
                if (getidTitle.html().toLowerCase().indexOf(i.trim()) != -1) {
                    var checkText = getidTitle.html().substring(0, i.length).toLowerCase();
                    if (checkText.indexOf(i.trim()) == -1) {
                        li += '<li class="near">Từ khóa [' + i.trim() + ']  chứa trong title nhưng không nằm đầu câu<li>';
                        return false;
                    } else {
                        li += '<li class="right">Từ khóa [' + i.trim() + '] chứa trong title<li>';
                        return false;
                    }
                    return false;
                } else {
                    li += '<li class="wrong">Từ khóa [' + i.trim() + '] không chứa trong title<li>';
                    return false;
                }
            }
        });
        listKeywords.forEach(function (i, idx, array) {
            if (!isNullOrEmpty(i)) {
                if (getidDescription.html().toLowerCase().indexOf(i.trim()) == -1) {
                    li += '<li class="wrong">Từ khóa [' + i.trim() + '] không chứa trong description<li>';
                } else {
                    li += '<li class="right">Từ khóa [' + i.trim() + '] chứa trong description<li>';
                }
            }
        });
        $("ul.error-notice").html(li);

    } else {
        $("ul.error-notice").html('');
    }
}

function change_alias(alias) {
    var str = alias;
    str = str.toLowerCase();
    str = str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g, "a");
    str = str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g, "e");
    str = str.replace(/ì|í|ị|ỉ|ĩ/g, "i");
    str = str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g, "o");
    str = str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g, "u");
    str = str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g, "y");
    str = str.replace(/đ/g, "d");
    str = str.replace(/!|@|%|\^|\*|\(|\)|\+|\=|\<|\>|\?|\/|,|\.|\:|\;|\'|\"|\&|\#|\[|\]|~|\$|_|`|-|{|}|\||\\/g, " ");
    str = str.replace(/ + /g, " ");
    str = str.trim();
    return str;
}

function replace_special_character_by_comma(alias) {
    var str = alias;
    str = str.replace(/!|@|%|\^|\*|\(|\)|\+|\=|\<|\>|\?|\/|,|\.|\:|\;|\'|\"|\&|\#|\[|\]|~|\$|_|`|-|{|}|\||\\/g, ",");
    return str;
}

function resetSentence() {
    var getidTitle = $("#seo-part .content .show-pattern .title");
    var getidDescription = $("#seo-part .content .show-pattern .description");
    var getidLink = $("#seo-part .content .show-pattern .link");
    if (getidTitle.html().length == 0) {
        getidTitle.html("Quick Brown Fox and The Lazy Dog - Demo Site")
    }
    if (getidDescription.html().length == 0) {
        getidDescription.html("The story of quick brown fox and the lazy dog. An all time classic children's fairy tale that is helping people with typography and web design.")
    }
    if (getidLink.html().length == 0) {
        getidLink.html("example.com/the-quick-brown-fox")
    }
    if ($("input[name='title']").length == 0) {
        getidLink.html("example.com/the-quick-brown-fox")
    }
}

function isNullOrEmpty(s) {
    return (s == null || s === "");
}

// integratedCKEDITOR('description-page',height=200);
integratedCKEDITOR('content-page',height=800);
// integratedCKEDITOR('seo-description-page',height=200);


// =========================================================
// if ($('#btnBrowseImagePage').length) {
//     var button1 = document.getElementById('btnBrowseImagePage');
//     button1.onclick = function () {
//         selectFileWithKCFinder('pathImagePage','showHinhPage');
//     }
// }
// =========================================================
integratedCKEDITOR('description-post',height=200);
integratedCKEDITOR('content-post',height=800);
// integratedCKEDITOR('seo-description-post',height=200);
if ($('#btnBrowseImagePost').length) {
    var button1 = document.getElementById('btnBrowseImagePost');
    button1.onclick = function () {
        selectFileWithKCFinder('pathImagePost','showHinhPost');
    }
};
function loadDataFormWhenSelectTreeMenu(data) {
    $('input[name=state]').val('edit');
    $('form#frmCreateThuNghiem').attr('action', getBaseURL() + "sml_admin/menu-update/" + data.id);
    $('input[name=_method]').val('PATCH');
    $('input[name=name]').val(data.name);
    $('input[name=parentId]').val(data['parent_id']);
    $('input[name=mainId]').val(data.id);
    $('input[name=level]').val(data.level);
    $('input[name=order]').val(data.order);
    $('button#deleteMenu').show();
    $('.test_info_right h3.title').html('Cập Nhật Menu: ' + data.name);
    (data.isActive === 1) ? $('input[name=menu_is_active]').prop('checked', true) : $('input[name=menu_is_active]').prop('checked', false);
    if (data.type === 1) {
        $('#menu_state_page_category').hide();
        $('#menu_state_page_single').show();
        $('input[name=state_menu_category]').prop('checked', false);
        $('select[name=page_id]').children("option").removeAttr('selected');
        $('select[name=page_id]').children("option[value=" + data['content_id'] + "]").attr('selected', 'selected');
    } else {
        $('#menu_state_page_category').show();
        $('#menu_state_page_single').hide();
        $('input[name=state_menu_category]').prop('checked', true);
        $('select[name=category_id]').children("option").removeAttr('selected');
        $('select[name=category_id]').children("option[value=" + data['content_id'] + "]").attr('selected', 'selected');
    }
}
function resetForm() {
    $('input[name=state]').val('insert');
    $('form#frmCreateThuNghiem').attr('action', getBaseURL() + "sml_admin/menu-create");
    $('input[name=_method]').val('POST');
    $('input[name=name]').val('');
    $('.test_info_right h3.title').html('Tạo Mới Menu');
    $('input[name=parentId]').val('');
    $('input[name=mainId]').val('');
    $('input[name=level]').val('');
    $('input[name=order]').val('');
    $('#menu_state_page_category').hide();
    $('#menu_state_page_single').show();
    $('input[name=menu_is_active]').prop('checked', false);
    $('input[name=state_menu_category]').prop('checked', false);
    $('select[name=page_id]').children("option").removeAttr('selected');
    $('select[name=page_id]').children("option[value=0]").attr('selected', 'selected');
    $('select[name=category_id]').children("option").removeAttr('selected');
    $('select[name=category_id]').children("option").first().attr('selected', 'selected');
}
function loadTreeMenu() {
    $.ajax({
        type: "GET",
        url: getBaseURL() + "sml_admin/load-tree",
        dataType: 'json',
        success: function (data) {
            var runTree = $('#tree').tree({
                uiLibrary: 'bootstrap4',
                dataSource: data,
                primaryKey: 'id',
                dragAndDrop: true
                // imageUrlField: 'flagUrl'
            });
            runTree.bind('select', {key: data}, function (e, node, id) {
                $.ajax({
                    type: "GET",
                    url: getBaseURL() + "sml_admin/find/" + id,
                    dataType: 'json',
                    success: function (data2) {
                        loadDataFormWhenSelectTreeMenu(data2)
                    }
                });
            });
            runTree.on('nodeDrop', function (e, id, parentId, orderNumber) {
                console.log(orderNumber);
                if (parentId == null)
                    parentId = 0;
                $.ajax({
                    type: "GET",
                    url: getBaseURL() + "sml_admin/updateNodeFamily/" + id + "/" + parentId,
                    dataType: 'json',
                    success: function (data2) {
                        // loadDataFormWhenSelectTreeMenu(data2)
                    }
                });
            });
        },
        error: function (data) {
            // alert(data);
        }
    });
}
loadTreeMenu();
if ($('#select_state_menu_category').is(':checked')) {
    $('#menu_state_page_category').show();
    $('#menu_state_page_single').hide();
}
else {
    $('#menu_state_page_category').hide();
    $('#menu_state_page_single').show();
}
$('#select_state_menu_category').change(function () {
    if ($('#select_state_menu_category').is(':checked')) {
        $('#menu_state_page_category').show();
        $('#menu_state_page_single').hide();
    }
    else {
        $('#menu_state_page_category').hide();
        $('#menu_state_page_single').show();
    }
});


$('#test_info_state_menu').change(function () {
    switch ($(this).val()) {
        case '1':
            $('#menu_state_page').show();
            break;
        case '2':
            $('#menu_state_page').hide();
            break;
    }
});
$('#sumbitFormThuNghiem').click(function () {
    $('#frmCreateThuNghiem').submit();
});
$('button#addMoreMenu').click(function () {
    $('button#deleteMenu').hide();
    resetForm();
});
$('button#addSubMenu').click(function () {
    $('button#deleteMenu').hide();
    var id = $('input[name=mainId]').val();
    var name = $('input[name=name]').val();
    var level = $('input[name=level]').val();
    resetForm();
    $('.test_info_right h3.title').html('Thêm Menu Con Cho: ' + name)
    $('input[name=parentId]').val(id);
    $('input[name=level]').val(level);

});

$('button#deleteMenu').click(function () {
    var id = $('input[name=mainId]').val();
    $('form#frmCreateThuNghiem').attr('action', getBaseURL() + "sml_admin/menu-delete/" + id);
    $('input[name=_method]').val('Delete');
    $('#frmCreateThuNghiem').submit();
});


if ($('#btnBrowseImageMobile').length) {
    var button1 = document.getElementById('btnBrowseImageMobile');
    button1.onclick = function () {
        selectFileWithKCFinder('pathImageMobile','showHinhMobile');
    }
}