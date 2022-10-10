function open_addcomment(idnum)
{
	window.open("./modules/entries/addcomment.php?messagenum="+idnum,"addcomment_window","toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width=400, height=400")
}
function close_addcomment()
{
	window.opener.location.reload(true)
	window.close()
}
function setExternalLinks()
{
	if ( !document.getElementsByTagName )
	{
		return null;
	}
	var anchors = document.getElementsByTagName( "a" );
	for ( var i = 0; i < anchors.length; i++ )
	{
		var anchor = anchors[i];
		if ( anchor.getAttribute( "href" ) && anchor.getAttribute( "rel" ) == "external" )
		{
			anchor.setAttribute( "target", "_blank" ); 
		} 
	}
}

window.onload = setExternalLinks;