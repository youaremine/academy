$(document).ready(function () {
    let jobNoShort = $("#jobNoShort").text();
    getInfo( jobNoShort );

})


/**
 * type:stripe,wechat,alipay
 * 支付
 * */
function payment(){
    let key = 'pk_test_51IBweYKfjMsC8JpVYa69N3EGmc5MXNagdLf3W3ZJpQ3BopHd96K0mTQBqwQtQjBAQpXvI2ubuTLAeFxsmMUT2PbX00vavBARBp';
    let pay_type = $("#select_pay input[type='radio']:checked").val();
    let jobNoShort = $("#jobNoShort").text();
    let jobNoNew = $("#jobNoNew").text();

    if(!jobNoNew){
        alert('請刷新后重試');
    }

    $.ajax({
        type : "POST",
        url : "./Payment.php",
        data : {'type':pay_type,'jobNoShort':jobNoShort,'jobNoNew':jobNoNew},
        dataType : "json",
        success : function(data) {
            console.log(data);
            if(data.code == 200){
                if(pay_type == 'stripe'){

                    var stripe = Stripe(key);
                    return stripe.redirectToCheckout({ sessionId: data.data });

                }else if(pay_type == 'wechat'){
                    window.location.href = 'ozzoacademy-wechat-pay://students.app/?info='+data;
                }else if(pay_type == 'alipay'){
                    window.location.href = 'ozzoacademy-wechat-pay://students.app/?info='+data;
                }
            }else{
                alert(data.msg);
            }
        }
    });
}


/**
 * 向后端发送请求，获取物品信息
 * @returns {*} 返回一个JSON对象
 */
function getInfo(jobNo = null) {
    let result;
    $.ajax({
        url: "../account/jobs_4_data.php",
        type: "post",
        dataType: "JSON",
        data: {
            REQUEST: "w",
            IDEN:jobNo
        },
        success: function (data) {
            console.log(data);
            if(data.code == 404){
                alert(data.msg);
                return;
            }
            let imgUrl = data.img_url;
            let total = data.total;
            let surplus = data.surplus;
            let project = data.project;
            let amount = data.amount;
            let url="ozzomonitoringsurvey://chat.app/?jobNo="+data.jobNoShort+"&refNo="+data.jobNoNew+"&surveyType="+data.surveyType;

            $("#jobNoNew").text(data.jobNoNew);
            $(".info-table tr:nth-of-type(2)>td:nth-of-type(2)").text(data.vehicle);
            $(".info-table tr:nth-of-type(3)>td:nth-of-type(2)").text(total);
            $(".info-table tr:nth-of-type(4)>td:nth-of-type(2)").text(surplus);
            $("#amount").text(amount);

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
                    imgPage(urlArr[i], i,project);
                }
            }else{
                imgPage("/images/goods/20191220150910-5dfc739692f10.jpg",0,project);
            }

            if(data.buyed){
                $('#buy_btn').attr('class','btn btn-danger');
                $('#buy_btn').attr('onclick','');
                $('#buy_btn').text('已購買');
            }

            $(".serial>em").text(data.jobNoShort+'咨詢');
            $('.serial').attr('href',url);
        }
    })
    return result;
}


/**
 * 不用付款流程
 * @param event
 */
/*function addPlan(event){
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
*/



/**
* 支付寶支付
* */
function alipay(){
    $.ajax({
        type : "GET",
        url : "../alipayRsa/payment.php",
        data : {
            type:"paymentInfo"
        },
        dataType : "json",
        success : function(msg) {
            window.location.href = 'ozzoacademy-pay://students.app/?info='+msg;
            console.log(msg);
        }
    })
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
 * 默认图片样式
 * @param url 图片的url
 * @param i 第i个url
 */
function imgPage(url, i,project) {
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
    divElement.setAttribute("style", "width:100%;");
    imgElement.setAttribute("style", "object-fit:contain");
    liElement.setAttribute("style", "background-color:#088cf4");
//添加url
    imgElement.setAttribute("src", "/"+project+ url);
    // imgElement.setAttribute("src", "/bni-hk-marvel" + url);
//添加节点
    divElement.appendChild(imgElement);
    $('.img-indicator').append(liElement);
    $('.img-inner').append(divElement);
    // touchSwitch(imgElement);
}

