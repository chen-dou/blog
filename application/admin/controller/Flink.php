<?php
namespace app\admin\controller;
class Flink extends Common{
    private $flinkModel;
    public function _initialize(){
        parent::_initialize();
        $this->flinkModel = model("Flink");
    }
    public function index(){
        $list = $this->flinkModel->order('sort asc')->select();
        $this->assign('list',$list);
        return $this->fetch();
    }
    public function add(){
        if(request()->isPost()){
            $data = input('post.');
            $image = $this->upload();
            $data['image'] = $image?$image:'';
            if($this->flinkModel->add($data)){
                $this->success("添加成功！！！",'index');
                exit;
            }else{
                $this->error($this->flinkModel->getError());
                exit;
            }
        }
        return $this->fetch();
    }
    public function edit($id){
        $info = $this->flinkModel->find($id);
        if(request()->isPost()){
            $data = input("post.");
            $image = $this->upload($info);
            $data['image'] = $image?$image:$info['image'];
            $result = $this->flinkModel->edit($data);
            if($result){
                $this->success('修改成功！！！','index');   
                exit;
            }else{
                $this->error($this->flinkModel->getError());
                exit;
            }
        }
        $this->assign('info',$info);
        return $this->fetch();
    }
    public function delt($id){
        if($this->flinkModel->delt($id)){
            $this->success("删除成功！！！",'index');    
        }else{
            $this->error('删除失败！！！！');
        }
    }
    public function upload($data=null){
        $file = request()->file('image');
        if($file){
            $info  = $file->validate(['ext'=>'jpg,png,gif'])->move(ROOT_PATH . 'public' . DS . 'uploads');
            if($info){
                if($data){
                    @unlink($data['image']);
                }
                $image = "uploads/".$info->getSaveName();
                return $image;
            }else{
                $this->error($file->getError());
            }
        }
    }
}
?>