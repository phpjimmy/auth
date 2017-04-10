<?php
namespace app\admin\controller;
use think\Request;
use think\Session;

class Admin extends Base{
   
    
    
    //角色管理--列表
    public function adminRole(){
        
         return $this->fetch();
    }
    
    //角色添加
    public function adminRoleAdd(){
        
         return $this->fetch();
    }
    
    
    //权限管理--列表
    public function adminPermission(){
        
         return $this->fetch();
    }
    
    //管理员列表
    public function adminList(){
        
         return $this->fetch();
    }
    
    //管理员添加
    public function adminAdd(){
        
         return $this->fetch();
    }
    
    
}
