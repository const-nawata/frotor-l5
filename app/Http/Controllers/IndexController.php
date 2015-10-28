<?php namespace App\Http\Controllers;


class IndexController extends Controller{
// class IndexController extends Controller{

    public function getIndex(){

    	return view( 'index' );
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

}//	Class end