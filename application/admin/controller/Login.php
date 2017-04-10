<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;
use think\Session;

class Login extends Controller{
    
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
                      // echo Session::get('admin_id');
                      //echo Session::get('user'); die;
                      
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
                
             }else{
                 $this->error('登录失败'); 
             }
             
         }
         
         return $this->fetch();
    }
    
    
     //后台退出
    public function logout(){
        Session::delete('$user');
        Session::clear();
        $this->redirect('admin/Login/login');
        //$this->success("退出成功",'admin/Admin/login');
    }
    
    
}
