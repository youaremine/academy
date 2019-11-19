/*
 * Ext JS Library 2.0.2
 * Copyright(c) 2006-2008, Ext JS, LLC.
 * licensing@extjs.com
 * 
 * http://extjs.com/license
 */

Ext.BLANK_IMAGE_URL = 'images/s.gif';

Ext.onReady(function(){
//	var url = 'user_history_list_json.php?' + Math.random();
	var url = 'user_history_list_json.php';
	var proxy=new Ext.data.HttpProxy({url:url});
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
	var store=new Ext.data.Store(    {
	  proxy:proxy,
	  reader:reader
   });

    var form = new Ext.FormPanel({
        baseCls: 'x-plain',
        defaults: {width: 150},
        defaultType: 'textfield',
        items: [{
                fieldLabel: '帳戶',
                id:'username',
                name: 'username'
            }]
    });
    
    // create the Grid
    var grid = new Ext.grid.GridPanel({
        store: store,
        stripeRows: true,
        border:false,
        buttonAlign :'left',
        region:'center',
        title:'帳戶歷史',
		columns: [
            {header: "ushiId",id:'ushiId', width: 20, sortable: true, dataIndex: 'ushiId'},
            {header: "userId", width: 40, sortable: true, renderer: 'userId', dataIndex: 'userId'},
            {header: "userName", width: 110, sortable: true, renderer: 'userName', dataIndex: 'userName'},
            {header: "jobId", width: 40, sortable: true, renderer: 'jobId', dataIndex: 'jobId'},
            {header: "type", width: 135, sortable: true, renderer: 'type', dataIndex: 'type'},
            {header: "action", width: 75, sortable: true, renderer: 'action', dataIndex: 'action'},
            {header: "startTime", width: 100, sortable: true, renderer: 'startTime', dataIndex: 'startTime'},
            {header: "endTime", width: 100, sortable: true, renderer: 'endTime', dataIndex: 'endTime'}
        ],
        tbar: [
               form,//搜索表单
               {
					text: '搜索',
					  handler:function(){
					     store.load({
					             params:{start:0, limit:20,
					                 username:Ext.get('username').dom.value
					             }
					         })
					  }
               }
        ],
		bbar: new Ext.PagingToolbar({
			pageSize: 20,
            store: store,
            displayInfo: true,
            displayMsg: 'Displaying topics {0} - {1} of {2}',
            emptyMsg: "No topics to display"
		})
		
    });

    store.on('beforeload',function(){
      Ext.apply(
      this.baseParams,
      {
           username:Ext.get('username').dom.value
      });
    });
    
    var viewport = new Ext.Viewport({
        layout:'border',
        items:[grid]
        });

    
//    grid.render('grid-user-history');

//    grid.getSelectionModel().selectFirstRow();
});