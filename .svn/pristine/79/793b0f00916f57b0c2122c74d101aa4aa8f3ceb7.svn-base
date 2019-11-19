
Ext.onReady(function(){
    var win;
    var button = Ext.get('butAdd');
	var joinId = Ext.get('joinId').dom.value;
    button.on('click', function(){
        // create the window on the first click and reuse on subsequent clicks
        if(!win){
            win = new Ext.Window({
                width:500,
                height:300,
                closeAction:'hide',
                plain: true,
				maximizable: true,
				title: 'Traffic Flow Detail Entry',
                html: '<iframe src="./flow_data_detail_entry.php?joinId='+joinId+'" style="width:100%; height:100%; border:0px;"></iframe>'
            });
        }
        win.show(this);
    });
    
    if(joinId == "")
    	Ext.get('butAdd').dom.disabled = true;
	
//    Ext.MessageBox.alert('Warning', 'Only for test..... '); 
    //上傳Excel模板
    Ext.get('imgFlowChartTemplate').on('click',function(){
    	var form = new Ext.form.FormPanel({
	        baseCls: 'x-plain',
	        labelWidth: 80,
	        url:'flow_data_entry_upload_press.php',
			fileUpload:true,
	        defaultType: 'textfield',
	
	        items: [{
	        	xtype: 'hidden',
	            name: 'fileJoinId',
	            value: Ext.get('joinId').dom.value
	        },{
	        	xtype: 'hidden',
	            name: 'fileJobNo',
	            value: Ext.get('jobNo').dom.value
	        },{
	            xtype: 'textfield',
	            fieldLabel: 'File Name',
	            name: 'flowChartTemplate',
	            inputType: 'file',
	            allowBlank: false,
	            blankText: 'File can\'t not empty.',
	            cls: 'logintext',
	            anchor: '90%'  // anchor width by percentage
	        }]
	    });
    	
    	new Ext.Window({
    		id: 'uploadWin',
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
					           Ext.getCmp('uploadWin').hide();  
					           Ext.get('tdFlowChartTemplate').dom.innerHTML = action.result.flowChartTemplate;
					        },    
					       failure: function(){    
					          Ext.Msg.alert('Error', 'File upload failure.');    
					       }
				       	})		       
			   		}
	           }
	        },{
	            text: 'Close',
	            handler:function(){Ext.getCmp('uploadWin').hide();}
	        }]
    	}).show();
    });

});

function OpenWinUpdate(moveId)
{
	Ext.onReady(function(){
    var win;
	win = new Ext.Window({
	            width:500,
	            height:300,
	            closeAction:'hide',
	            plain: true,
				maximizable: true,
				title: 'Traffic Flow Detail Update',
	            html: '<iframe src="./flow_data_detail_entry.php?moveId='+moveId+'" style="width:100%; height:100%; border:0px;"></iframe>'
	        });
	win.show();

});
}