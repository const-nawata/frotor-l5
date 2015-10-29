/**
 *
 */

var faucet_id=0
	,faucet_url=""
;
//$.ajaxSetup({
//	   headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
//	});

function getNextFaucet(fUrl){

	$.ajax({
		method:"POST",
		dataType: "JSON",
		url: fUrl,
		data:{
			"prev_faucet_id":faucet_id
			,"cduratin":$("#cduraion").val()
			,"oduratin":$("#oduraion").val()
			,"priority":$("#priority").val()
		},

		success: function(faucet){

			faucet_id	= faucet.id;
			faucet_url	= faucet.url;

//alert("Success!!! "+faucet_id);

			$("#id_faucet").html(faucet_id);
			$("#cduraion").val(faucet.duration);
			$("#oduraion").val(faucet.duration);
			$("#priority").val(faucet.priority);
			$("#last_payment").html(faucet.last_payment);

			loadFaucet();
    	},

    	error: function(){
			alert("Internal Error while go to next faucet.");
		}
    });

}

function loadFaucet(){
	$("#main_fraim").attr("src", faucet_url );
}