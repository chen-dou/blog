<?php
namespace app\index\controller;
use think\Controller;
class Common extends Controller{
    public function _initialize(){
        $_categoryData = db('category')->select();
        $websetData = db('webset')->column("value",'name');
        $flinkData = db('flink')->order('sort')->limit(3)->select();
        $this->assign('flinkData',$flinkData);
        $this->assign('websetData',$websetData);
        $this->assign('_categoryData',$_categoryData);
    }
    public function setPageInfo($title,$keywords,$description,$css=array(),$js=array()){
        $this->assign('title',$title); 
        $this->assign('keywords',$keywords);
        $this->assign('description',$description);
        $this->assign('css',$css);
        $this->assign('js',$js);
    }
    public function getAsideData(){
        $_articleData = db('article')->order('time desc')->limit(10)->select();
        $_commentData = db('comment')->field('c.*,m.name,m.face')->order('time desc')->alias('c')->join('blog_member m','c.member_id=m.id','left')->limit(10)->select();
        $tagData = db('tag')->select();
        $this->assign('_commentData',$_commentData);
        $this->assign('_articleData',$_articleData);
        $this->assign('tagData',$tagData);
    }
    
}