<?php namespace App\Http\Controllers;


class IndexController extends Controller{
// class IndexController extends Controller{

    public function getIndex(){

    	return view( 'index', ['url'=>'dashboard'] );
    }
//______________________________________________________________________________


    public function getDashboard(){



    	return view( 'dashboard' );
    }
//______________________________________________________________________________

    public function getIfraimContent(){


    	return redirect('http://www.google.com');

    }

}//	Class end