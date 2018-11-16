<?php
namespace app\admin\controller;
class Admin extends Common{
    private $adminModel;
    public function _initialize(){
        parent::_initialize();
        $this->adminModel = model('Admin');
    }
    public function index(){
        $list = $this->adminModel->select();
        $this->assign('list',$list);
        return $this->fetch();    
    }
    public function add(){
        if(request()->isPost()){
            $data = input('post.');
            $res = $this->adminModel->add($data);
            if($res){
                $this->success("添加成功！！！",'index');
                exit;
            }else{
                $this->error($this->adminModel->getError());
                exit;
            }
        }
        return $this->fetch();    
    }
    public function edit($id){
        $info = $this->adminModel->find($id);
        if(request()->isPost()){
            $data = input('post.');
            $res = $this->adminModel->edit($data);
            if($res){
               if(session('admin.id')==$id && $info['password']!=md5($data['password'])){
                    session(null);   
                }
                $this->success('修改成功！！！','index');
                exit;
            }else{
                $this->error($this->adminModel->getError());   
                exit;
            }
        }
        $this->assign('info',$info);
        return $this->fetch();
    }
    public function delt($id){
        $res = $this->adminModel->delt($id);
        if($res){
            $this->success('删除成功！！！');
        }else{
            $this->error($this->adminModel->getError());
        }
    }
}
?>