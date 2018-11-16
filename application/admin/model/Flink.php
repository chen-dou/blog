<?php
namespace app\admin\model;
use think\Model;
class Flink extends Model{
    public function add($data){
        $validate = validate("Flink");  
        if($validate->check($data)){
            if($this->allowField(true)->save($data)){
                return true;
            }else{
                $this->error = "添加失败！！！";
                return false;
            }
        }else{
            $this->error=$validate->getError();
            return false;
        }
    }
    public function edit($data){
        $validate = validate("Flink");
        if($validate->check($data)){
            if($this->allowField(true)->save($data,$data['id'])!==false){
                return true;
            }else{
                $this->error = "修改失败！！！";
                return false;
            }       
        }else{
            $this->error = $validate->getError();
            return false;
        }
    }
    public function delt($id){
        if(self::where('id',$id)->delete($id)){
            return true;
        }else{
            return false;
        }
    }
}
?>