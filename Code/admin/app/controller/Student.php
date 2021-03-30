<?php
namespace app\controller;

use app\BaseController;
use think\facade\Db;
use think\facade\Session;
use think\facade\View;

class Student extends BaseController
{
    public function index()
    {
        return view();
    }

    public function lst()
    {
        $student_id = session('id');
        $histories = Db::table('S'.$student_id)->paginate(15);
        $pagesEl = $histories->render();
        return view('lst', ['histories' => $histories, 'pages' => $pagesEl]);
    }
    
    public function add()
    {
        if(request()->isPost()){
            // Dealling the parameters
            $data = input('post.');
            $data['term'] = $data['year'] . $data['term'];
            unset($data['year']);

            $title = Db::connect('course')->table('course')->where('short_name',$data['course_ID'])->find();
            $data['course_title'] = $title['title'];
            // dump($data); die;
            // $addData = ['title'=>$title['title']];
            // $newData = array_merge($data,$addData);
            // dump($data['title']); die;

            $student_id = session('id');
            $add = Db::connect('mysql')->table('S'.$student_id)->save($data);
            if ($add){
                $this->success("Success add history record", url('lst'));
            }
            $this->error("Faill to add the history record", url('lst'));
        }
        return view();
    }

    public function edit($courseIndex)
    {
        $student_id = session('id');
        if(request()->post()){
            $data = input('post.');
            // $data = array_merge($data,["short_name"=>$data['faculty'].' '.$data['course_num']]);
            $title = Db::connect('course')->table('course')->where('short_name',$data['course_ID'])->find();
            $data['course_title'] = $title['title'];
            // dump($data); die;
            $result = Db::table('S'.$student_id)->where('courseIndex', $data['courseIndex'])->update($data);
            if($result){
                $this->success("Success edit the history course!", url('lst'));
            }
        }
        $course = Db::table('S'.$student_id)->where('courseIndex',$courseIndex)->find();
        View::assign('course', $course);
        return view();
    }

    public function delete($courseIndex)
    {
        return $this->lst();
    }

}
