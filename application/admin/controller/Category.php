<?php
namespace app\admin\controller;
class Category extends Common{
    protected $cateModel;
    public function _initialize(){
        parent::_initialize();
        $this->cateModel = model("Category");
    }
    public function index(){
        $list = $this->cateModel->getTree();
        $this->assign('list',$list);
        return $this->fetch();
    }
    public function add(){
        if(request()->isPost()){
            $data = input('post.');
            $file = request()->file('image');
            $result = $this->cateModel->add($data);
            if($result){
                $this->success("添加成功！！！",'index');   
            }else{
                $this->error($this->cateModel->getError());
            }
        }
        $list = $this->cateModel->getTree();
        $this->assign('list',$list);
        return $this->fetch();
    }
    public function edit($id){
        if(request()->isPost()){
            $data = input('post.');
            $res = $this->cateModel->edit($data);
            if($res){
                $this->success("更新成功！！！",'index');
            }else{
                $this->error($this->cateModel->getError());
            }
        }
        $info = $this->cateModel->find($id);
        $childrenId = $this->cateModel->getChildren($id);
        $list = $this->cateModel->getTree();
        $this->assign('childrenId',$childrenId);
        $this->assign('list',$list);
        $this->assign('info',$info);
        return $this->fetch();
    }
    public function delt($id){
        $res = $this->cateModel->delt($id); 
        if($res){
            $this->success('删除成功！！！','index');    
        }else{
            $this->error($this->cateModel->getError());
        }
    }
    public function ajaxSort($sort,$id){
        $this->cateModel->where('id',$id)->setField('sort',$sort);
        $list = $this->cateModel->getTree();
        echo json_encode($list);
    }
}
?>