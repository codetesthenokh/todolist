<?php

namespace App\Libraries;

class Common
{

    /**
     * Add message to session as notification
     * @access public
     * @param Illuminate\Http\Request
     * @param string
     * @return void
     */
    public static function showMessage($request, $message, $isError = false) {
        $request->session()->flash($isError ? 'alert-danger' : 'alert-success', $message);
    }

     /**
     * Get priority list
     * @access public
     * @return array of object
     */
    public static function getPriorityList() {
        return ['red', 'yellow', 'green', 'gray'];
    }
}