<?php
namespace app\index\controller;
class Lst extends Common{
    public function index(){
        $cate_id = input('cate_id');
        $tag_id = input('tag_id');
        if($cate_id){
            $articleData = db('article')->order('time desc')->where('cate_id',$cate_id)->paginate(9);
            $this->assign('cate_id',$cate_id);
        }
        if($tag_id){
            $articleData = db('article')->alias('a')->order('time desc')->join('blog_article_tag at','a.id=at.article_id')->where('tag_id',$tag_id)->paginate(9);    
            $this->assign('cate_id','false');
        }
        $this->assign('articleData',$articleData);
        $this->getAsideData();
        $this->setPageInfo("列表页","列表页","列表页",array('list','article_list','aside'));
        return $this->fetch();
    }
}
