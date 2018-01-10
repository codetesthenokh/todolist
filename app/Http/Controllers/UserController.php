<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Libraries\Common;
use App\Services\UserService;
use App\User;
use Carbon\Carbon;

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

    /** Edit Profile
     * 
     * @param Illuminate\Http\Request
     * @return view
     */
    public function editProfile(Request $request) {
        $data = [];
        $res = $this->userService->getUserById(Session::get('user_id'));
        $user = json_decode($res->getBody()->getContents());
        if ($user != null) {
            $data['name'] = $user->name;
        } else {
            return redirect('errors/404');
        }

        return view('account/edit_profile', $data);
    }

    /**
     * Save edited profile
     * @access public
     * @param Illuminate\Http\Request
     * @param string
     * @return view
     */
    public function saveProfile(Request $request) {
        $data = [];
        
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'name'=>'required'
            ]);

            try {
                $res = $this->userService->editProfile($request, Session::get('user_id'));
                Common::showMessage($request, 'Profile was successfully saved!');
                Session::put('user_name', $request->input('name'));
                return redirect('/');
            } catch(\Exception $e) {
                Common::showMessage($request, 'Something goes wrong!', true);
            }   
        }
    }

    /** Change password
     * 
     * @param Illuminate\Http\Request
     * @return view
     */
    public function changePassword(Request $request) {
        $data = [];
        $data["old_password"] = null;
        $data["password"] = null;;
        $data["confirm_password"] = null;;

        if ($request->isMethod('post')) {
            $this->validate($request, [
                'old_password'=>'required',
                'password'=>'required',
                'confirm_password'=>'required|confirmationPassword:' . $request->input('password')
            ],[
                'confirm_password.confirmation_password'=> 'Confirmation password must be identical with password.'
            ]);

            $whereclause = ['id' => Session::get('user_id'), 'password' => md5($request->input('old_password'))];
            $user_login = User::where($whereclause)->first();
            
            if ($user_login != null) {
                $res = $this->userService->changePassword($request, Session::get('user_id'));
                Common::showMessage($request, 'Password was successfully changed!');
                return redirect('/');
            } else {
                Common::showMessage($request, 'Wrong password', true);
            }
        }

        return view('account/change_password', $data);
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

            $res = $this->userService->login($request);
            $user_login = json_decode($res->getBody()->getContents());
            $tmp = (array) $user_login;
            if ($user_login != null && !empty($tmp)) {
                Session::put('user_id', $user_login->id);
                Session::put('user_name', $user_login->name);
                Session::put('expired_at', Carbon::now()->addMinutes(15));
                return redirect('/');
            } else {
                Common::showMessage($request, 'Failed! Please re-check your username and password', true);
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
