/*
 * Header: 
 * Create: 2008-05-31
 * Auther: Jamblues@gmail.com.
 */
 Ext.QuickTips.init();
 Ext.form.Field.prototype.msgTarget = 'side';
 
 /*
 Ext.onReady(function(){
	  var mdStart = new Ext.form.DateField({
	  applyTo : 'txtSurveyDateStart',
	  format: 'Y-m-d',
	  emptyText: '��ѡ������ ...' 
	 });
	  
	  var mdEnd = new Ext.form.DateField({
	  applyTo : 'txtSurveyDateEnd',
	  format: 'Y-m-d',
	  emptyText: '��ѡ������ ...' 
	 });
	  
});
*/
 
 function ShowDownloadDialog(supaId)
 {
 	Ext.onReady(function() {
	    		
	var url = 'user_history_list_json.php?type=Monitoring Survey&action=Input Download&order=ORDER BY ushiId DESC&jobId='+supaId;
//	document.write(url);
	var proxy=new Ext.data.HttpProxy({url:url});
	//reader
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
	)
	//Store   
	var store=new Ext.data.Store(    {
	  proxy:proxy,
	  reader:reader
	});
		
	// create the Grid
    var grid = new Ext.grid.GridPanel({
        store: store,
        stripeRows: true,
        border:false,
        buttonAlign :'left',
        region:'center',
		columns: [
            {header: "userId", width: 40, sortable: true, renderer: 'userId', dataIndex: 'userId'},
            {header: "userName", width: 110, sortable: true, renderer: 'userName', dataIndex: 'userName'},
            {header: "action", width: 80, sortable: true, renderer: 'action', dataIndex: 'action'},
            {header: "startTime", width: 110, sortable: true, renderer: 'startTime', dataIndex: 'startTime'}
        ]
		
    });
    
    store.load();
	
	    var win = new Ext.Window({
	        title: 'History',
	        width: 360,
	        height:200,
	        minWidth: 300,
	        minHeight: 100,
	        layout: 'fit',
	        plain:true,
	        buttonAlign:'center',
	        items: grid,
	        modal: true,
	        autoDestroy: true,
	
	        buttons: [
	        	{text: 'Download',handler:function(){win.hide();window.location = 'data_to_excel.php?supaId='+supaId;}},
	        	{text: 'Close',handler:function(){win.hide();}}
	        ]
	    });
	    var cx = Ext.EventObject.getPageX()-360;
	    var cy = Ext.EventObject.getPageY()-200;
	    win.setPosition(cx,cy);
	 	win.show();
	});
 }