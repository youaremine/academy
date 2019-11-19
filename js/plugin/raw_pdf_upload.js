/*
 * Header: 
 * Create: 2009-03-12
 * Auther: Jamblues@gmail.com.
 */
 Ext.BLANK_IMAGE_URL = "/extjs/resources/images/default/s.gif";
 Ext.QuickTips.init();
 Ext.form.Field.prototype.msgTarget = 'side'; 
 function OpenUpload(jobNoNew,fileType)
 {
 	Ext.onReady(function() {
	    var form = new Ext.form.FormPanel({
	        baseCls: 'x-plain',
	        labelWidth:40,
	        url:'raw_pdf_upload_press.php',
			fileUpload:true,
	        defaultType: 'textfield',
	
	        items: [{
	        	xtype: 'hidden',
	            name: 'jobNoNew',
	            value: jobNoNew
	        },{
	        	xtype: 'hidden',
	            name: 'fileType',
	            value: fileType
	        },{
	            xtype: 'textfield',
	            fieldLabel: 'File',
	            name: 'userfile',
	            inputType: 'file',
	            allowBlank: false,
	            blankText: 'File can\'t not empty.',
	            cls: 'logintext',
	            anchor: '90%'  // anchor width by percentage
	        }]
	    });
	
	    var win = new Ext.Window({
	        title: 'Upload file',
	        width: 300,
	        height:120,
	        minWidth: 300,
	        minHeight: 120,
	        layout: 'fit',
	        plain:true,
	        bodyStyle:'padding:5px;',
	        buttonAlign:'center',
	        items: form,
	
	        buttons: [{
	            text: 'Upload',
	            handler: function() {
	            	if(form.form.isValid()){
		            	Ext.MessageBox.show({
							   title: 'Please wait',
							   msg: 'Uploading...',
							   progressText: '',
							   width:200,
							   progress:true,
							   closable:false,
							   animEl: 'loding'
						   });
				        form.getForm().submit({    
					        success: function(form, action){
					           Ext.Msg.alert('Message',action.result.msg);
					           win.hide();  
					        },    
					       failure: function(){    
					          Ext.Msg.alert('Error', 'File upload failure.');    
					       }
				       	})		       
			   		}
	           }
	        },{
	            text: 'Close',
	            handler:function(){win.hide();}
	        }]
	    });
	 	win.show();
	});
 }
 

//history grid
Ext.onReady(function(){
//	var url = '../user_history_list_json_local.php';
	var url = Ext.get('romote_pdf_host').dom.value + 'user_history_list_json_script_tag.php';
	var params = 'type='+Ext.get('type').dom.value+'&action='+Ext.get('action').dom.value+'&jobId='+Ext.get('jobId').dom.value;
	url = url + '?' +　params;
//	var proxy　=　new Ext.data.HttpProxy({url:url});
	var proxy　=　new Ext.data.ScriptTagProxy({url:url});
	//定义reader
	var reader=new Ext.data.JsonReader(
			{
				totalProperty: "totalCount",
				root: "users",
				id: "ushiId"
			},[
				 'ushiId',
				 'userId',
				 'userName', 
				 'jobId', 
				 'type',
				 'action',
				 'startTime',           
				 'endTime'           
			]
	);
	//构建Store   
	var store=new Ext.data.Store(    {
	  proxy:proxy,
	  reader:reader
   });
	//载入
	store.load();	
	//create the grid
	var grid = new Ext.grid.GridPanel({
	    store: store,
	    columns: [
	        {header: "ID", width: 100, dataIndex: 'ushiId', sortable: true},
	        {header: "Download User", width: 250, dataIndex: 'userName', sortable: true},
	        {header: "Date", width: 245, dataIndex: 'endTime', sortable: true}
	    ],
	    renderTo:'history-grid',
	        width:600,
	        height:200
	    });
});
 