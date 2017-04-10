<?php
namespace app\admin\model;
use think\Model;
use think\Db;

class Admin extends Model{
    
    protected $table = "t_admin";
   
    public function getfunc($admin_id){
        $sql1 = "select func_ids from t_admin_role ar left join t_role r on ar.role_id=r.role_id where ar.admin_id=$admin_id";
        $func_ids = Db::query($sql1);
        //dump($func_ids);
        $sql = "select * from t_func where func_id in ({$func_ids[0]['func_ids']})";
        $func_list = Db::query($sql);
        
        $menu = [];
        $url = [];
        foreach ($func_list as $v){
            if($v['func_parent'] == 0){
                $menu[$v['func_id']]=$v;   //$menu[1]=array('child'=>[])
                
                $menu[$v['func_id']]['child'] =[];
            }else{
                //$menu[1]['child']=array()  $menu[1]['child'][]=22;
                $menu[$v['func_parent']]['child'][]=$v;
                
            }
            
           $url[] = $v['func_url'];
        }
         $data['menu'] = $menu;
         $data['url'] = $url;
         return $data;
       
    }
    
    
}
