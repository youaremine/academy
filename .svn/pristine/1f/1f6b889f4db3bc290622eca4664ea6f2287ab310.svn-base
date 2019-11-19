/*
 * Header: 
 * Create: 2008-05-31
 * Auther: Jamblues@gmail.com.
 */
 Ext.BLANK_IMAGE_URL = '/extjs/resources/images/default/s.gif';
 Ext.QuickTips.init();
 Ext.form.Field.prototype.msgTarget = 'side'; 
 function OpenUpload(url)
 {
 	Ext.onReady(function() {
		var win = new Ext.Window({
			 title:'Upload File'
			,id:'win'
			,width:640
			,height:480
			,closable:true
			,resizable:true
			,minimizable:true
			,maximizable:true
			,html: "<iframe src='"+url+"' style='width:100%; height:100%;'></iframe>"
			
		});
	
		win.show();
	 
	});
 }