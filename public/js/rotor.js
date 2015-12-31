var faucet_id=0
	,faucet_url	= ""
	,error_ico	= "<span class='glyphicon glyphicon-exclamation-sign error-ico'></span>"
;

/**
 * extends alert functionality. Also sets global is_submit to false.
 * @param string title
 * @param string message
 * @returns void
 */
function inform( title, message, focusId, callback ){

	std_dlg
		.dialog( "option", "width", "450px" )
	    .dialog( "option", "title", title )
		.dialog( "option", "buttons",[
			{
				text: "Close",
				click: function(){
					$(this).dialog("close");
					(typeof focusId != "undefined" && focusId != null) ? $("#"+focusId).focus() : null;
					(typeof callback != "undefined") ? callback() : null;
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
					(typeof callback != "undefined" ) ? callback() : null;
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

function setFaucetInfo(faucet){

	faucet_id	= faucet.id;
	faucet_url	= faucet.url;

	$("#faucet_id").html(faucet_id);
	$("#cduration").val(faucet.duration);
	$("#cduration").attr("value",faucet.duration);
	$("#oduration").val(faucet.duration);
	$("#time_unit").val(faucet.time_unit);
	$("#time_unit_name").html(faucet.time_unit_name);
	$("#priority").val(faucet.priority);
	$("#last_pay").html(faucet.last_pay);
	$("#info").html(faucet.info);
	$("#n_all").html(faucet.n_all);
	$("#n_act").html(faucet.n_act);

}
//______________________________________________________________________________

function loadFaucet(){
	$("#main_fraim").attr("src", faucet_url );

	$("#load_btn")
		.removeClass("glyphicon-play")
		.addClass("glyphicon-repeat")
		.attr("title","Refresh");
}
//______________________________________________________________________________

function postFaucet(fUrl,btnId){//	Index page
	var action;

	switch( btnId ){
		case "next_btn":			action = "next"; break;
		case "disable_btn":			action = "disable"; break;
		case "save_duration_btn":	action = "save_duration"; break;
		case "change_order_btn":	action = "change_order"; break;
	}

	$.ajax({
		method:"POST",
		dataType: "JSON",
		url: fUrl,
		data:{
			"action":			action
			,"prev_faucet_id":	faucet_id
			,"cduration":		$("#cduration").val()
			,"oduration":		$("#oduration").val()
			,"time_unit":		$("#time_unit").val()
			,"priority":		$("#priority").val()
			,"order":			$("#order").val()
		},

		success: function(faucet){
			var field = "";

			switch(action){
				case 'save_duration':
					field	= "cduration";
					setFaucetInfo(faucet);
					break;

				case 'next':
				case 'disable':
					setFaucetInfo(faucet);
					loadFaucet();
					break;
			}

			if( typeof faucet.message !== "undefined" && faucet.message != "" )
				inform( "Operation result", faucet.message, field );


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
			"id":		faucet_id,
			"url":		$("#url").val(),
			"duration":	$("#duration").val()*60,
			"info":		$("#info").val(),
			"priority":	$("#priority").val()
		},

		success: function(data){

			if(data.error){
				inform( "Error", error_ico+data.message );
				faucet_id	= data.id;
				return;
			}

			if(faucet_id < 0){
				faucet_id	= - faucet_id;
				window.location = "/";
				return;
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
//______________________________________________________________________________
