function Checkinfo()
{
	var isValid = true;
	if ($('#distCode').val() == "" )
	{
		alert(Lang_busDistEmpty);
		$('#distCode').focus();
		isValid = false;
		return;
	}
	
	if( !IsSelectOne() )
	{
		alert(Lang_busDayEmpty);
		isValid = false;
		return;
	}
	
	if (Trim($('#routeNo').val()) == "" )
	{
		alert(Lang_routeNoEmpty);
		$('#routeNo').focus();
		isValid = false;
		return;
	}	

	if ($('#typeId').val() == "" )
	{
		alert(Lang_busTypeEmpty);
		$('#typeId').focus();
		isValid = false;
		return;
	}	

	if (Trim($('#bounds').val()) == "" )
	{
		alert(Lang_busBoundsEmpty);
		$('#bounds').focus();
		isValid = false;
		return;
	}	
	
	if (Trim($('#busList').val()) == "" )
	{
		alert(Lang_busListEmpty);
		$('#busList').focus();
		isValid = false;
		return;
	}
	
	if(isValid)
	{
		$('#input').submit();
	}		

}

function IsSelectOne()
{
	var __isChecked = false;
	$('input[type="checkbox"]').each(function(){
		if($(this).is(":checked")==true){
			__isChecked = true;
			return false;
		}
	});
	return __isChecked;
}

function SelectAll()
{
	$('input[type="checkbox"]').each(function(){
		$(this).attr('checked','checked');
	});
}

function SelectNone()
{
	$('input[type="checkbox"]').each(function(){
		$(this).attr('checked',false);
	});
}

$(function() {
	$('a[rel*=leanModal]').leanModal({
		top : 200,
		closeButton : ".modal_close"
	});
	$('#btnExport').click(function(){
		var __busDistance = "";
		for(var __i=0;__i<50;__i++){
			if($('#stopNo_'+__i).val() != "" && $('#stopDescription_'+__i).val() != "" && $('#distance_'+__i).val() != ""){
				__busDistance += $('#stopNo_'+__i).val()+" "+$('#stopDescription_'+__i).val()+" "+$('#distance_'+__i).val()+"\r\n";
			}
		}
		$('#txtBusDistance').val(__busDistance);
		$('#btnSubmit').hide();
	});
	$('#btnImport').click(function(){
		$('#txtBusDistance').val("");
		$('#btnSubmit').show();
	});
	$('#btnSubmit').click(function(){
		var __busDistance = $('#txtBusDistance').val();
		if(__busDistance != ""){
			//clear old data
			for(var __i=0;__i<50;__i++){
				$('#stopNo_'+__i).val('');
				$('#stopDescription_'+__i).val('');
				$('#distance_'+__i).val('')
			}
			var __tmpRow = __busDistance.split("\n");
			for(var __i=0;__i<__tmpRow.length;__i++){
				if(__tmpRow[__i] != ''){
					var __tmpDistance = __tmpRow[__i].split(' ');
					$('#stopNo_'+__i).val(__tmpDistance[0]);
					$('#stopDescription_'+__i).val(__tmpDistance[1]);
					$('#distance_'+__i).val(__tmpDistance[2])
				}
			}
		}
		$('#signup').hide();
		$('#lean_overlay').hide();
	});
});