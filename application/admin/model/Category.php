<?php
namespace app\admin\model;
use think\Model;
class Category extends Model{
   /* protected static function init(){
        self::beforeDelete(function($cate){
            $childrenId = model("Category")->getChildren($cate['id']);
            self::destroy($childrenId);
         });
    } */
    public function add($data){
        $validate = validate("Category");
        if($validate->check($data)){
            if($this->save($data)){
                return true;        
            }else{
                $this->error="添加失败！！！";
                return false;
            }                    
        }else{
            $this->error=$validate->getError();
            return false;
        }      
    }
    public function edit($data){
        $validate = validate("Category");
        if($validate->check($data)){
            if($this->save($data,['id'=>$data['id']]!==false)){
                return true;    
            }else{
                $this->error="更新失败！！！";
                return false;
            }   
        }else{
            $this->error = $validate->getError();
            return false;
        }
    }
    public function delt($id){
        $ids = $this->getChildren($id);
        $ids[] = $id;
        $articleIds = db('article')->where('cate_id','in',$ids)->column('id');
        $article = new Article();
        foreach ($articleIds as $k=>$v){
            $article->delt($v);
        }
        if(self::where('id','in',$ids)->delete()){
            return true;
        }else{
            $this->error="删除失败！！！";
        }   
    }
    public function getTree(){
        $data = $this->order('sort asc')->select();
        return $this->_getTree($data);
    }
    public function _getTree($data,$pid=0,$level=0){
        static $arr = array();
        foreach($data as $k=>$v){
            if($v['pid']==$pid){
                $v['level'] = $level;
                $arr[] = $v;
                $this->_getTree($data,$v['id'],$level+1);
            }                                
        }
        return $arr;
    }
    public function getChildren($id){
        $data = $this->select();
        return $this->_getChildren($data,$id);
    }
    public function _getChildren($data,$id){
        static $arr = array();
        foreach($data as $k=>$v){
            if($v['pid']==$id){
                $arr[] = $v['id'];
                $this->_getChildren($data,$v['id']);
            }
        } 
        return $arr;
    }
}
?>