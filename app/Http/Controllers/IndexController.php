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

    public function getNextFaucet( NextFaucetRequest $request){

    	$data	= $request->all();

info("\nGet: ");
// info(print_r( $data, TRUE ));



// info("\ndummy: ");

//     	$data	= ['no'];

//     if(Request::ajax()) {

// info("\nAjax!!\n");

//       $data = Input::all();
// //       print_r($data);die;
//     }

// info(print_r( $request, TRUE ));
// info(print_r( $_POST, TRUE ));
// info(print_r( $_GET, TRUE ));

//     	return Response::json(['url'=>'http://bitcoinzebra.com/faucet']);
//     	return Response::json(['url'=>'5556']);

//     	return json_encode(['id'=>10,'url'=>'5556']);
    	return Response::json(['id'=>10,'url'=>'5556']);

    }

    public function postNextFaucet( NextFaucetRequest $request){

    	$data	= $request->all();


// info(print_r( $data, TRUE ));



info("\nPost: ");

//     	$data	= ['no'];

//     if(Request::ajax()) {

// info("\nAjax!!\n");

//       $data = Input::all();
// //       print_r($data);die;
//     }

// info(print_r( $request, TRUE ));
// info(print_r( $_POST, TRUE ));
// info(print_r( $_GET, TRUE ));

//     	return Response::json(['url'=>'http://bitcoinzebra.com/faucet']);
//     	return Response::json(['url'=>'5556']);

//     	return json_encode(['id'=>10,'url'=>'5556']);
    	return Response::json(['id'=>10,'url'=>'5556']);

    }
//-----------------------------------------------------------------------------1

    public function getDummyPage(){




    	return view( 'dummy' );
    }

}//	Class end