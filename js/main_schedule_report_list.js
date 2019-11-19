/*
 * Header: 
 * Create: 2008-05-31
 * Auther: Jamblues@gmail.com.
 */
 Ext.QuickTips.init();
 Ext.form.Field.prototype.msgTarget = 'side'; 
 function OpenUpload(refNo,fileType)
 {
 	Ext.onReady(function() {
	    var form = new Ext.form.FormPanel({
	        baseCls: 'x-plain',
	        labelWidth: 80,
	        url:'main_schedule_report_upload_press.php',
			fileUpload:true,
	        defaultType: 'textfield',
	
	        items: [{
	        	xtype: 'hidden',
	            name: 'refNo',
	            value: refNo
	        },{
	        	xtype: 'hidden',
	            name: 'fileType',
	            value: fileType
	        },{
	            xtype: 'textfield',
	            fieldLabel: 'File Name',
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
	        width: 400,
	        height:200,
	        minWidth: 300,
	        minHeight: 100,
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
							   width:300,
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
	});;
 }