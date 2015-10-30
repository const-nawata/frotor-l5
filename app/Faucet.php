<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Faucet extends Model{

	protected $table = 'faucets';

	protected $fillable = [
		'duration',
		'priority',
		'updated'
	];

	public $timestamps  = false;

	public static function firstReady(){

		$row	= self::select()
			->where('isactive',true)
			->whereRaw('TIMESTAMPDIFF(SECOND,until,CURRENT_TIMESTAMP())>=0')
			->orderBy('priority', 'desc')
			->first();

		$row->url	= $row->url.($row->referal!=''?'?r='.$row->referal:'');

		return $row;
	}
//______________________________________________________________________________

	public static function updateUntil( $id, $duration, $priority, $isUpdated=TRUE ){
		$data_new	= [
			'until'	=> date('Y-m-d H:i:s', strtotime('+'.$duration.' second')),
			'priority'	=> $priority
		];

		$isUpdated ? $data_new['updated'] = date('Y-m-d H:i:s'):NULL;

		$faucet	= self::where( 'id', $id )->update( $data_new );

	}
//______________________________________________________________________________

	public static function disableFaucet( $id ){
		$data_new	= [
			'isactive'	=> FALSE
		];

		$faucet	= self::where( 'id', $id )->update( $data_new );
	}
}//	Class end
