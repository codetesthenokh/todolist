<?php

namespace App\Services;

use App\Services\BaseService;
use Illuminate\Http\Request;
use Carbon\Carbon;
use GuzzleHttp\Client;

class ToDoListService extends BaseService
{
    function __construct() {
        parent::__construct();
    }

    /**
     * Call service to get to do list by user ID
     * 
     * @param string
     * @return response
     */
    public function getToDoLists($user_id) {
        $response = $this->client->request('GET', 'todolistByUserId/' . $user_id);
        
        return $response;
    }

    /**
     * Call service to get to do list by user ID and the ID
     * 
     * @param string
     * @param string
     * @return response
     */
    public function getToDoListById($user_id, $id) {
        $response = $this->client->request('GET', 'todolist/' . $user_id . '/' . $id);
        
        return $response;
    }

    /**
     * Call service to create to do list
     * 
     * @param Illuminate\Http\Request
     * @param string
     * @return response
     */
    public function createToDoList($request, $user_id) {
        $due_date = $request->input('due_date') != null ?
                    $request->input('due_date') . ' ' . $request->input('due_time') : null;
        $response = $this->client->request('POST', 'todolist', [
            'body' => $request,
            'form_params' => [
                'title' => $request->input('title'),
                'due_date' => $due_date,
                'description'=> $request->input('description'),
                'priority'=> $request->input('priority'),
                'is_completed'=> 0,
                'user_id'=> $user_id
            ]
        ]);
        
        return $response;
    }

    /**
     * Call service to mark to do list as complete
     * 
     * @param string
     * @return response
     */
    public function setToDoListComplete($id) {
        $response = $this->client->put('todolistcomplete/' . $id, []);
        
        return $response;
    }

    // /**
    //  * Call service to edit to do list
    //  * 
    //  * @param Illuminate\Http\Request
    //  * @param string
    //  * @return response
    //  */
    // public static function editToDoList($request, $id) {
    //     $response =  $this->client->put('todolist/' . $id, [
    //         'body' => $request
    //     ]);
        
    //     return $response;
    // }
}