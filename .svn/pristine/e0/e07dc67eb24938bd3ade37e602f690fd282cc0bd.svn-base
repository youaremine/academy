/**
 * 浮动DIV定时显示提示信息,如操作成功, 失败等
 * 
 * @param string tips (提示的内容)
 * @param int height 显示的信息距离浏览器顶部的高度
 * @param int time 显示的时间(按秒算), time > 0
 * @sample <a href="javascript:void(0);" onclick="showTips( '操作成功', 100, 3 );">点击</a>
 * @sample 上面代码表示点击后显示操作成功3秒钟, 距离顶部100px
 * @copyright ZhouHr 2010-08-27
 */

function showTips( tips, height, time ){
	var windowWidth = document.documentElement.clientWidth;
	$('#tips').remove();
	var tipsDiv = '<div class="tipsClass" id="tips">' + tips + '</div>';
	var tempTips = tips.replace(/<[^>]+>/g,"");//去掉HTML標記後再算長度
	$( 'body' ).append( tipsDiv );
	$( 'div.tipsClass' ).css({
		'top' : height + 'px',
		'left' : ( windowWidth / 2 ) - ( tempTips.length * 13 / 2 ) + 'px'
	}).show();
	setTimeout( function(){$( 'div.tipsClass' ).fadeOut();}, ( time * 1000 ) );
}