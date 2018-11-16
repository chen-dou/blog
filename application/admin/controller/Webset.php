<?php
namespace app\admin\controller;
class Webset extends Common{
    public function _initialize(){
        parent::_initialize();
    }
    public function index(){
        $list = db('webset')->select();
        $this->assign('list',$list);
        return $this->fetch();
    }
    public function ajaxChangeValue($value,$id){
        $result = $this->validate(['value'=>$value],["value"=>"require"],["value.require"=>"值不能为空！！！"]);
        if(true !== $result){
            $this->error($result); 
        }else{
            db("webset")->where('id',$id)->setField('value',$value); 
            $this->success("修改成功！！！",'index');
        }
    }
}
?>