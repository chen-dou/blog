<?php
namespace app\index\controller;
class Content extends Common{
    public function index(){
        $ar_id = input('ar_id');
        $info = db('article')->alias('a')->field('a.id,a.name,a.author,a.time,a.content,c.id cate_id,c.name cate_name')->join('blog_category c','a.cate_id=c.id')->find($ar_id);
        $info['tag'] = db('tag')->alias('t')->join('blog_article_tag at','t.id=at.tag_id')->where('article_id',$ar_id)->select();
        $previnfo = db('article')->where('cate_id',$info['cate_id'])->where('id','<',$ar_id)->order('time desc')->limit(1)->find();
        $nextinfo = db('article')->where('cate_id',$info['cate_id'])->where('id','>',$ar_id)->order('time desc')->limit(1)->find();
        $commentData = db('comment')->alias('c')->limit(5)->order('time desc')->field('c.id comment_id,c.content,c.time,m.name,m.id member_id,face')->where('article_id',$ar_id)->join('blog_member m','c.member_id=m.id','left')->select();
        foreach($commentData as $k=>$v){
            //$commentData[$k]['reply'] = db('reply')->alias('r')->field('r.*,m.name')->join('blog_member m','r.member_id=m.id','left')->where('comment_id',$v['comment_id'])->select(); 
            $commentData[$k]['reply'] = model('Reply')->getTree($v['comment_id']);
            session("comment_id",$commentData[$k]["comment_id"]);
        }
        $this->assign('commentData',$commentData);
        $this->assign('previnfo',$previnfo);
        $this->assign('nextinfo',$nextinfo);
        $this->setPageInfo("详情页",$info['name'],$info['name'],array('aside','article'));
        $this->getAsideData();
        $this->assign('cate_id',$info['cate_id']);
        $this->assign('info',$info);
        return $this->fetch();
    }
    public function ajaxSendComment($article_id){
        $data = input("post.");
        $data['article_id'] = $article_id;
        $commentModel = model('Comment');
        if($commentModel->add($data)){
            $info = db('member')->where('id',session('member.id'))->find();
            echo json_encode(array(
                'ok'=>1,
                'name'=>$info['name'],
                'face'=>$info['face'],
                'content'=>$data['content'],
                'time'=>date('Y-m-d H:i:s',time()),
            ));    
        }else{
            echo  json_encode(array(
                'ok'=>0,
                'error_msg'=>$commentModel->getERror(),
            ));
        }
     }
     public function ajaxAddReply(){
         $data=input('post.');
         $replyModel = model('Reply');
         if(model('Reply')->add($data)){
            $name = db('member')->where('id',session('member.id'))->value('name');
             $face = db('member')->where('id',session('member.id'))->value('face');
            $to_name = db('member')->where('id',$data['to_member_id'])->value('name');
             $to_face = db('member')->where('id',$data['to_member_id'])->value('face');
            echo json_encode(array(
                'ok'=>1,
                'name'=>$name,
                'to_name'=>$to_name,
                'face'=>$face,
                'to_face'=>$to_face,
                'pid'=>model('Reply')->pid,
                'content_id'=>model('Reply')->comment_id,
                'to_member_id'=>model('Reply')->member_id,
                'content'=>$data['content'],
                'time'=>date('Y-m-d H:i:s',time()),
            ));     
         }else{
             echo json_encode(array(
                'ok'=>0,
                 'error_msg'=>$replyModel->getError(),
             ));
         }
     }
     public function ajaxAddMore($article_id){
        $commentData = db('comment')->alias('c')->order('time desc')->field('c.id comment_id,c.content,c.time,m.name,m.id member_id,m.face')->limit(5)->where('article_id',$article_id)->where("c.id","<",session("comment_id"))->join('blog_member m','c.member_id=m.id','left')->select();
        foreach($commentData as $k=>$v){
            $commentData[$k]['reply'] = model('Reply')->getTree($v['comment_id']);
            session("comment_id",$commentData[$k]["comment_id"]);
        }
        if(empty($commentData)){
            echo json_encode(array('ok'=>0));    
        }else{
            echo json_encode($commentData);
        }
     }
}