<?php
/**
 * Widget扩展
 */
namespace Home\Widget;
use Think\Controller;

class CateWidget extends Controller{
    //头部信息
    public function header(){
       /* $menu = D('AdminMenu');
        $id = array('46','47','48','49','50','52','53');
        $allCategory = $menu->getMenus($id);  //获取分类
        //dump($allCategory);die;
        $allTag = M('tag')->field('id,tagname')->order('nums DESC')->select();
        $clist = get_column($allCategory);*/

        //$res = getAllChildrenId('46');
        $map['id'] = array('in',array('46','47','48','49','50','52','53'));
        $res = M('admin_auth_rule')->field('id,title,pid')->where($map)->select();
        $arr = $this->ForLevel($res);
        //dump($arr);die;
        $this->assign('cate_list',$arr);
        $this->display('Widget:header');
    }
    
    //右边导航栏,置顶，推荐，文章分类
    public function right(){
        //活动列表
        $activity = M('activity')->field('slogan,linkurl,filepath')->where("is_valid = 'y'")->order('priority DESC')->select();
        //热门文章
        $hotList =  M('article a')->field('a.id,a.title,a.readcounts,b.user_name as nickname,c.title as catename')->where("is_valid = 'y'")->join("LEFT JOIN admin_user b ON a.uid = b.id")->join("LEFT JOIN admin_auth_rule c ON a.cid = c.id")->order('a.readcounts DESC')->limit(10)->select();
        //标签云
        $tagList = M()->query("select a.id,a.tagname,a.createtime,count(b.tid) as count,c.nick_name as nickname from tag a left join article_tag_relate b on a.id = b.tid left join admin_user c on a.uid = c.id  group by id order by count desc");
        $this->assign('activity_list',$activity);
        $this->assign('hot_list',$hotList);
        $this->assign("tag_list",$tagList);
        $this->display('Widget:right');
    }
    
    //脚注信息
    public function footer(){
        $res = M('links')->field("linkname,linkurl")->where("is_valid = 'y'")->order('createtime DESC')->limit(5)->select();
        $this->assign('link_list',$res);
        $this->display('Widget:footer');
    }

    public function ForLevel($data,$pid = 0){
     	$arr = array();
     	foreach ($data as $v){
            if($v['pid']==$pid){
                $v['son']=$this->ForLevel($data,$v['id']); 
    	        $arr[]=$v;
            }
    	}
    	return $arr;
    }
}