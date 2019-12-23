$(document).ready(function(){
   let data= getInfo('q');
   if (data!=="" && data!==null){
       let length=data.length;
        for (let i=0;i<length;i++){
            let sign=judgePlan(data[i].jobNoShort);
            goodsStyle(data[i],sign);
            if(i!==length-1){
                let hr = document.createElement("hr"); //分割线
                $('.box').append(hr);
            }
        }
   }
})

/**
 * 向后端发送请求，获取信息
 * @returns {*} 返回一个JSON对象
 */
function getInfo(n,iden=null){
    var result;
    $.ajax({
        url:"../account/jobs_4_data.php",
        type:"post",
        dataType:"JSON",
        async:false,
        data:{
            REQUEST:n,
            IDEN:iden
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
function goodsStyle(goods,sign){
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
    // imgDiv.setAttribute("class", "col-5 p-1 text-center");
    // infoDiv.setAttribute("class", "col-4");
    imgDiv.setAttribute("class", "col-7 p-1 text-center");
    infoDiv.setAttribute("class", "col-5");
    buttonDiv.setAttribute("class", "col-3");
    img.setAttribute("class", "img-fluid img-thumbnail");
    titleDiv.setAttribute("class", "font-weight-bold text-monospace");
    conDiv.setAttribute("class", "text-dark text-truncate");
    if(sign){
        button.setAttribute("class", "btn btn-danger");
    }else{
        button.setAttribute("class", "btn btn-primary");
    }
    infoA.setAttribute('class','col-9 row');
//css样式
    boxDiv.setAttribute("style", "height:18rem;");
    titleDiv.setAttribute("style", "font-size:2rem;");
    conDiv.setAttribute("style", "font-size:2rem;");
    img.setAttribute("style", "width: 18rem;height: 18rem");
    buttonDiv.setAttribute("style", "margin-top: 7rem;");
//赋内容
    titleDiv.innerHTML = "商品编号:"+goods.jobNoShort+"<br/>商品名:"+goods.surveyType;
    conDiv.innerHTML=goods.vehicle;
    if(sign){
        button.innerHTML="已添加";
    }else{
        button.innerHTML="加入购物车";
    }
    button.setAttribute('data-num',goods.jobNoNew);
//添加URL
    if(goods.img_url!==null && goods.img_url!==""){
        var urlArr=goods.img_url.split(",");
        img.setAttribute("src", ".."+urlArr[0]);
    }else{
        img.setAttribute("src", "../images/goods/20191220150910-5dfc739692f10.jpg");
    }
    var urlDetails="./jobs_4_data.php?jobNoShort="+goods.jobNoShort;
    infoA.setAttribute("href", urlDetails);
//添加事件
    if(!sign){
        button.setAttribute("onclick","addPlan(this)");
    }
//添加节点
//     imgDiv.appendChild(img);
//     buttonDiv.appendChild(button);
//     boxDiv.appendChild(imgDiv);
//     infoDiv.appendChild(titleDiv);
//     infoDiv.appendChild(conDiv);
//     boxDiv.appendChild(infoDiv);
//     boxDiv.appendChild(buttonDiv);
//     infoA.appendChild(boxDiv);
//     $('.box').append(infoA);
    //添加节点
    imgDiv.appendChild(img);
    buttonDiv.appendChild(button);
    infoDiv.appendChild(titleDiv);
    infoDiv.appendChild(imgDiv);
    infoA.appendChild(imgDiv);
    infoA.appendChild(infoDiv);
    boxDiv.appendChild(infoA);
    boxDiv.appendChild(buttonDiv);
    $('.box').append(boxDiv);

}

/**
 * 加入购物车事件
 * @param event
 */
function addPlan(event){
    var num=event.getAttribute('data-num');
    $.ajax({
        type : "GET",
        url : "./api.php",
        data :"q=selectJob&jobNoNew=" +num+"&identifier=0",
        dataType : "json",
        success : function(msg) {
           if(msg.success){
               event.innerHTML="已添加";
               event.setAttribute('class','btn btn-danger');
               event.setAttribute('onclick','');
           }
        }
    });
}

/**
 * 判断是否已购买
 * @param iden 物品编号
 * @returns {boolean}
 */
function judgePlan(iden){
    var judgeInfo=getInfo('w',iden);
    if (judgeInfo!==null && judgeInfo!==""){
        return true;
    }else{
        return false;
    }
}