<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use Response;

class SaveFaucetRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize(){
		return TRUE;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules(){
		return [
			'url'		=> 'required',
			'duration'	=> 'required|numeric'
		];
	}

    // OPTIONAL OVERRIDE
    public function forbiddenResponse(){
        return Response::make('Permission denied !-!-!', 403);
    }

    // OPTIONAL OVERRIDE
    public function response( array $errors){
    	return parent::response($errors);
    }

}
