<?php
namespace app\controller;

use app\BaseController;
use think\facade\Db;
use think\facade\View;

class Conf extends BaseController
{
    public function index()
    {
        return view();
    }

    public function lst()
    {
        $field = ['short_name', 'title', 'faculty', 'prerequisite', 'description'];
        $allCourses = Db::connect('course')->table('course')->paginate(10);
        // View::assign('allCourse', $allCourses);
        $pagesEl = $allCourses->render();
        return view('lst', ['allCourses' => $allCourses, 'pages' => $pagesEl]);
    }

    public function add()
    {
        if(request()->isPost()){
            $data = input('post.');
            $add = Db::connect('course')->table('course')->save($data);
            if ($add){
                $this->success("Success Add Course", url('lst'));
            }
        }
        return view();
    }

    public function edit($short_name)
    {
        if(request()->post()){
            $data = input('post.');
            $data = array_merge($data,["short_name"=>$data['faculty'].' '.$data['course_num']]);
            $result = Db::connect('course')->table('course')->where('courseId', $data['courseId'])->update($data);
            if($result){
                $this->success("Success edit the course info!", url('lst'));
            }
        }
        $course = Db::connect('course')->table('course')->where('short_name',$short_name)->find();
        View::assign('course', $course);
        return view();
    }

    public function del()
    {
        if(request()->post()){
            $data = input('post.');
            $result = Db::connect('course')->table('course')->where('courseId', $data['courseId'])->delete();
            if($result){
                $this->success("Success delete the " . " course!", url('lst'));
            }
        }
        $this->error("Unkown Operation!", url('lst'));
        // dump($short_name); die;
    }
}
