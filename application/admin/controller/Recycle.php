<?php
namespace app\admin\controller;
class Recycle extends Common{
    public function _initialize(){
        parent::_initialize();
        $this->articleModel = model("Article");
    }
    public function index(){
        $list = db("article")->alias("a")->field('a.id,a.author,a.time,a.click,a.name,c.name cate_name')->join("blog_category c",'a.cate_id=c.id')->where('recycle',1)->order('time desc')->paginate(5);
        $this->assign('list',$list);
        return $this->fetch();
    }
    public function restore($id){
        $result = db('article')->where('id',$id)->setField('recycle',0);  
        if($result){
            $this->success("还原成功！！！",'index');    
        }else{
            $this->error("还原失败！！！");
        }
    }
    public function delt($id){
        $result = $this->articleModel->delt($id);
        if($result){
            $this->success("删除成功！！！",'index');
        }else{
            $this->error($this->articleModel->getError());
        }    
    }
}
?>