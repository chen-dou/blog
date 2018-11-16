<?php
namespace app\index\model;
use think\Model;
class Comment extends Model{
    public function add($data){
        $data['time'] = time();
        $data['member_id'] = session('member.id');
        $validate = validate('Comment');
        if($validate->check($data)){
            if($this->save($data)){
                return true;
            }else{
                $this->error="发表评论失败！！！";
                return false;
            }
        }else{
            $this->error = $validate->getError();
            return false;
        }  
    }
}
?>