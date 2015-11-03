<?php
/**
 * Main Footer layout
 */
?>
<div id="standard-dialog"></div>
</body>

<script type="text/javascript">
var std_dlg;

$(document).ready(function(){
	$.ajaxSetup({
		   headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
	});


	std_dlg	= $("#standard-dialog").dialog({
		autoOpen: false,
		dialogClass: "dialog-standard",
		modal: true
	});

});
</script>
@yield('js_extra')
</html>