<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Session;

class Faucet extends Model{

	protected $table = 'faucets';

	protected $fillable = [
		'domain',
		'path',
		'info',
		'duration',
		'time_unit',
		'until',
		'priority',
		'updated',
		'ban_until'
	];

	public $timestamps  = FALSE;

	public static $time_unit_names	= [
    		'h'	=> 'hour',
    		'm'	=> 'minute',
    		's'	=> 'second'
    	];

	private static function applyTimeUnit( $faucet ){
    	$faucet->duration = $faucet->duration / 60;
    	return $faucet;
	}
//______________________________________________________________________________

	public static function find( $id, $columns = ['*'] ){
		$faucet		= parent::find( $id, $columns );
		$faucet->url= $faucet->url.($faucet->query != '' ? '?'.$faucet->query : '');
		return self::applyTimeUnit( $faucet );
	}
//______________________________________________________________________________


	public static function getNullFoucet(){
			$faucet	= new Faucet([]);
			$faucet->id			= 0;

			$faucet->url		=
			$faucet->info		=
			$faucet->updated	= NULL;

			$faucet->priority	= 1;
			$faucet->time_unit	= 'm';
			$faucet->duration	= 0;

			return $faucet;
	}

	private static function getActiveFaucetsObj(){
		return self::select()
			->whereRaw('TIMESTAMPDIFF(SECOND,until,CURRENT_TIMESTAMP())>=0 AND TIMESTAMPDIFF(SECOND,ban_until,CURRENT_TIMESTAMP())>=0');
	}

	public static function firstReady(){

		$faucet	= self::getActiveFaucetsObj()
			->orderBy('priority', Session::get( 'order' ))
			->orderByRaw( 'RAND()' )
// 			->inRandomOrder()					//TODO: For the Laravel version >= 5.2
			->first();

		if( $faucet == NULL ){
			$faucet		= self::getNullFoucet();
			$faucet->url= 'showdummy';
		}else{
			$faucet->url= $faucet->url.'?'.$faucet->query;
		}

		$faucet	= self::applyTimeUnit( $faucet );

		return $faucet;
	}
//______________________________________________________________________________

	public static function updateUntil( $data ){

		$data_new	= [
			'until'		=> date( 'Y-m-d H:i:s', strtotime('+'.$data['cduration'].' minute' )),
			'priority'	=> $data['priority']
		];

		($data['action']!='next_not') ? $data_new['updated'] = date('Y-m-d H:i:s'):NULL;

		$result	= self::where( 'id', $data['prev_faucet_id'] )->update( $data_new );
	}
//______________________________________________________________________________

	public static function countFaucets(){

    	return [
    		'n_all'	=> self::all()->count(),
    		'n_act'	=> self::getActiveFaucetsObj()->count()
    	];
	}
//______________________________________________________________________________

	public static function updateUntilTomorrow( $data ){

		$data_new	= [
			'until'		=> date( 'Y-m-d 00:00:01', strtotime('+1 day' )),
			'priority'	=> $data['priority']
		];

		$faucet	= self::where( 'id', $data['prev_faucet_id'] )->update( $data_new );
	}
//______________________________________________________________________________

}//	Class end
