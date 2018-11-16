<?php
namespace app\index\controller;
class Index extends Common{
    public function index(){
        $article = db('article');
        $newArticleData = $article->order('time desc')->limit(6)->select();
        $caseShowData = $article->limit(6)->where('cate_id',42)->order('time desc')->select();
        $noteData = $article->order('time desc')->where('cate_id',41)->limit(6)->select();
        $this->setPageInfo("陈豆的个人博客","陈豆的个人博客",'陈豆的个人博客',array('article_list','index'));
        $this->assign('newArticleData',$newArticleData);
        $this->assign('caseShowData',$caseShowData);
        $this->assign('noteData',$noteData);
        $this->assign('cate_id',0);
        return $this->fetch();
    }
}
