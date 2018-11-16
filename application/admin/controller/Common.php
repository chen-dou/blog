<?php
namespace app\admin\controller;
use think\Controller;
class Common extends Controller{
    public function _initialize(){
        if(!session('admin.id')){
            $this->redirect("login/index");    
        }           
    }
}