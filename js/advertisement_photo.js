$(document).ready(function () {
    formerImg();
})

/**
 * 显示上传图片信息
 * @param e
 */
function setThumbnail(e) {
    var preview = e.parentNode.parentNode.children[5].children[0];//img标签
    var reader = new FileReader();//创建fileReader对象
    var fileName = e.parentNode.parentNode.children[6];
    var ratio = e.parentNode.parentNode.children[2].innerHTML;
    var resolution = e.parentNode.parentNode.children[7];
    var judge = e.parentNode.parentNode.children[8];

    if (e.files[0]) {
        var type=e.value.match(/^(.*)(\.)(.{1,8})$/)[3];
        type=type.toUpperCase();
        if(type!="JPEG"   &&   type!="PNG"   &&   type!="JPG"   &&   type!="GIF" ){
            alert("上传图片类型错误,只支持'JPEG','PNG','JPG','GIF'格式图片");
            return false;
        }
        //判定上传的文件不为空
        var f = e.files[0];
        fileName.innerHTML = f.name;//显示文件名
        reader.readAsDataURL(f);//将文件转换为二进制DataURL
    }
    //读取完成后触发事件
    reader.onload = function () {
        //创建Image对象，并写入图片地址
        var noneImg = new Image();
        noneImg.setAttribute('src', reader.result);
        //当图片地址载入完成后触发
        noneImg.onload = function () {
            //获取分辨率
            var width = noneImg.naturalWidth;
            var height = noneImg.naturalHeight;
            var divisor = maxDivisor(height, width)
            resolution.innerHTML = width + "*" + height + "(" + width / divisor + ":" + height / divisor + ")";

            var startNum = ratio.indexOf('(');
            var endNum = ratio.indexOf(')');
            if (ratio.slice(startNum + 1, endNum) == (width / divisor + ":" + height / divisor)) {
                judge.innerHTML = '√';
                judge.setAttribute('style', 'background:#E5F8DF');
                judge.setAttribute('ev', '1');
            } else {
                judge.innerHTML = '×'
                judge.setAttribute('style', 'background:red');
                judge.setAttribute('ev', '2');
            }
            preview.setAttribute('src', reader.result);
            if (width > height) {
                preview.setAttribute('width', '80%');
                preview.setAttribute('height', '');
            } else if (width < height) {
                preview.setAttribute('height', '80%');
                preview.setAttribute('width', '');
            } else {
                preview.setAttribute('height', '70%');
                preview.setAttribute('width', '');
            }
        }
    }
}

/**
 * 进行文件上传处理
 */
function fileUpload() {
    $('.progress-bar').text('0%');
    $('.progress-bar').attr('style', 'width:0%');
    var file1 = $('.file-input')[0].files;
    var file2 = $('.file-input')[1].files;
    var file3 = $('.file-input')[2].files;
    var file4 = $('.file-input')[3].files;
    var file5 = $('.file-input')[4].files;
    var file6 = $('.file-input')[5].files;
    var ranking = $('.sel').val();
    if (ranking == '第一張') {
        ranking = 1;
    } else if (ranking == '第二張') {
        ranking = 2;
    } else if (ranking == '第三張') {
        ranking = 3;
    }
    var resolutionArr = new Array();
    if (imageNull(file1) && $('.ev:eq(0)').attr('ev') == '1') {
        var resolution1Info = resolutionInfo(1);
        if (imageNull(file2) && $('.ev:eq(1)').attr('ev') == '1') {
            var resolution2Info = resolutionInfo(2);
            if (imageNull(file3) && $('.ev:eq(2)').attr('ev') == '1') {
                var resolution3Info = resolutionInfo(3);
                if (imageNull(file4) && $('.ev:eq(3)').attr('ev') == '1') {
                    var resolution4Info = resolutionInfo(4);
                    var data = new FormData();
                    data.append('file1', file1[0]);
                    data.append('file2', file2[0]);
                    data.append('file3', file3[0]);
                    data.append('file4', file4[0]);
                    var resolutionArr = new Array();
                    resolutionArr.push(resolution1Info, resolution2Info, resolution3Info, resolution4Info)
                    if (imageNull(file5) && $('.ev:eq(4)').attr('ev') == '1') {
                        var resolution5Info = resolutionInfo(5);
                        data.append('file5', file5[0]);
                        resolutionArr.push(resolution5Info)
                    }
                    if (imageNull(file6) && $('.ev:eq(5)').attr('ev') == '1') {
                        var resolution6Info = resolutionInfo(6);
                        data.append('file6', file6[0]);
                        resolutionArr.push(resolution6Info)
                    }
                    var info = traInfo(ranking, resolutionArr);
                    if (info.status === true) {
                        $.ajax({
                            type: 'POST',
                            url: "advertisement_photo.php",
                            data: data,
                            cache: false,//上传文件不需要缓存
                            // async: true,//设置异步
                            processData: false,
                            contentType: false,
                            xhr: function () {
                                myXhr = $.ajaxSettings.xhr();
                                if (myXhr.upload) { // check if upload property exists
                                    myXhr.upload.addEventListener('progress', function (e) {
                                        var loaded = e.loaded;                                  //已经上传大小情况
                                        var total = e.total;                                    //附件总大小
                                        var percent = Math.floor(90 * loaded / total);      //已经上传的百分比
                                        let n = Number($('.progress-bar').text().slice(0, -1));//显示的进度条
                                        console.log(percent);
                                        //第一次上传进度传回
                                        if (percent > 0 && percent < 90 && n == 0) {
                                            let i = 1;
                                            var setTime1 = setInterval(function () {
                                                $('.progress-bar').text(i + '%');
                                                $('.progress-bar').attr('style', 'width:' + i + '%');
                                                i++;
                                                if (i == percent) {
                                                    clearInterval(setTime1);
                                                }
                                            }, 350)
                                        }
                                        //后续传回
                                        if(percent > 0 && percent < 90 && n != 0){
                                            clearInterval(setTime1);
                                            clearInterval(setTime2);
                                            let i = n;
                                            var setTime2 = setInterval(function () {
                                                $('.progress-bar').text(i + '%');
                                                $('.progress-bar').attr('style', 'width:' + i + '%');
                                                i++;
                                                if (i == percent) {
                                                    clearInterval(setTime2);
                                                }
                                            }, 300)
                                        }
                                        //最后一次传回
                                        if(percent==90){
                                            clearInterval(setTime1);
                                            clearInterval(setTime2);
                                            let i = n;
                                            var setTime3 = setInterval(function () {
                                                $('.progress-bar').text(i + '%');
                                                $('.progress-bar').attr('style', 'width:' + i + '%');
                                                i++;
                                                if (i == 96) {
                                                    clearInterval(setTime3);
                                                }
                                            }, 400)
                                        }
                                    }, false);
                                }
                                return myXhr;
                            },
                            success: function (ret) {
                                $('.progress-bar').text('100%');
                                $('.progress-bar').attr('style', 'width:100%');
                                setTimeout(function () {
                                    emptyInnerHTML();
                                    alert("已成功上传")
                                }, 1000);
                            }
                        });
                    }
                } else {
                    alert('1242*2688分辨率圖片不符合要求');
                }
            } else {
                alert('1080*2160分辨率圖片不符合要求');
            }
        } else {
            alert('1440*2560分辨率圖片不符合要求');
        }
    } else {
        alert('640*960分辨率圖片不符合要求');
    }
}

$('.sel').change(function () {
    var page = $('.sel').val();
    $('.box tr td:nth-of-type(2)').text(page);
    formerImg();
    emptyInnerHTML();
})

/**
 * 求最大公約數
 * @param a
 * @param b
 * @returns {*}
 */
function maxDivisor(a, b) {
    if (a % b === 0) {
        return b;
    }
    return arguments.callee(b, a % b);
}

/**
 * 判斷數組是否為空
 * @param e
 * @returns {boolean}
 */
function imageNull(e) {
    if (e.length == 0) {
        return false;
    } else {
        return true;
    }
}

/**
 * 向后端传递其他信息
 * @param ranking 第几张图片
 * @param resolutionArr 实际分辨率数组
 * @returns {*}
 */
function traInfo(ranking, resolutionArr) {
    var result;
    $.ajax({
        url: "advertisement_photo.php",
        type: "POST",
        traditional: true,//数组格式
        dataType: 'JSON',
        async: false, //不异步
        data: {
            'ranking': ranking,
            'resolutionArr': JSON.stringify(resolutionArr)
        },
        success: function (e) {
            result = e;
            return result;
        }
    })
    return result;
}

/**
 * 获取分辨率
 * @param n
 * @returns {string}
 */
function resolutionInfo(n) {
    resolution = $('.box tr:eq(' + n + ') td:eq(7)').text();
    info = resolution.substring(0, resolution.indexOf('('));
    return info;
}

/**
 * 获取缩略图
 * @param ranking
 */
function formerImg(ranking=null) {
    if(ranking==null){
        ranking = $('.sel').val();
        if (ranking == '第一張') {
            ranking = 1;
        } else if (ranking == '第二張') {
            ranking = 2;
        } else if (ranking == '第三張') {
            ranking = 3;
        }
    }
    $.ajax({
        url: "advertisement_photo.php",
        type: "POST",
        dataType: 'JSON',
        async: false,
        data: {
            inquire: 'inquire',
            ranking: ranking
        },
        success: function (e) {
            if (e['code'] == 1) {
                for (let i = 0; i < e['data'].length; i++) {
                    let url = e['data'][i]['condense_path'];
                    $('.box tr:eq(' + (i + 1) + ') td:eq(4)>img').attr('src', url);
                }
            }
            if (e['code'] == 0) {
                for (let i = 0; i < 5; i++) {
                    $('.box tr:eq(' + (i + 1) + ') td:eq(4)>img').attr('src', '');
                }
            }
        }
    })
}

/**
 * 初始化頁面
 */
function emptyInnerHTML() {
    $('.box tr:eq(1) td:eq(5)>img').attr('src', '');
    $('.box tr:eq(2) td:eq(5)>img').attr('src', '');
    $('.box tr:eq(3) td:eq(5)>img').attr('src', '');
    $('.box tr:eq(4) td:eq(5)>img').attr('src', '');
    $('.box tr:eq(5) td:eq(5)>img').attr('src', '');
    $('.box tr:eq(6) td:eq(5)>img').attr('src', '');
    $('.box tr:eq(1) td:eq(6)').text('');
    $('.box tr:eq(2) td:eq(6)').text('');
    $('.box tr:eq(3) td:eq(6)').text('');
    $('.box tr:eq(4) td:eq(6)').text('');
    $('.box tr:eq(5) td:eq(6)').text('');
    $('.box tr:eq(6) td:eq(6)').text('');
    $('.box tr:eq(1) td:eq(7)').text('');
    $('.box tr:eq(2) td:eq(7)').text('');
    $('.box tr:eq(3) td:eq(7)').text('');
    $('.box tr:eq(4) td:eq(7)').text('');
    $('.box tr:eq(5) td:eq(7)').text('');
    $('.box tr:eq(6) td:eq(7)').text('');
    $('.box tr:eq(1) td:eq(8)').text('');
    $('.box tr:eq(2) td:eq(8)').text('');
    $('.box tr:eq(3) td:eq(8)').text('');
    $('.box tr:eq(4) td:eq(8)').text('');
    $('.box tr:eq(5) td:eq(8)').text('');
    $('.box tr:eq(6) td:eq(8)').text('');
    $('.box tr:eq(1) td:eq(8)').attr('ev', '');
    $('.box tr:eq(2) td:eq(8)').attr('ev', '');
    $('.box tr:eq(3) td:eq(8)').attr('ev', '');
    $('.box tr:eq(4) td:eq(8)').attr('ev', '');
    $('.box tr:eq(5) td:eq(8)').attr('ev', '');
    $('.box tr:eq(6) td:eq(8)').attr('ev', '');

    $('.box tr:eq(1) td:eq(8)').attr('style', 'background:#E5F8DF');
    $('.box tr:eq(2) td:eq(8)').attr('style', 'background:#E5F8DF');
    $('.box tr:eq(3) td:eq(8)').attr('style', 'background:#E5F8DF');
    $('.box tr:eq(4) td:eq(8)').attr('style', 'background:#E5F8DF');
    $('.box tr:eq(5) td:eq(8)').attr('style', 'background:#E5F8DF');
    $('.box tr:eq(6) td:eq(8)').attr('style', 'background:#E5F8DF');

    $('.progress-bar').text('0%');
    $('.progress-bar').attr('style', 'width:0');
}

/**
 * 重置
 */
function resetHTML(){
    $('.sel').val('第一張');
    $('.box tr td:nth-of-type(2)').text('第一張');
    formerImg(1);
    emptyInnerHTML();
}

