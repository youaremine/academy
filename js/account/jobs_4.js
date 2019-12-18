$(document).ready(function(){
   var data= getInfo();
   if (data!=="" && data!==null){
        var length=data.length;
        for (var i=0;i<length;i++){
            goodsStyle(data[i]);
        }
   }
})

/**
 * 向后端发送请求，获取物品信息
 * @returns {*} 返回一个JSON对象
 */
function getInfo(){
    var result;
    $.ajax({
        url:"../account/jobs_4.php",
        type:"post",
        dataType:"JSON",
        async:false,
        data:{
            TYPE:"q"
        },
        success:function(e){
            result=e;
            return result;
        }
    })
    return result;
}

/**
 * 生成固定样式
 * @param goods 传入商品数据信息
 */
function goodsStyle(goods){
//新建元素
    var infoA = document.createElement("a"); //存储整个信息a标签
    var boxDiv=document.createElement("div");//外层div
    var imgDiv=document.createElement("div");//图片div
    var infoDiv=document.createElement("div");//信息div
    var titleDiv=document.createElement("div");//标题div
    var conDiv=document.createElement("div");//内容div
    var buttonDiv=document.createElement("div");//按键div
    var img=document.createElement("img")//图片img
    var button=document.createElement("button");//购物车按键
//赋类
    boxDiv.setAttribute("class", "row mt-2");
    imgDiv.setAttribute("class", "col-5 border border-danger p-1 text-center");
    infoDiv.setAttribute("class", "col-5");
    buttonDiv.setAttribute("class", "col-2");
    button.setAttribute("class", "btn btn-info ");
    img.setAttribute("class", "img-fluid img-thumbnail");
    titleDiv.setAttribute("class", "font-weight-bold text-monospace");
    conDiv.setAttribute("class", "text-primary");
//css样式
    boxDiv.setAttribute("style", "height:18rem;");
    titleDiv.setAttribute("style", "font-size:2rem;");
    conDiv.setAttribute("style", "font-size:1rem;text-indent:2em;");
    img.setAttribute("style", "width: 18rem;height: 18rem");
    buttonDiv.setAttribute("style", "margin-top: 8rem");
//赋内容
    titleDiv.innerHTML = goods.jobNoShort+"-"+goods.surveyType;
    conDiv.innerHTML=goods.vehicle;
    button.innerHTML="加入购物车";
//添加URL
    var urlArr=goods.img_url.split(",");
    img.setAttribute("src", ".."+urlArr[0]);
    var urlDetails="./goods_details.php?jobNoShort="+goods.jobNoShort;
    infoA.setAttribute("href", urlDetails);
//添加节点
    imgDiv.appendChild(img);
    buttonDiv.appendChild(button);
    boxDiv.appendChild(imgDiv);
    infoDiv.appendChild(titleDiv);
    infoDiv.appendChild(conDiv);
    boxDiv.appendChild(infoDiv);
    boxDiv.appendChild(buttonDiv);
    infoA.appendChild(boxDiv);
    $('.box').append(infoA);
}