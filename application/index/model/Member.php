<?php
namespace app\index\model;
use think\Model;
class Member extends Model{
    public function add($data){
        $validate = validate('Member');
        if($validate->scene('add')->check($data)){
            $data['password'] = md5($data['password']);
            if($this->allowField(true)->save($data)){
                return true;
            }else{
                $this->error= "4_注册失败";
                return false;
            }    
        }else{
            $this->error = $validate->getError();
            return false;
        }
    }
    public function login($data){
        $validate = validate('Member');
        if($validate->scene('login')->check($data)){
            $info = $this->where('telnum',$data['telnum'])->find();
            if($info){
                if(md5($data['password'])==$info['password']){
                    session('member',$info);
                    return true;
                }else{
                    $this->error="1_用户名或密码不正确";
                    return false;
                }        
            }else{
                $this->error = "0_该账号不存在";
                return false;
            }
        }else{
            $this->error = $validate->getError();
            return false;
        }
    }
}
?>