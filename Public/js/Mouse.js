var objState;
function OnFoucsMouseOver( obj,fontColor,backColor )
{
 if ( obj.rowIndex > 0 )
 {
  obj.style.color = fontColor;
  obj.style.backgroundColor = backColor;
 }
}
function OnFoucsMouseOut( obj,fontColor,backColor )
{
 if ( obj.rowIndex > 0 )
 {
  if ( obj != objState )
  {
   obj.style.color = fontColor;
   obj.style.backgroundColor = backColor;
  }
 }
}

//全选按钮
function seleAll(dataGrid1,ckbSelect)
{
  var rowCount=dataGrid1.rows.length;

  if(rowCount>1)
  {
	for(var i=1;i<rowCount;i++)
	{

		dataGrid1.rows.item(i).cells.item(0).childNodes.item(0).checked=ckbSelect.checked;
	}
  }

  if (ckbSelect.checked) {
	    ckbSelect.checked = false; 
  } else {
		ckbSelect.checked = true; 
 }
} 

//全选按钮,有foot
function seleFootAll(dataGrid1,ckbSelect)
{
  var rowCount=dataGrid1.rows.length; 
  if(rowCount>1)
  {
	for(var i=1;i<rowCount-1;i++)
	{ 
		dataGrid1.rows.item(i).cells.item(0).childNodes.item(0).checked=ckbSelect.checked;
	}
  } 
  if (ckbSelect.checked) {
	    ckbSelect.checked = false; 
  } else {
		ckbSelect.checked = true; 
 }
} 

function loads()
{
	document.getElementById("Content").style.height=window.screen.height-290;
} 