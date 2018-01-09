<?php

namespace App\Services;

use App\Services\BaseService;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Libraries\Common;

class UserService extends BaseService
{
    function __construct() {
        parent::__construct();
    }

    /**
     * Call service to get user by id
     * 
     * @param string
     * @param string
     * @return response
     */
    public function getUserById($user_id, $id) {
        $response = $this->client->request('GET', 'user/' . $id);
        
        return $response;
    }

    /**
     * Call service to create user
     * 
     * @param Illuminate\Http\Request;
     * @return response
     */
    public function createUser($request) {
        $response = $this->client->request('POST', 'user', [
            'body' => $request,
            'form_params' => [
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password'=> $request->input('password')
            ]
        ]);
        
        return $response;
    }

    // /**
    //  * Call service to validate log in
    //  * 
    //  * @param Illuminate\Http\Request;
    //  * @return response
    //  */
    // public static function login($request) {
    //     $response =  $this->client->request('POST', 'login', [
    //         'body' => $request
    //     ]);
        
    //     return $response;
    // }
}