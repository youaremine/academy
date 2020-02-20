$(document).ready(function(){
    // var page=$('.sel').val();
    // $('.box tr td:nth-of-type(2)').text(page);
})
/**
 * 显示上传图片信息
 * @param e
 */
function setThumbnail(e){
    var preview=e.parentNode.parentNode.children[4].children[0];//img标签
    var reader = new FileReader();//创建fileReader对象
    var fileName=e.parentNode.parentNode.children[5];
    var ratio=e.parentNode.parentNode.children[2].innerHTML;
    var resolution=e.parentNode.parentNode.children[6];
    var judge=e.parentNode.parentNode.children[7];
    if (e.files){
        //判定上传的文件不为空
        var f = e.files[0];
        fileName.innerHTML=f.name;//显示文件名
        reader.readAsDataURL(f);//将文件转换为DataURL
    }
    //读取完成后触发事件
    reader.onload=function(){
        //创建Image对象，并写入图片地址
        var noneImg=new Image();
        noneImg.setAttribute('src',reader.result);
        //当图片地址载入完成后触发
        noneImg.onload=function () {
            //获取分辨率
            var width = noneImg.naturalWidth;
            var height = noneImg.naturalHeight;
            var divisor=maxDivisor(height,width)
            resolution.innerHTML=width+"*"+height+"("+width/divisor+":"+height/divisor+")";

            var startNum=ratio.indexOf('(');
            var endNum=ratio.indexOf(')');
if(ratio.slice(startNum+1,endNum)==(width/divisor+":"+height/divisor)){
    judge.innerHTML='√';
    judge.setAttribute('style','background:#E5F8DF');
    judge.setAttribute('ev','1');
}else{
    judge.innerHTML='×'
    judge.setAttribute('style','background:red');
    judge.setAttribute('ev','2');
}
            preview.setAttribute('src',reader.result);
            if(width>height){
                preview.setAttribute('width','80%');
                preview.setAttribute('height','');
            }else if(width<height){
                preview.setAttribute('height','80%');
                preview.setAttribute('width','');
            }else{
                preview.setAttribute('height','70%');
                preview.setAttribute('width','');
            }
        }
    }
}

function fileUpload(){
    var file1=$('.file-input')[0].files;
    var file2=$('.file-input')[1].files;
    var file3=$('.file-input')[2].files;
    var file4=$('.file-input')[3].files;
    var file5=$('.file-input')[4].files;
    var file6=$('.file-input')[5].files;

if(imageNull(file1)&&$('.ev:eq(0)').attr('ev')=='1'){
    if(imageNull(file2)&&$('.ev:eq(1)').attr('ev')=='1'){
        if(imageNull(file3)){
            //&&$('.ev:eq(2)').attr('ev')=='1'
            if(imageNull(file4)){
                //&&$('.ev:eq(3)').attr('ev')=='1'
                var data = new FormData();
                data.append('file1',file1[0]);
                data.append('file2',file2[0]);
                data.append('file3',file3[0]);
                data.append('file4',file4[0]);
                if(imageNull(file5)&&$('.ev:eq(4)').attr('ev')=='1'){
                    data.append('file5',file5[0]);
                }
                if(imageNull(file6)&&$('.ev:eq(5)').attr('ev')=='1'){
                    data.append('file6',file6[0]);
                }
                $.ajax({
                    type: 'POST',
                    url: "advertisement_photo.php",
                    data:data,
                    cache: false,
                    processData: false,
                    contentType: false,
                    success: function (ret) {
                        alert(ret);
                    }
                });
            }else{
                alert('1242*2688分辨率圖片不符合要求');
            }
        }else{
            alert('1080*2160分辨率圖片不符合要求');
        }
    }else{
        alert('1440*2560分辨率圖片不符合要求');
    }
}else{
    alert('640*960分辨率圖片不符合要求');
}




}
$('.sel').change(function (){
    var page=$('.sel').val();
    $('.box tr td:nth-of-type(2)').text(page);
})

/**
 * 求最大公約數
 * @param a
 * @param b
 * @returns {*}
 */
function maxDivisor(a,b){
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
function imageNull(e){
    if(e.length==0){
        return false;
    }else{
        return  true;
    }
}