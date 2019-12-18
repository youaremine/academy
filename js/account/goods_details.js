$(document).ready(function(){
    var data= getInfo();
    console.log(data);
})
/**
 * 向后端发送请求，获取物品信息
 * @returns {*} 返回一个JSON对象
 */
function getInfo(){
    var result;
    $.ajax({
        url:"../account/goods_details.php",
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