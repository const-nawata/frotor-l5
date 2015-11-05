var faucet_id=0
	,faucet_url	= ""
	,error_ico	= "<span class='glyphicon glyphicon-exclamation-sign' style='float:left; margin:0 15px 0 0;font-size:20px;'></span>"
;

/**
 * extends alert functionality. Also sets global is_submit to false.
 * @param string title
 * @param string message
 * @returns void
 */
function inform( title, message, focusId ){

	std_dlg
		.dialog( "option", "width", "400px" )
	    .dialog( "option", "title", title )
		.dialog( "option", "buttons",[
			{
				text: "Close",
				click: function(){
					$(this).dialog("close");

					if(typeof focusId != "undefined")
						$("#"+focusId).focus();
				}
			}
		])
		.html( message )
		.dialog("open");
}
//______________________________________________________________________________

/**
 * extends confirm functionality.
 * @param title
 * @param message
 * @param callback
 */
function affirm( title, message, callback ){
	std_dlg
		.dialog( "option", "width", "450px" )
	    .dialog( "option", "title", title )
		.dialog( "option", "buttons",[
			{
				text: "Yes",
				click: function(){
					$(this).dialog("close");

					if(typeof callback != "undefined")
						callback();
				}
			},

			{
				text: "No",
				click: function(){
					$(this).dialog("close");
				}
			}
		])
		.html( message )
		.dialog("open");
}
//______________________________________________________________________________

function loadFaucet(){
	$("#main_fraim").attr("src", faucet_url );
}
//______________________________________________________________________________

function postFaucet(fUrl,btnId){
	var action;

	switch( btnId ){
		case "next_btn":
			action	= "next";
			break;

		case "disable_btn":
			action	= "disable";
			break;
	}

	$.ajax({
		method:"POST",
		dataType: "JSON",
		url: fUrl,
		data:{
			"action":action
			,"prev_faucet_id":faucet_id
			,"cduratin":$("#cduraion").val()
			,"oduratin":$("#oduraion").val()
			,"priority":$("#priority").val()
		},

		success: function(faucet){

			if( action == "disable" )
				inform( "Operation result", "Faucet disabled." );

			faucet_id	= faucet.id;
			faucet_url	= faucet.url;

			$("#faucet_id").html(faucet_id);
			$("#cduraion").val(faucet.duration);
			$("#oduraion").val(faucet.duration);
			$("#priority").val(faucet.priority);
			$("#last_pay").html(faucet.last_pay);
			$("#info").html(faucet.info);
			$("#n_all").html(faucet.n_all);
			$("#n_act").html(faucet.n_act);

			loadFaucet();
    	},

    	error: function(jqXHR, textStatus, errorThrown){

    		var err = jqXHR.responseJSON;

    		for(var field_id in err ){
    			inform( "Error", error_ico+err[field_id][0] );
    			break;
    		}
		}
    });
}
//______________________________________________________________________________

function postDashboardData(fUrl){
	$.ajax({
		method:"POST",
		dataType: "JSON",
		url: fUrl,
		data:{
			"id":faucet_id,
			"url":$("#url").val(),
			"info":$("#info").val(),
			"duration":$("#duration").val(),
			"priority":$("#priority").val(),
			"referal":$("#referal").val()
		},

		success: function(data){
			if(faucet_id < 0){
				alert(data.message);
				window.location = "/";
			}

			faucet_id	= data.id;
			$("#faucet_id").html(faucet_id);
			inform( "Operation result", data.message, faucet_id );
    	},

    	error: function(jqXHR, textStatus, errorThrown){
    		var err = jqXHR.responseJSON;

    		for(var field_id in err ){
    			inform( "Error", error_ico+err[field_id][0], field_id );
    			break;
    		}
		}
    });
}
//------------------------------------------------------------------------------
