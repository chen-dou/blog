<?php
namespace app\admin\controller;
use think\Controller;
class Login extends Controller{
    private $aModel;
    public function _initialize(){
       $this->aModel = model('Admin');
    }
    public function index(){
        if(request()->isPost()){
            $data = input('post.');
            $res = $this->aModel->login($data);
            if($res){
                $this->success('登录成功！！！',"index/index");                  
            }else{
                $this->error($this->aModel->getError());
            }
        }
        return $this->fetch();
    }
    public function logout(){
        session('admin',null);
        $this->redirect('login/index');
    }
}
?>