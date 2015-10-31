<?php namespace App\Http\Controllers;

use App\Faucet;
// use Input;
// use Request;
use Response;
use App\Http\Requests\ActionFaucetRequest;
use App\Http\Requests\SaveFaucetRequest;

class IndexController extends Controller{

    public function getIndex( $isDummy=TRUE ){

    	$faucet	= Faucet::firstReady();

    	$all	= Faucet::all()->count();
    	$active	= Faucet::where('isactive',TRUE)->count();

    	return view( 'index', ['faucet'=>$faucet, 'all'=>$all, 'active'=>$active] );
    }
//______________________________________________________________________________

    public function getDashboard( $id ){

		$faucet	= Faucet::find($id);


// 		$faucets_list	= [];
// 		$faucet_sel	= NULL;
// 		foreach( $faucets as $faucet ){
// 			$faucets_boxlist[$faucet->id]	= '['.$faucet->id.'] '.$faucet->name;
// 			$faucet_sel	= $faucet->id == $id ? $faucet : $faucet_sel;



// 			if( $faucet->id == $id ){
// 				$name = $faucet->name;

// 			}
// 		}

    	return view( 'dashboard',[
    		'faucet'		=> $faucet,

    	] );
    }
//______________________________________________________________________________

    public function postActionFaucet( ActionFaucetRequest $request ){

    	$data	= $request->all();

		switch( $data['action'] ){
			case 'next':
				Faucet::updateUntil( $data['prev_faucet_id'], $data['cduratin'], $data['priority'], ($data['cduratin']==$data['oduratin']) );
				break;

			case 'disable':
				Faucet::disableFaucet( $data['prev_faucet_id'] );
				break;
		}

		$faucet	= Faucet::firstReady();

    	return Response::json([
    		'id'		=> $faucet->id,
    		'url'		=> $faucet->url,
    		'duration'	=> $faucet->duration,
    		'priority'	=> $faucet->priority
    	]);
    }
//______________________________________________________________________________

    public function getDummyPage(){
    	return view( 'dummy' );
    }
//______________________________________________________________________________

    public function postSaveFaucet( SaveFaucetRequest $request ){
    	$data	= $request->all();


info(print_r(  $data ,true));

    	return Response::json([]);
    }
//______________________________________________________________________________

}//	Class end