<?php namespace App\Http\Controllers;

use Session;
use App\Faucet;
use Response;
use App\Http\Requests\ActionFaucetRequest;
use App\Http\Requests\SaveFaucetRequest;
use App\Http\Requests\ResetAllRequest;
use DateTime;

class IndexController extends Controller{


	private static function getLastPayInfo( $faucet ){
		$updated_mk	= strtotime($faucet->updated);
		$dt_now		= new DateTime(date('Y-m-d'));
		$dt_payed	= new DateTime(date( 'Y-m-d', $updated_mk ));
		return date( 'd-m-Y', $updated_mk ).' ('.$dt_now->diff( $dt_payed )->days.')';
	}

    public function getIndex(){
    	(!Session::has('order')) ? Session::put( 'order', 'desc' ):NULL;
    	$faucet_id	= Session::pull( 'faucet_id', 0 );
    	$faucet		= Faucet::firstReady();
    	$curr_faucet= ((bool)$faucet_id) ? Faucet::find( $faucet_id ) : $faucet;

		if( $faucet->id != 0 || $curr_faucet->id != 0 )
			$faucet		= strtotime($curr_faucet->ban_until) > strtotime('now') ? $faucet : $curr_faucet;

		$count			= Faucet::countFaucets();

    	return view( 'index', [
    		'faucet'		=> $faucet,
    		'last_pay'		=> self::getLastPayInfo( $faucet ),
    		'n_all'			=> $count['n_all'],
    		'n_act'			=> $count['n_act'],
    		'btn_grp_css'	=> ($faucet->id != NULL ? 'btn4' : 'btn2'),
    		'order'			=> Session::get( 'order' )
    	]);
    }
//______________________________________________________________________________

    public function getDashboard( $id ){
    	Session::put( 'faucet_id', $id );
    	$faucet	= (bool)$id ? Faucet::find( $id ) : Faucet::getNullFoucet();

		$dt_now = new DateTime( date('Y-m-d') );
		$dt_ban = new DateTime( date('Y-m-d', strtotime($faucet->ban_until)) );
		$diff	= $dt_now->diff( $dt_ban, FALSE );
		$faucet->bandays	= $diff->invert ? 0 : $diff->d;

    	return view( 'dashboard',['faucet' => $faucet] );
    }
//______________________________________________________________________________

    public function postActionFaucet( ActionFaucetRequest $request ){

    	$data	= $request->all();

		switch( $data['action'] ){
			case 'next':
			case 'next_not':
				Faucet::updateUntil( $data );
				$faucet	= Faucet::firstReady();
				break;

			case 'tomorrow':

				Faucet::updateUntilTomorrow( $data );
				$faucet	= Faucet::firstReady();
				break;

			case 'save_duration':
				$result	= Faucet::where( 'id', $data['prev_faucet_id'] )->update( ['duration'=>$data['cduration'] * 60] );
				$faucet	= Faucet::find( $data['prev_faucet_id'] );
				$message	= 'New duration successfully saved.';
				break;

			case 'change_order':
				Session::put( 'order', $data['order'] );
				return Response::json([]);
		}

		$count	= Faucet::countFaucets();

		$ret_data	= [
    		'id'		=> $faucet->id,
    		'url'		=> $faucet->url,
    		'duration'	=> $faucet->duration,
    		'priority'	=> $faucet->priority,
    		'info'		=> $faucet->info,
    		'last_pay'	=> self::getLastPayInfo( $faucet ),
    		'n_all'	=> $count['n_all'],
    		'n_act'	=> $count['n_act']
		];

		isset($message) ? $ret_data['message'] = $message : NULL;

		return Response::json($ret_data);
    }
//______________________________________________________________________________

    public function getDummyPage(){
    	return view( 'dummy' );
    }
//______________________________________________________________________________

    private function prepareUrl( $data ){
    	$url			= $data['url'];
		$data['url']	= parse_url( $url, PHP_URL_SCHEME ).'://'.parse_url( $url, PHP_URL_HOST ).parse_url( $url, PHP_URL_PATH );
		$data['query']	= parse_url( $url, PHP_URL_QUERY );

    	return $data;
    }

    public function postSaveFaucet( SaveFaucetRequest $request ){
    	$data	= $request->all();

    	$id	= $data['id'];

    	$data['bandays'] > 0
    		? $data['ban_until'] = date('Y-m-d',strtotime('+'.$data['bandays'].' day')).' 00:00:00':NULL;

    	unset($data['id']);
    	unset($data['bandays']);

    	try{
	    	if( $id > 0 ){//	--- Update faucet.
	    		$data	= $this->prepareUrl( $data );
	    		$result	= Faucet::where( 'id', $id )->update( $data );
				return Response::json( ['error'=>FALSE, 'message'=>'Faucet successfully updated.', 'id' => $id] );
	    	}elseif($id < 0){//	--- Delete faucet.
	    		Session::forget('faucet_id');
	    		$id	= -$id;
				$result	= Faucet::where( 'id', $id )->delete();
				return Response::json( ['message'=>'Faucet successfully deleted.', 'id' => $id] );
	    	}else{//	--- Add faucet.
				$data	= $this->prepareUrl( $data );
				$id	= Faucet::insertGetId( $data );
				Session::put( 'faucet_id', $id );
				return Response::json( ['error'=>FALSE, 'message'=>'Faucet successfully added.', 'id' => $id] );
	    	}
    	}catch( \Illuminate\Database\QueryException $e){
    		return Response::json(['error'=>TRUE, 'message' => $e->errorInfo[2], 'id' => $id]);
    	}
    }
//______________________________________________________________________________

    public function postResetAll( ResetAllRequest $request ){
    	$data	= $request->all();
    	$result	= Faucet::where('until','>',date('Y-m-d H:i:s'))->update( ['until' => date('Y-m-d H:i:s')] );
    	return Response::json( ['message'=>'All faucets reset to current date!!!', 'id' => $data['id']] );
    }
//______________________________________________________________________________

}//	Class end