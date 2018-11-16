<?php
namespace app\admin\model;
use think\Model;
class Tag extends Model{
    public function add($data){
        $result = $this->validate(true)->save($data);
        if(false === $result){
            $this->error = $this->getError();
            return false;
        }else{
            return true;    
        }
    }
    public function edit($data){
        $validate = validate("Tag");
        if($validate->check($data)){
            if($this->save($data,['id'=>$data['id']])!==false){
                return true;    
            }else{
                $this->error = "修改失败！！！";
                return false;
            } 
        }else{
            $this->error=$validate->getError();
            return false;
        }
    }
    public function delt($id){
        $rows = db('articleTag')->where('tag_id',$id)->delete();
        if($rows!==false){
            $result = self::where(['id'=>$id])->delete();
            if($result){
                return true;
            }else{
                $this->error = "删除失败！！！";
                return false;
            }    
        }else{
            $this->error = "删除中间表失败！！！";
            return false;
        }
    }
}