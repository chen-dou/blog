<?php
namespace app\index\model;
use think\Model;
class Reply extends Model{
    public function add($data){
        $data['time'] = time();
        $data['member_id'] = session('member.id');
        $validate = validate('Reply');
        if($validate->check($data)){
            if($this->save($data)){
                return true;
            }else{
                $this->error="发表回复失败！！！";
                return false;
            }
        }else{
            $this->error = $validate->getError();
            return false;
        }  
    }
    public function getTree($where){
        $sql = "SELECT a.*,b.`name` toname FROM (SELECT r.*, m.`name`,m.face FROM blog_reply r,blog_member m WHERE r.member_id = m.id) a,(SELECT r.*, m.`name` FROM blog_reply r,blog_member m WHERE r.to_member_id = m.id) b WHERE a.id = b.id and a.comment_id={$where} order by time desc";
        $data = $this->query($sql);
        return $this->_getTree($data);
    }
    public function _getTree($data,$pid=0,$level=0){
        $arr = array();
        foreach($data as $k=>$v){
            if($v['pid']==$pid){
                $v['level'] = $level;
                $arr[] = $v;
                $arr = array_merge($arr,$this->_getTree($data,$v['id'],$level+1));
            }
        }
        return $arr;
    }
}
?>