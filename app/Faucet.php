<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Session;

class Faucet extends Model{

	protected $table = 'faucets';

	protected $fillable = [
// 		'url',
		'domain',
		'path',
		'info',
		'duration',
		'time_unit',
		'until',
		'isactive',
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
// 	   	switch($faucet->time_unit){
//     		case 'h': $faucet->duration = $faucet->duration / 3600; break;
//     		case 'm': $faucet->duration = $faucet->duration / 60; break;
//     	}

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
			->where('isactive',TRUE)
			->whereRaw('TIMESTAMPDIFF(SECOND,until,CURRENT_TIMESTAMP())>=0 AND TIMESTAMPDIFF(SECOND,ban_until,CURRENT_TIMESTAMP())>=0');
	}

	public static function firstReady(){

		$faucet	= self::getActiveFaucetsObj()
			->orderBy('priority', Session::get( 'order' ))
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

		($data['cduration']==$data['oduration']) ? $data_new['updated'] = date('Y-m-d H:i:s'):NULL;

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

	public static function disableFaucet( $data ){

		$data_new	= [
			'isactive'	=> FALSE,
			'priority'	=> $data['priority']
		];

		$faucet	= self::where( 'id', $data['prev_faucet_id'] )->update( $data_new );
	}
//______________________________________________________________________________

}//	Class end
