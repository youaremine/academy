$(document).ready(function(){
   $("#emptyWrap").hide();

   if($("#wrap").length == 0){
       $("#emptyWrap").show();
   }



})

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
 * 设置当物品数量为空时
 */
function emptyWrap(){
    $('.emptyWrap').attr('display','block');
}