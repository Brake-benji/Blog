<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
    	//获取来源访问ip地址
    	$ip = get_client_ip();
    	
    	if (!$ip) {
    		$data['ip_address'] = $ip;
    		$data['addtime'] = time();
    		$data['record_id'] = '0';
    		$addIp = M('guest')->data($data)->add();
    	}

    	$count = M('article')->where("is_valid = 'y'")->count();
    	$page = new \Think\Page($count,5);
        $page->lastSuffix = false;
        $page->rollPage = 1;
        $page->setConfig('prev','上一页');
        $page->setConfig('next','下一页');
        $page->setConfig('first','首页');
        $page->setConfig('last','末页');
        $page->setConfig('theme',' %FIRST% %UP_PAGE% 第%NOW_PAGE%页/共%TOTAL_PAGE%页 %DOWN_PAGE% %END% ');
    	$show = $page->show();

    	//先读缓存
    	/*$cache = S('article_list');
    	if($cache){
    		$articleList = S('article_list');
    	}else{
    		$articleList = M('article a')->field('a.*,b.user_name as nickname,c.title as catename')->where("is_valid = 'y'")->join("LEFT JOIN admin_user b ON a.uid = b.id")->join("LEFT JOIN admin_auth_rule c ON a.cid = c.id")->order('a.createtime DESC')->limit($page->firstRow,$page->listRows)->select();
    		S('article_list',$articleList,1000);
    	}*/
        $articleList = M('article a')->field('a.*,b.user_name as nickname,c.title as catename')->where("is_valid = 'y'")->join("LEFT JOIN admin_user b ON a.uid = b.id")->join("LEFT JOIN admin_auth_rule c ON a.cid = c.id")->order('a.createtime DESC')->limit($page->firstRow,$page->listRows)->select();
    	$title = "青椒白饭Mr.Xie的个人博客";
    	$this->assign('title',$title);
    	$this->assign('page',$show);
    	$this->assign('articlelist',$articleList);
        $this->display();
    }

    public function detail(){
    	$id = I('id');
    	if (empty($id)) {
    		ajaxError("该文章不存在");
    	}
    
    	$res = M('article a')->field('a.*,b.user_name as nickname,c.title as catename')->where("is_valid = 'y' and a.id =".$id)->join("LEFT JOIN admin_user b ON a.uid = b.id")->join("LEFT JOIN admin_auth_rule c ON a.cid = c.id")->find();
        $allTag = M()->query("select tagname from article_tag_relate a left join tag b on a.tid = b.id where a.aid = ".$id);
        $res['tag'] = implode(",",array_column($allTag, "tagname"));
    	if (empty($res)) {
    		ajaxError("该文章不存在");
    	}

        //更新阅读量
        $data['readcounts']= $res['readcounts'] + 1;
        $updateCounts = M('article')->where('id ='.$id)->data($data)->save();
        //更新操作记录id
        $data['ip_address'] = $_SERVER['REMOTE_ADDR'];
        $data['addtime'] = time();
        $data['record_id'] = $id;
        $addIp = M('guest')->data($data)->add();
        
    	$this->assign('res',$res);
        $this->assign('content',htmlspecialchars_decode($res['content']));
    	$this->display();
    }

    public function search(){
    	$keyword = I('keyword');
    	if (empty($keyword)) {
    		ajaxError("关键词不能为空");
    	}

    	$map['a.title'] = array('like',array("%".$keyword."%","%".$keyword),'OR');
        $total = M('article a')->where($map)->count();
        $page = new \Think\Page($total,5);
        $page->lastSuffix = false;
        $page->rollPage = 1;
        $page->setConfig('prev','上一页');
        $page->setConfig('next','下一页');
        $page->setConfig('first','首页');
        $page->setConfig('last','末页');
        $page->setConfig('theme',' %FIRST% %UP_PAGE% 第%NOW_PAGE%页/共%TOTAL_PAGE%页 %DOWN_PAGE% %END% ');
        $show = $page->show();
    	$res = M('article a')->field('a.*,b.user_name as nickname,c.title as catename')->where($map)->join("LEFT JOIN admin_user b ON a.uid = b.id")->join("LEFT JOIN admin_auth_rule c ON a.cid = c.id")->order('a.createtime DESC,a.readcounts DESC')->limit($page->firstRow,$page->listRows)->select();
        //dump($res);die;
        if (empty($res)) {
    		$this->ajaxReturn(array('status' => "error",'msg' => '查询结果为空~'));
    	}else{
            if (IS_AJAX) {
                $this->ajaxReturn(array('status' => "true",'msg' => '查询结果如下'));
            }
        	$this->assign("keyword_res",$res);
        	$this->assign("page",$show);
        	$this->display();
        }
    }


    /**
     * 添加留言信息
     */
    public function addMessage(){
        if (IS_POST) {
            $data['contact'] = I('contact');
            $data['content'] = I('content');
            $data['addtime'] = time();
            if (empty($data['contact']) || empty($data['content'])) {
                $this->ajaxReturn(array('status' => "error",'msg' => "联系方式或者留言内容不能为空"));
            }

            $res = M('message')->data($data)->add();
            if (!$res) {
                $this->ajaxReturn(array('status' => "error",'msg' => "留言失败请重试~"));
            }
            $this->ajaxReturn(array('status' => "true",'msg' => "留言成功!感谢您"));
        }else{
            $this->display();
        }
    }

    /**
     * 分类文章
     */
    public function category(){
        $cid = I('cid');
        if (empty($cid)) {
            $this->error("此分类不存在");
        }

        $allCid = M('admin_auth_rule')->field('id,pid,title')->where('id = '.$cid.' OR pid ='.$cid)->select();
        $idList = implode(',',array_column($allCid, 'id'));
        //dump($idList);die;
        //var_dump($allCid);die;

        $map['cid'] = array('in',$idList);
        $total = M('article')->where($map)->count();
        $page = new \Think\Page($total,10);
        $show = $page->show();
        $res = M('article a')->field('a.*,b.user_name as nickname,c.title as catename')->where($map)->join("LEFT JOIN admin_user b ON a.uid = b.id")->join("LEFT JOIN admin_auth_rule c ON a.cid = c.id")->order('a.createtime DESC,a.readcounts DESC')->limit($page->firstRow,$page->listRows)->select();
        if (empty($res)) {
            $this->error("该分类下暂无文章~");
        }else{
            $this->assign('cate_list',$res);
            $this->assign('page',$show);
            $this->display();
        }

    }

    /**
     * 获取标签下的所有文章
     */
    public function tagcate(){
        $tid = I('tagid');
        $findTid = M('tag')->where('id ='.$tid)->find();
        if(empty($tid) || empty($findTid)){
            $this->error("此标签不存在");
        }
        $total = M('article_tag_relate')->where("tid =".$tid)->count();
        $page = new \Think\Page($total,5);
        $page->lastSuffix = false;
        $page->rollPage = 1;
        $page->setConfig('prev','上一页');
        $page->setConfig('next','下一页');
        $page->setConfig('first','首页');
        $page->setConfig('last','末页');
        $page->setConfig('theme',' %FIRST% %UP_PAGE% 第%NOW_PAGE%页/共%TOTAL_PAGE%页 %DOWN_PAGE% %END% ');
        $show = $page->show();
        $res = M()->query("select a.aid,a.tid,b.*,c.user_name as nickname,d.title as catename,e.tagname from article_tag_relate a left join article b on a.aid = b.id left join admin_user c on b.uid = c.id left join admin_auth_rule d on b.cid = d.id left join tag e on a.tid = e.id where a.tid = ".$tid." order by b.readcounts desc limit ".$page->firstRow.",".$page->listRows);
        if (empty($res)) {
            $this->error("该分类下暂无文章~");
        }else{
            $this->assign('cate_list',$res);
            $this->assign('page',$show);
            $this->display();
        }
    }

    /**
     * 获取所有活动列表
     * @return [type] [description]
     */
    public function getActivityList(){
        $res = M('Activity')->field('id,uid,slogan,linkurl,filepath')->where("is_valid = 'y'")->order('createtime DESC')->limit(5)->select();
        if(!$res){
            $this->ajaxReturn(array('status' => "error",'msg' => '暂无活动哦~'));
        }else{
            $this->ajaxReturn(array('status' => "true",'msg' => '活动列表如下','result' => $res));
        }
    }

    public function test(){
        
    }


}