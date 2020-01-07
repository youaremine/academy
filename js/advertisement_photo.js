function setThumbnail(e){
    var preview=e.parentNode.parentNode.children[2].children[0];//img标签
    var reader = new FileReader();//创建fileReader对象
    var fileName=e.parentNode.parentNode.children[3];
    var resolution=e.parentNode.parentNode.children[4];
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
            resolution.innerHTML=width+"*"+height;
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