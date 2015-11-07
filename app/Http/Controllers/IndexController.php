<?php namespace App\Http\Controllers;


use Session;
use App\Faucet;
use Response;
use App\Http\Requests\ActionFaucetRequest;
use App\Http\Requests\SaveFaucetRequest;
use App\Http\Requests\EnableAllRequest;

class IndexController extends Controller{

	public static $time_units	= [
    		'h'	=> 'hour',
    		'm'	=> 'min',
    		's'	=> 'sec'
    	];

    public function getIndex( $isDummy=TRUE ){
    	$faucet_id	= Session::pull( 'faucet_id', 0 );
    	$faucet		= (bool)$faucet_id ? Faucet::find( $faucet_id ) : Faucet::firstReady();
    	$count		= Faucet::countFaucets();
    	return view( 'index', ['faucet'=>$faucet, 'n_all'=>$count['n_all'], 'n_act'=>$count['n_act'], 'time_units' => self::$time_units] );
    }
//______________________________________________________________________________

    public function getDashboard( $id ){
    	Session::put( 'faucet_id', $id );
    	$faucet	= Faucet::find( $id );
    	return view( 'dashboard',['faucet' => $faucet, 'time_units' => self::$time_units] );
    }
//______________________________________________________________________________

    public function postActionFaucet( ActionFaucetRequest $request ){
    	$data	= $request->all();

		switch( $data['action'] ){
			case 'next':	Faucet::updateUntil( $data ); break;
			case 'disable':	Faucet::disableFaucet( $data['prev_faucet_id'] ); break;
		}

		$faucet	= Faucet::firstReady();
		$count	= Faucet::countFaucets();

    	return Response::json([
    		'id'		=> $faucet->id,
    		'url'		=> $faucet->url,
    		'duration'	=> $faucet->duration,
    		'priority'	=> $faucet->priority,
    		'info'		=> $faucet->info,
    		'last_pay'	=> date('d-m-Y', strtotime($faucet->until)),
    		'n_all'	=> $count['n_all'],
    		'n_act'	=> $count['n_act']
    	]);
    }
//______________________________________________________________________________

    public function getDummyPage(){
    	return view( 'dummy' );
    }
//______________________________________________________________________________

    public function postSaveFaucet( SaveFaucetRequest $request ){
    	$data	= $request->all();

    	$id	= $data['id'];
    	unset($data['id']);

    	switch($data['time_unit']){
    		case 'h': $data['duration'] = $data['duration'] * 3600; break;
    		case 'm': $data['duration'] = $data['duration'] * 60; break;
    	}

    	try{
	    	if( $id > 0 ){
	    		$result	= Faucet::where( 'id', $id )->update( $data );
				return Response::json( ['message'=>'Faucet successfully saved.', 'id' => $id] );
	    	}elseif($id < 0){//	Delete faucet!!!
	    		Session::forget('faucet_id');
	    		$id	= -$id;
				$result	= Faucet::where( 'id', $id )->delete();
				return Response::json( ['message'=>'Faucet successfully deleted.', 'id' => $id] );
	    	}else{
				$data['isactive']	= TRUE;
				$id	= Faucet::insertGetId( $data );
				return Response::json( ['message'=>'Faucet successfully created.', 'id' => $id] );
	    	}
    	}catch( \Exception $e){
    		return Response::json(['message'=>$e->getMessage()]);
    	}
    }
//______________________________________________________________________________

    public function postEnableAll( EnableAllRequest $request ){
    	$data	= $request->all();
    	$result	= Faucet::where('isactive',FALSE)->update( ['isactive' => TRUE] );
		return Response::json( ['message'=>'All faucets enabled!!!', 'id' => $data['id']] );
    }
//______________________________________________________________________________

}//	Class end