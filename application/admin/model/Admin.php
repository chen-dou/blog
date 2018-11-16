<?php
namespace app\admin\model;
use think\Model;
class Admin extends Model{
    protected $rule = [
        'user'=>'require',
        'password'=>'require'
    ];
    protected $message = [
        'user.require'=>'用户名不能为空！！！',
        'password.require'=>'密码不能为空！！！',
    ];
    public function login($data){
        $validate = validate('Admin');
        if($validate->scene('login')->check($data)){
            $info = $this->where('user',$data['user'])->find();
            if($info && md5($data['password'])==$info['password']){
                session('admin',$info);
                return true;    
           }else{
               $this->error = "用户名或密码不正确";
               return false;
           }           
        }else{
            $this->error = $validate->getError();
            return false;
        } 
    }
    public function add($data){
        $validate = validate('Admin');
        if($validate->scene('add')->check($data)){
            $data['password'] = md5($data['password']);
            if($this->allowField(['user','password'])->save($data)){
                return true;    
            }else{
                $this->error="新增失败";
                return false;
            }   
        }else{
            $this->error = $validate->getError();
            return false;
        }
    }
    public function edit($data){
        $validate = validate('Admin');
        if($validate->scene('edit')->check($data)){
            $data['password'] = md5($data['password']);
            if($this->allowField(['user','password'])->save($data,['id'=>$data['id']])!==false){
                return true;    
            }else{
                $this->error = "修改失败！！！";
                return false;
            }        
        }else{
            $this->error = $validate->getError();
        }
    }
    public function delt($id){
        if(self::destroy($id)){
            return true;    
        }else{
            $this->error = "删除失败！！！";
            return false;
        }
    }
}
?>
