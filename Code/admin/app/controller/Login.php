<?php
namespace app\controller;

use app\BaseController;
use think\facade\Db;
use think\facade\Request;
use think\facade\Session;

class Login extends BaseController
{
    public function index()
    {
        return view();
    }

    public function signIn()
    {
        if(request()->isPost()){
            $data = input('post.');
            if($data['auth'] == 'admin'){
                $this->signIn_admin();
            }
            else if($data['auth'] == 'student'){
                $this->signIn_student();
            }
            $this->error('Please choose an Auth', url('index'));
        }
        return $this->index();
    }
    
    public function signIn_admin()
    {
        if(request()->isPost()){
            $data = input('post.');
            $result = Db::name('admin')->where('username',$data['username'])->findOrEmpty();
            // $result = $result->toArray();
            if(!empty($result) && $result['password'] == $data['password']){
                Session::set('username',$result['username']);
                Session::set('auth','admin');
                Session::set('id', $result['admin_id']);
                $this->success("Success Login! Welcome ".$result['username'], url('conf/index'));
            }
        }
        $this->error("Wrong username or password!", url('index'));
    }

    public function signIn_student()
    {
        if(request()->isPost()){
            $data = input('post.');
            $result = Db::name('students')->where('student_id',$data['username'])->findOrEmpty();
            if(!empty($result)){
                if(password_verify($data['password'],$result['password'])){
                    Session::set('username',$result['name']);
                    Session::set('auth','student');
                    Session::set('id',$result['student_id']);
                    $this->success("Admin Management System: Welcome ".$result['name'], url('Student/index'));
                }
                $this->error("Wrong password, Please try again", url('index'));
            }
            $this->error("The student account is not exit", url('index'));
        }
        $this->error("Please login!", url('index'));
    }

    public function logOut()
    {
        Session::clear();
        return $this->index();
        // redirect((string) url('index'));
    }
}
