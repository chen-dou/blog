<?php
namespace app\admin\controller;
class Article extends Common{
    private $articleModel;
    public function _initialize(){
        parent::_initialize();
        $this->articleModel = model("Article");
    }
    public function index(){
        $list = db("article")->alias("a")->field('a.id,a.author,a.time,a.click,a.name,c.name cate_name')->join("blog_category c",'a.cate_id=c.id','left')->where('recycle',0)->order('time desc')->paginate(10);
        $this->assign('list',$list);
        return $this->fetch();        
    }
    public function add(){
        if(request()->isPost()){
            $data = input('post.');
            $image = $this->upload();
            $data['image'] = $image?$image:'';
            $result = $this->articleModel->add($data);
            if($result){
                $this->success('添加成功！！！',"index");
                exit;
            }else{
                $this->error($this->articleModel->getError());
                exit;
            }
        }
        $tagData = db('tag')->select();
        $this->assign('tagData',$tagData);
        $category = model('Category');
        $cateList = $category->getTree();
        $this->assign('cateList',$cateList);
        return $this->fetch();
    }
    public function edit($id){
        $info = $this->articleModel->find($id);
        if(request()->isPost()){
            $data = input("post.");
            $image = $this->upload($info);
            $data['image'] = $image?$image:$info['image'];
            $result = $this->articleModel->edit($data);
            if($result){
                $this->success('编辑成功！！！','index'); 
                exit;
            }else{
                $this->error($this->articleModel->getError());
                exit;
            }
        }
        $tagId = db("articleTag")->where('article_id',$id)->column("tag_id");
        $this->assign('tagId',$tagId);
        $tagData = db('tag')->select();
        $this->assign('tagData',$tagData);
        $category = model('Category');
        $cateList = $category->getTree();
        $this->assign('info',$info);
        $this->assign('cateList',$cateList);
        return $this->fetch();
    }
    /* public function delt($id){
        $result = $this->articleModel->delt($id);
        if($result){
            $this->success("删除成功！！！",'index');
        }else{
            $this->error($this->articleModel->getError());
        }
    } */
    public function torecycle($id){
        $result = db("article")->where('id',$id)->setField("recycle",1);
        if($result){
            $this->success('添加到回收站成功！！！','index');    
        }else{
            $this->error("添加到回收站失败！！！");
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