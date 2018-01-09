<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Libraries\Common;
use App\Services\UserService;
use App\User;
class UserController extends Controller
{
    public function __construct() {
        $this->userService = new UserService();
    }
    /** Create new account to be used in log in
     * 
     * @param Illuminate\Http\Request
     * @return view
     */
    public function register(Request $request) {
        $data = [];
        $data["name"] = $request->input('name');
        $data["email"] = $request->input('email');
        $data["password"] = $request->input('password');
        $data["confirmPassword"] = $request->input('confirmPassword');

        if ($request->isMethod('post')) {
            $this->validate($request, [
                'name'=>'required',
                'email'=>'required',
                'password'=>'required',
                'confirmPassword'=>'required|confirmationPassword:' . $request->input('password')
            ],[
                'confirmPassword.confirmation_password'=> 'Confirmation password must be identical with password.'
            ]);

            try {
                $res = $this->userService->createUser($request);
                Common::showMessage($request, 'Category was successfully added!');
                return redirect('/home');
            } catch(\Exception $e) {
                Common::showMessage($request, 'Email already preserved', true);
            }
        }

        return view('account/register', $data);
    }

    /** Validate log in
     * 
     * @param Illuminate\Http\Request
     * @return view
     */
    public function login(Request $request) {
        $data = [];
        $data["email"] = $request->input('email');
        $data["password"] = md5($request->input('password'));

        if ($request->isMethod('post')) {
            $this->validate($request, [
                'email'=>'required',
                'password'=>'required'
            ]);

            $whereclause = ['email' => $data["email"], 'password' => $data["password"]];
            $user_login = User::where($whereclause)->first();
            
            if ($user_login != null) {
                Session::put('user_id', $user_login->id);
                return redirect('/');
            } else {
                Common::showMessage($request, 'User not found', true);
            }
        }

        return view('account/login', $data);
    }

    /** Log out from system
     * Log out shall flush all the browser session
     * 
     * @return view
     */
    public function logout() {
        Session::flush();
        return redirect('/home');
    }
}
