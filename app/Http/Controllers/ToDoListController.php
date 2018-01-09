<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Services\ToDoListService;
use App\Libraries\Common;
use Illuminate\Support\Facades\Session;

class ToDoListController extends Controller
{
    public function __construct() {
        $this->priority_list = Common::getPriorityList();
        $this->toDoListService = new ToDoListService();
    }

    /**
     * Show to do list for user login
     * @return view
    */
    public function index() {
        $data = [];
        $res = $this->toDoListService->getTodoLists(Session::get('user_id'));
        $data["todolist"] = json_decode($res->getBody()->getContents());
        $data["priority_list"] = $this->priority_list;

        return view('to_do_list/list', $data);
    }

    /**
     * Mark to do list to complete
     * @access public
     * @param string
     * @return view
     */
    public function setToDoListComplete($id) {
        try {
            $res = $this->toDoListService->setToDoListComplete($id);
            return redirect('/');
        } catch(\Exception $e) {
            Common::showMessage($request, 'Something goes wrong!', true);
        }   
    }

    /**
     * Add new to do list
     * @access public
     * @param Illuminate\Http\Request
     * @return view
     */
    public function addToDoList(Request $request) {
        $data = [];
        $data['modify'] = 0;
        $data['title'] = $request->input('title');
        $data['due_date'] = $request->input('due_date');
        $data['due_time'] = $request->input('due_time');
        $data['description'] = $request->input('description');
        $data['priority'] = $request->input('priority');
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'title'=>'required'
            ]);
            
            try {
                $res = $this->toDoListService->createToDoList($request, Session::get('user_id'));
                Common::showMessage($request, 'To Do List was successfully added!');
                return redirect('/');
            } catch(\Exception $e) {
                Common::showMessage($request, 'Something goes wrong!', true);
            }            
        }
        
        return view('to_do_list/form', $data);
    }

    /**
     * Show details page before edit
     * @access public
     * @param Illuminate\Http\Request
     * @param string
     * @return view
     */
    public function editToDoList(Request $request, $id) {
        $data = [];
        $data['modify'] = 1;
        $data['id'] = $id;
        $res = $this->toDoListService->getToDoListById(Session::get('user_id'), $id);
        $todolist = json_decode($res->getBody()->getContents());
        if ($todolist != null) {
            $data['title'] = $todolist->title;
            $data['description'] = $todolist->description;
            $data['priority'] = $todolist->priority;
            $data['due_date'] = (Carbon::parse($todolist->due_date))->toDateString();
            $data['due_time'] = (Carbon::parse($todolist->due_date))->format('h:i');
        } else {
            return redirect('errors/404');
        }

        return view('to_do_list/form', $data);
    }

    /**
     * Save edited to do list item
     * @access public
     * @param Illuminate\Http\Request
     * @param string
     * @return view
     */
    public function saveToDoList(Request $request, $id) {
        $data = [];
        
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'title'=>'required'
            ]);

            try {
                $res = $this->toDoListService->editToDoList($request, $id, Session::get('user_id'));
                Common::showMessage($request, 'To Do List was successfully saved!');
                return redirect('/');
            } catch(\Exception $e) {
                Common::showMessage($request, 'Something goes wrong!', true);
            }   
        }
    }
}
