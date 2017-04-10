<?php
namespace app\admin\controller;
use think\Controller;
use think\Session;
use think\Request;

class Base extends Controller{
    
    /*
     * 权限管理：
     *   1、角色(描述用户的职位信息) ---职位---
     *   2、用户 ---一个用户可以有多个角色
     *   3、功能表 ---会员--- id    parent_id     url
     *               会员列表
     *               会员等级
     *              商品--
     *                 商品列表
     *                 商品列表
     *   4、角色权限   id   role_id   fun_id(varchar)   细化了每个人的工作
     *   5、用户角色  id    user_id     role_id(varchar)
     *
     *   中间表： role_func_id   多表之间的关联关系
     *   role_id   func_id
     *     1          4
     *     1          5
     *
     *   1、后台用户登录，先判断当前用户的角色，在根据角色查询对应的功能  $url[]=array()
     *
     *   2、登录成功之后，要进行功能判断（获取当前操作的模块名称/控制器名称/方法名称，和角色拥有的功能url做对比） 
     *   if(!in_array(模块名称/控制器名称/方法名称,$url)){
     *      alert(没有权限访问)；
     *   }
     */
    
    
    protected $url;
   
    public function __construct(Request $request = null) {
        parent::__construct($request);
        
        //session("?userid")：判断session中是否存在某个变量
        if(session("?admin_id")){
            $this->getMenu();
            
            //echo Request::instance()->module().'--';
            //echo Request::instance()->controller().'--';
            //echo Request::instance()->action().'--';
            //strtolower — 将字符串转化为小写
            
            $url = strtolower(Request::instance()->module())."/".strtolower(Request::instance()->controller())."/".strtolower(Request::instance()->action());
            //dump($this->url);
            //die;
            if(!in_array($url, $this->url)){
                $this->error('对不起！您没有访问权限','admin/Index/welcome');
            }
            
        }else{
            $this->redirect("admin/Index/login");
        }
        
    }
    
    
    //判断权限
    public function getMenu(){
       $admin_model = new \app\admin\model\Admin();
       
       $list = $admin_model->getfunc(session('admin_id'));
       //dump($list);die;
       $this->url=$list['url'];
       $this->assign("menu",$list['menu']);
    }
    
    
    
    
    
}
