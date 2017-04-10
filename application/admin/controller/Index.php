<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;
use think\Session;

class Index extends Controller{
    
    //后台首页
    public function index(){
        $admin_id = Session::get('admin_id');
        $info  = db('admin')->alias('a')
                            ->join('t_admin_role ar','a.admin_id=ar.admin_id')
                            ->join('t_role r','r.role_id=ar.role_id')
                            ->where('a.admin_id',$admin_id)
                            ->select();
                    
        $admin = $info[0]['admin'];
        $role_name = $info[0]['role_name'];
        
        $this->assign('admin',$admin);
        $this->assign('role_name',$role_name);
        return $this->fetch();
    }
    
    //后台欢迎页
    public function welcome(){
        $admin_id = Session::get('admin_id');
        $model = new \app\admin\model\Admin();
        $getfunc = $model->getfunc($admin_id);
        //dump($getfunc);
        
        return $this->fetch();
    }
    
    //后台登录
    public function login(){
        
       if(Request::instance()->isPost()){
             $admin = Request::instance()->post('admin');
             $password = Request::instance()->post('password');
             $verify = Request::instance()->post('verify');
             
             //手动验证验证码
             if(!captcha_check($verify)){
                 $this->error('登录失败：验证码错误');
                 return;
             };
             
             $model = new \app\admin\model\Admin();
             $user = $model->where('admin',$admin)->find();
             //dump($user);
             //exit();
            
             if($user){
                 if(md5($password) == $user['password']){
                      Session::set('admin_id', $user['admin_id']);
                      Session::set('user', $user);
                      //$admin_id = Session::get('admin_id');
                      // echo $admin_id;
                      //echo Session::get('user'); die;
                      //$a = $model->getfunc($admin_id); dump($a);die;
                      
                      //$user->getMenu($user['admin_id']);
                      
//                      foreach ($list as $v){
//                           if($v['func_parent'] == 0){
//                               $menu[$v['func_id']]=$v;
//                           }else{
//                               $menu[$v['func_parent']]['child'][]=$v;
//                           }
//                           //判断
//                           $this->url[] = $v['func_url'];
//                      }
//                       $this->assign("menu",$menu);
                      
                      $this->redirect("admin/Index/index");
                 }
                
             } else {
                 $this->error('登录失败'); 
             }
             
         }
         
       return $this->fetch();
         
    }
    
     //后台退出
    public function logout(){
        Session::delete('$user');
        Session::clear();
        $this->redirect('admin/Index/login');
        //$this->success("退出成功",'admin/Admin/login');
    }
    
    
}
