<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Faucet extends Model{

	protected $table = 'faucets';

	protected $fillable = [
		'url',
		'info',
		'duration',
		'time_unit',
		'until',
		'isactive',
		'priority',
		'updated'
	];

	public $timestamps  = false;

	public static $time_unit_names	= [
    		'h'	=> 'hour',
    		'm'	=> 'minute',
    		's'	=> 'second'
    	];

	private static function applyTimeUnit( $faucet ){
	   	switch($faucet->time_unit){
    		case 'h': $faucet->duration = $faucet->duration / 3600; break;
    		case 'm': $faucet->duration = $faucet->duration / 60; break;
    	}

    	return $faucet;
	}
//______________________________________________________________________________

	public static function find( $id, $columns = array('*') ){
		$faucet	= parent::find( $id, $columns );
		return self::applyTimeUnit( $faucet );
	}
//______________________________________________________________________________

	public static function firstReady(){

		$faucet	= self::select()
			->where('isactive',true)
			->whereRaw('TIMESTAMPDIFF(SECOND,until,CURRENT_TIMESTAMP())>=0')
			->orderBy('priority', 'desc')
			->first();

		return self::applyTimeUnit( $faucet );
	}
//______________________________________________________________________________

	public static function updateUntil( $data ){

		$data_new	= [
			'until'		=> date( 'Y-m-d H:i:s', strtotime('+'.$data['cduration'].' '.self::$time_unit_names[$data['time_unit']] )),
			'priority'	=> $data['priority']
		];

		($data['cduration']==$data['oduration']) ? $data_new['updated'] = date('Y-m-d H:i:s'):NULL;

		$result	= self::where( 'id', $data['prev_faucet_id'] )->update( $data_new );
	}
//______________________________________________________________________________

	public static function countFaucets(){

    	return [
    		'n_all'	=> self::all()->count(),

    		'n_act'	=> self::select()
				->where('isactive',TRUE)
				->whereRaw('TIMESTAMPDIFF(SECOND,until,CURRENT_TIMESTAMP())>=0')
				->count()
    	];
	}
//______________________________________________________________________________

	public static function disableFaucet( $id ){
		$data_new	= [
			'isactive'	=> FALSE
		];

		$faucet	= self::where( 'id', $id )->update( $data_new );
	}
//______________________________________________________________________________

}//	Class end
