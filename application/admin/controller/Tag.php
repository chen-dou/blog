<?php
namespace app\admin\controller;
class Tag extends Common{
    public $tagModel;
    public function _initialize(){
        parent::_initialize();
        $this->tagModel = model("Tag");
    }
    public function index(){
        $list = $this->tagModel->order('sort')->select();
        $this->assign('list',$list);
        return $this->fetch();
    }
    public function add(){
        if(request()->isPost()){
            $data = input("post.");
            $result = $this->tagModel->add($data);
            if($result){
                $this->success('添加成功！！！','index');    
            }else{
                $this->error($this->tagModel->getError());
            }
        }
        return $this->fetch();
    }
    public function edit($id){
        if(request()->isPost()){
            $data = input("post.");
            $result = $this->tagModel->edit($data);
            if($result){
                $this->success("修改成功！！！",'index');
                exit;
            }else{
                $this->error($this->tagModel->getError());
                exit;
            }
        }
        $info = $this->tagModel->find($id);
        $this->assign("info",$info);
        return $this->fetch();    
    }
    public function delt($id){
        $result = $this->tagModel->delt($id); 
        if($result){
            $this->success("删除成功！！！",'index');
        }else{
            $this->error($this->tagModel->getError());
        }
    }
}
?>