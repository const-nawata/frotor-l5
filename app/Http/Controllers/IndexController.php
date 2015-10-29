<?php namespace App\Http\Controllers;

use App\Faucet;

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

    public function getNextFaucet(){


// info("Point 1");

//     	return Response::json(['url'=>'http://bitcoinzebra.com/faucet']);
//     	return Response::json(['url'=>'5556']);

    	return json_encode(['id'=>10,'url'=>'5556']);

    }

    public function getDummyPage(){




    	return view( 'dummy' );
    }

}//	Class end