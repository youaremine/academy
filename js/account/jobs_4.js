$(document).ready(function(){
   let data= getInfo('q');
   console.log(data);
   $("#emptyWrap").hide();
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
   }else{
       $("#emptyWrap").show();
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
        success:function(data){
            console.log(data);
            result = data;
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
    var imgDiv=document.createElement("div");//左侧div
    var img=document.createElement("img")//图片img

    var rightDiv=document.createElement("div");//右侧div
    var infoDiv=document.createElement("div");//信息div
    var titleDiv=document.createElement("div");//标题div
    var conDiv=document.createElement("div");//内容div
    var buttonDiv=document.createElement("div");//按键div
    var button=document.createElement("button");//购物车按键
//赋类
    boxDiv.setAttribute("class", "row mt-2");
    imgDiv.setAttribute("class", "col-6 p-1 text-center");
    rightDiv.setAttribute('class','col-6 p-0');
    conDiv.setAttribute("class", "text-dark text-truncate");
    img.setAttribute("class", "img-fluid img-thumbnail");
    infoDiv.setAttribute("class", "p-1");
    if(sign){
        button.setAttribute("class", "btn btn-danger");
    }else{
        button.setAttribute("class", "btn btn-primary");
    }
//css样式
    boxDiv.setAttribute("style", "height:9rem;");
    titleDiv.setAttribute("style", "font-size:0.8rem;");
    conDiv.setAttribute("style", "font-size:0.8rem;");
    img.setAttribute("style", "width: 9rem;height: 9rem");
    infoDiv.setAttribute("style", "height:6rem");
    buttonDiv.setAttribute("style", "line-height:3rem;height:3rem;text-align:center");
//赋内容
    titleDiv.innerHTML = "商品編號:"+goods.jobNoShort+"<br/>商品名:"+goods.surveyType;
    if(goods.vehicle!== null && goods.vehicle !==""){
        conDiv.innerHTML="詳情:"+goods.vehicle;
    }else{
        conDiv.innerHTML="詳情:暫無";
    }
    if(sign){
        button.innerHTML="已購買";
    }else{
        button.innerHTML="立即購買";
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
        // button.setAttribute("onclick","addPlan(this)");
    }
    //添加节点
    imgDiv.appendChild(img);
    buttonDiv.appendChild(button);
    infoDiv.appendChild(titleDiv);
    infoDiv.appendChild(titleDiv);
    infoDiv.appendChild(conDiv);
    rightDiv.appendChild(infoDiv);
    rightDiv.appendChild(buttonDiv);
    boxDiv.appendChild(imgDiv);
    boxDiv.appendChild(rightDiv);
    infoA.appendChild(boxDiv);
    $('.box').append(infoA);

}

/**
 * 加入购物车事件
 * @param event
 */
function addPlan(event){
    var aEvent=event.parentNode.parentNode.parentNode.parentNode;
    var aHerf= aEvent.getAttribute("href");
    aEvent.setAttribute("href", 'javascript:void(0)');
    var num=event.getAttribute('data-num');
    $.ajax({
        type : "GET",
        url : "./api.php",
        data :"q=selectJob&jobNoNew=" +num+"&identifier=0",
        dataType : "json",
        success : function(msg) {
           if(msg.success){
               event.innerHTML="已購買";
               event.setAttribute('class','btn btn-danger');
               event.setAttribute('onclick','');
               aEvent.setAttribute("href", aHerf);
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

/**
 * 设置当物品数量为空时
 */
function emptyWrap(){
    $('.emptyWrap').attr('display','block');
}