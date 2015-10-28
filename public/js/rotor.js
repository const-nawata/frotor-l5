/**
 * 
 */

var faucet_id=0
	,faucet_url=""
;

function getNextFaucet(){

	$.ajax({
		method:"post",
		dataType: "json",
		url: "/nextfaucet/",
		data:{
			"dummy":null
			,"prev_faucet_id":faucet_id
//			,"cduratin":$("#cduraion").val()
//			,"oduratin":$("#oduraion").val()
//			,"priority":$("#priority").val()
		},

		success: function(faucet){

			faucet_id	= faucet.id;
			faucet_url	= faucet.url;

//alert(faucet_url);
			
			
//			$("#id_td").html("id:&nbsp;"+faucet_id);
//			$("#main_fraim").attr("src", faucet_url);
//			$("#cduraion").val(faucet.duration);
//			$("#oduraion").val(faucet.duration);
//			$("#priority").val(faucet.priority);
//			$("#last_payment").html(faucet.last_payment);
//			
//			showInfo();
    	},

    	error: function(){
			alert("Internal Error while go to next faucet.");
		}
    });}