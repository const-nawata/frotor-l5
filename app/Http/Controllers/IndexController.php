<?php namespace App\Http\Controllers;

use App\Faucet;
use Response;
use App\Http\Requests\ActionFaucetRequest;
use App\Http\Requests\SaveFaucetRequest;

class IndexController extends Controller{

    public function getIndex( $isDummy=TRUE ){

    	$faucet	= Faucet::firstReady();
    	$count	= Faucet::countFaucets();

    	return view( 'index', ['faucet'=>$faucet, 'n_all'=>$count['n_all'], 'n_act'=>$count['n_act']] );
    }
//______________________________________________________________________________

    public function getDashboard( $id ){

		$faucet	= Faucet::find($id);

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

    	try{
	    	if( $id > 0 ){
	    		$result	= Faucet::where( 'id', $id )->update( $data );
				return Response::json( ['message'=>'Successfully saved.', 'id' => $id] );
	    	}elseif($id < 0){//	Delete faucet!!!
	    		$id	= -$id;
				$result	= Faucet::where( 'id', $id )->delete();
				return Response::json( ['message'=>'Successfully deleted.', 'id' => $id] );
	    	}else{
				$data['isactive']	= TRUE;
				$id	= Faucet::insertGetId($data);
				return Response::json( ['message'=>'Successfully created.', 'id' => $id] );
	    	}
    	}catch( \Exception $e){
    		return Response::json(['message'=>$e->getMessage()]);
    	}
    }
//______________________________________________________________________________

}//	Class end