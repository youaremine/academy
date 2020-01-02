$(document).ready(function () {
    let data = getInfo();
    if (data !== null && data !== "") {
        let iden = data[0].jobNoNew;
        let info = data[0].vehicle;
        let imgUrl = data[0].img_url;
        let total=data[0].total;
        let surplus=data[0].surplus;
         judgePlan(iden);
        analysisDate(iden, info, imgUrl,total,surplus);
    }
    let url="ozzomonitoringsurvey://chat.app/?jobNo="+data[0].jobNoShort+"&refNo="+data[0].jobNoNew+"&surveyType="+data[0].surveyType;
    $('.serial').attr('href',url);
})

/**
 * 向后端发送请求，获取物品信息
 * @returns {*} 返回一个JSON对象
 */
function getInfo(iden=null) {
    let result;
    $.ajax({
        url: "../account/jobs_4_data.php",
        type: "post",
        dataType: "JSON",
        async: false,
        data: {
            REQUEST: "w",
            IDEN:iden
        },
        success: function (e) {
            result = e;
            return result;
        }
    })
    return result;
}

/**
 * 对传回的信息的处理
 * @param iden 传回的物品编号
 * @param info 传回的详细内容
 * @param imgUrl 传回的图片url
 * @param total 传回的物品总数
 * @param surplus 传回剩余物品数量
 */
function analysisDate(iden, info, imgUrl,total,surplus) {
    $(".serial>em").text(iden);
    $(".info-table tr:nth-of-type(2)>td:nth-of-type(2)").text(info);
    $(".info-table tr:nth-of-type(3)>td:nth-of-type(2)").text(total);
    $(".info-table tr:nth-of-type(4)>td:nth-of-type(2)").text(surplus);

    if(imgUrl!==null && imgUrl!==""){
        let urlArr = imgUrl.split(",");
        let length = urlArr.length;
        for (let i = 0; i < length; i++) {
            if (i == length - 1) {
                var numb = urlArr[i].indexOf('.');
                if (numb == -1) {
                    break;
                }
            }
            imgPage(urlArr[i], i);
        }
    }else{
        imgPage("/images/goods/20191220150910-5dfc739692f10.jpg",0);
    }
}

/**
 * 默认图片样式
 * @param url 图片的url
 * @param i 第i个url
 */
function imgPage(url, i) {
// 第一步，生成元素标签
    let liElement = document.createElement("li");
    let divElement = document.createElement("div");
    let imgElement = document.createElement("img");
//赋类
    if (i == 0) {
        liElement.setAttribute("class", "active");
        divElement.setAttribute("class", "carousel-item active");
    } else {
        divElement.setAttribute("class", "carousel-item");
    }
    imgElement.setAttribute("class", "d-block w-100 img-fluid");
//添加方法
    liElement.setAttribute("data-target", "#carouselExampleIndicators");
    liElement.setAttribute("data-slide-to", i);
//添加属性
    divElement.setAttribute("style", "width:100%;height:18rem");
    imgElement.setAttribute("style", "object-fit:contain");
    liElement.setAttribute("style", "background-color:#088cf4");
//添加url
    imgElement.setAttribute("src", "/academy" + url);
//添加节点
    divElement.appendChild(imgElement);
    $('.img-indicator').append(liElement);
    $('.img-inner').append(divElement);
    // touchSwitch(imgElement);
}


/**
 * 返回上一页
 */
function returnTop() {
    top.location='./jobs_4.php';
}

/**
 * 添加滑动触摸事件
 * @param element
 */
function touchSwitch(element){
    element.addEventListener('touchstart', touchStart); //触摸开始
    element.addEventListener('touchmove', touchMove);  //触摸移动
    element.addEventListener('touchend', function() {
        isMove = false;//控制器，控制是否结束
    });
}
//开始触摸屏幕时
function touchStart(e) {
    isMove = true;
    startX = e.touches[0].clientX;  //触摸起始X位置
}
//滑动过程
function touchMove(e) {
    if(isMove) {
        var moveX = e.touches[0].clientX - startX;//触摸滑动距离
        if(moveX < -25) { //向左滑动
            e.preventDefault(); //浏览器不要执行与事件关联的默认动作
            $('.carousel').carousel('prev')//向左滑动执行事件
        } else if(moveX > 25) { //向右滑动
            e.preventDefault(); //浏览器不要执行与事件关联的默认动作
            $('.carousel').carousel('next')//向左滑动执行事件
        }
    }
}

/**
 * 加入购物车
 * @param event
 */
function addPlan(event){
    var num=$(".serial>em").text();
    $.ajax({
        type : "GET",
        url : "./api.php",
        data : "q=selectJob&jobNoNew=" +num+"&identifier=0",
        dataType : "json",
        success : function(msg) {
            console.log(msg);
            if(msg.success){
                event.innerHTML="已購買";
                event.setAttribute('class','btn btn-danger');
                event.setAttribute('onclick','');
            }
        }
    });
}

/**
 * 更改已购买的样式
 * @param iden
 */
function judgePlan(iden){
    iden=iden.substring(0,4);
    var judgeInfo=getInfo(iden);
    if (judgeInfo!==null && judgeInfo!==""){
        $('.table-button button:first').attr('class','btn btn-danger');
        $('.table-button button:first').attr('onclick','');
        $('.table-button button:first').text('已購買');
    }
}