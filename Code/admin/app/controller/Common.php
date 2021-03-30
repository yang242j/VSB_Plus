<?php
// PHP program to pop an alert
// message box on the screen
namespace app\controller;

use think\facade\Session;
  
// Function defnition
class Common {
    public function getUser(){
        return Session::get('username');
    }
}
  
?>