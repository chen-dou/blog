<?php
namespace app\index\controller;
use think\Controller;
use think\Request;
use think\Loader;
class Member extends Controller{
    protected $memberModel;
    public function _initialize(){
        parent::_initialize();
        $this->memberModel = model('Member');
    }
    //发送手机验证码
    public function ajaxGetCode(){
        //网易云信分配的账号，请替换你在管理后台应用下申请的Appkey
        $tel = input("telnum");
        $AppKey = 'ad7aedb06f1e4c4002613fe97dfa66da';
        //网易云信分配的账号，请替换你在管理后台应用下申请的appSecret
        $AppSecret = '634811d4abe3';
        Loader::import('ServerAPI', EXTEND_PATH);
        $p = new \ServerAPI($AppKey,$AppSecret,'fsockopen');     //fsockopen伪造请求
        //发送短信验证码
        //{"code":200,"msg":"1","obj":"8831"}
        $res = $p->sendSmsCode('3982558',$tel,'','4');
        if($res["code"]==200){
            session('code',$res["obj"]);
            $data = array("code"=>$res["code"],'msg'=>'发送成功');
            echo json_encode($data);
        }else{
            $data = array("code"=>$res["code"],'msg'=>'发送失败');
            echo json_encode($data);
        }
    }
    //检查手机号码是否注册
    public function ajaxCheckTelnum(){
        $telnum = input('get.telnum');
        $info = $this->memberModel->where("telnum",$telnum)->find();
        if($info){
            echo 0;
        }else{
            echo 200;
        }
    }
    //图片上传
    public function upload($data=null){
        $file = request()->file('face');
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
    //注册
    public function ajaxRegistCheck(){
        $data = input('post.');
        if($data["code"]!=session('code')){
            echo "2_短信验证码不正确";
            return;
        }
        $data['face'] = $this->upload();
        if($this->memberModel->add($data)){
            session('code',null);
            echo "200_注册成功";
        }else{
            echo $this->memberModel->getError();
        }
    }
    public function check_code($email_code){
        if($email_code){
            $info = db('member')->where('email_code',$email_code)->find(); 
            if($info){
                db('member')->where('id',$info['id'])->setField('email_code','');
                $this->redirect('http://www.chendou.com.cn');
            }
        }
    }
    public function ajaxLoginCheck(){
        $data = input('post.');
        if($this->memberModel->login($data)){
            echo "200_".session('member.name')."_".session('member.face')."_".session('member.id');
            //$this->success("登录成功！！！");
        }else{
            echo $this->memberModel->getError();
        }
    }
    public function logout(){
        session('member',null);
        $this->success("退出成功");
    }
}
?>