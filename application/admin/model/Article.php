<?php
namespace app\admin\model;
use think\Model;
class Article extends Model{
    public function add($data){
        if(!isset($data['tag_id'])){
            $this->error = "青选择标签！！！";
            return false;
        }
        $data['time'] = time();
        $validate = validate("Article");
        if($validate->check($data)){
            if($this->allowField(true)->save($data)){
                $article_id = $this->id;
                $articleTagData = array();
                foreach($data['tag_id'] as $v){
                    $articleTagData[] = ['tag_id'=>$v,'article_id'=>$article_id];        
                }
                db("articleTag")->insertAll($articleTagData);
                return true;
            }else{
                $this->error = "新增失败！！！";
                return false;
            }    
        }else{
            $this->error = $validate->getError();
            return false;
        }
    }
    public function edit($data){
        if(!isset($data['tag_id'])){
            $this->error = "青选择标签！！！";
            return false;
        }
        $validate = validate("Article"); 
        if($validate->check($data)){
            if($this->allowField(true)->save($data,['id'=>$data['id']])!==false){
                db("articleTag")->where('article_id',$data['id'])->delete();
                $tagId = $data['tag_id'];
                $articleTagData = array();
                foreach($tagId as $v){
                    $articleTagData[] = ['article_id'=>$data['id'],'tag_id'=>$v];
                }
                db("articleTag")->insertAll($articleTagData);
                return true;
            }else{
                return false;
            }
        }else{
            $this->error = $validate->getError();
            return false;
        }
    }
    public function delt($id){
        $image = $this->where('id',$id)->value('image');
        if($image){
            @unlink($image);
        }
        $rows = db("articleTag")->where('article_id',$id)->delete();
        if($rows!==false){
            if(self::where('id',$id)->delete()){
                return true;
            }else{
                $this->error = "删除失败！！！";
                return false;
            }        
        }else{
            $this->error = "删除中间表失败";
            return false;
        }
     }
}
?>