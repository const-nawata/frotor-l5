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

}//	Class end