<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Faucet extends Model{

	protected $table = 'faucets';

	protected $fillable = [
		'duration',
		'priority'
	];

	public static function firstReady(){

		$row	= self::select()
			->where('isactive',true)
			->whereRaw('TIMESTAMPDIFF(SECOND,until,CURRENT_TIMESTAMP())>=0')
			->orderBy('priority', 'desc')
			->first();

		return $row;
	}
//______________________________________________________________________________

}//	Class end
