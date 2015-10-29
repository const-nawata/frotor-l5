<?php
/**
 * Main Footer layout
 */
?>

</body>

<script type="text/javascript">
$(document).ready(function(){
	$.ajaxSetup({
		   headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
		});
});
</script>
@yield('js_extra')
</html>