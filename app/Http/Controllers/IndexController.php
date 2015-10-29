<?php namespace App\Http\Controllers;

use App\Faucet;
use Input;
use Request;
use Response;
use App\Http\Requests\NextFaucetRequest;

class IndexController extends Controller{

    public function getIndex( $isDummy=TRUE ){

    	$faucet	= Faucet::firstReady();

    	$all	= Faucet::all()->count();
    	$active	= Faucet::where('isactive',TRUE)->count();

    	return view( 'index', ['faucet'=>$faucet, 'all'=>$all, 'active'=>$active] );
    }
//______________________________________________________________________________


    public function getDashboard(){



    	return view( 'dashboard' );
    }
//______________________________________________________________________________

    public function postNextFaucet( NextFaucetRequest $request){

    	$data	= $request->all();


// info(print_r( $data, 1 ));


		$faucet	= Faucet::firstReady();

    	return Response::json([
    		'id'		=> $faucet->id,
    		'url'		=> $faucet->url,
    		'duration'	=> $faucet->duration,
    		'priority'	=> $faucet->priority

    	]);
    }
//-----------------------------------------------------------------------------1

    public function getDummyPage(){




    	return view( 'dummy' );
    }

}//	Class end