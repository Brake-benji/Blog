<?php

namespace Backend\Controller;

class OtherController extends CommonController{

	/**
	 * 广告方法
	 * @return [type] [description]
	 */
	public function index(){
		$userinfo = $this->getUserinfo();
		if (!$userinfo) {
			$this->ajaxError("尚未登录~");
		}
		$total = M('Activity')->count();
		$page = new \Think\Page($total,5);
		$page->lastSuffix = false;
        $page->rollPage = 1;
        $page->setConfig('prev','上一页');
        $page->setConfig('next','下一页');
        $page->setConfig('first','首页');
        $page->setConfig('last','末页');
        $page->setConfig('theme',' %FIRST% %UP_PAGE% 第%NOW_PAGE%页/共%TOTAL_PAGE%页 %DOWN_PAGE% %END% ');
		$show = $page->show();
		$ad = M('Activity a');
		$res = $ad->field('a.*,b.user_name as nickname')
				  ->join("LEFT JOIN admin_user b ON a.uid = b.id")
				  ->order('priority,createtime desc')
				  ->limit($page->firstRow.",".$page->listRows)
				  ->select();
	    $this->assign('page',$show);
		$this->assign('list',$res);
		$this->display();
	}

	/**
	 * 图片上传，返回图片地址
	 */
	public function saveImage(){
		$userinfo = $this->getUserinfo();
		$config = array(
		    'maxSize'    =>    3145728,
		    'rootPath'   =>    './Public/upload/Activity/',
		    'savePath'   =>    '',
		    'saveName'   =>    time().'_'.$userinfo['uid'],
		    'exts'       =>    array('jpg', 'gif', 'png', 'jpeg'),
		    'autoSub'    =>    true,
		    'subName'    =>    array('date','Ymd'),
		);
		if (!is_dir($config['rootPath'])) {
			mkdir($config['rootPath'],0777);
		}
		$upload = new \Think\Upload($config);
		$info = $upload->upload();
		if(!$info){
			$this->ajaxError($upload->getError());
		}
		$image = new \Think\Image();
		foreach ($info as $file){
                $image->open('./Public/upload/Activity/'.$file['savepath'].$file['savename']);
                $image->thumb(650,300,\Think\image::IMAGE_THUMB_CENTER)->save('./Public/upload/Activity/'.$file['savepath']."thumb".$file['savename']);  //生成缩略图
            }
        $thumb = '/Public/upload/Activity/'.$file['savepath']."thumb".$file['savename'];
		$this->ajaxSuccess("上传成功",$thumb);
		
	}
	

	/**
	 * 发布广告
	 * @return [type] [description]
	 */
	public function releaseAd(){
		$userinfo = $this->getUserinfo();
		if (!$userinfo) {
			$this->ajaxError("请先登录");
		}
		if(IS_POST){
			$adfile = I('adfile');
			$slogan = I('slogan');
			$comment = I('comment');
			$linkUrl = I('url');
			$priority = I('priority');
			if (empty($adfile) || empty($slogan) || empty($comment) || !is_numeric($priority)) {
				$this->ajaxError("表单项不能为空！");
			}
			
			$ad = M('Activity');
			$data['uid'] = $userinfo['uid'];
			$data['slogan']  = $slogan;
			$data['comment'] = $comment;
			$data['linkurl'] = $linkUrl;
			$data['filepath'] = $adfile;
			$data['createtime'] = time();
			$data['priority'] = $priority;
			$data['is_valid'] = 'n';
			$res = $ad->data($data)->add();
			if ($res) {
				$this->ajaxSuccess("发布成功！");
			}else{
				$this->ajaxError("活动发布失败，请重试");
			}
		}else{
			$this->display();
		}
		
	}

	/**
	 * 更改发布状态，发布活动
	 */
	public function changeStatus(){
		$id = I('id','','intval');
		$res = M('Activity')->where("id =".$id." and is_valid='n'")->find();
		if ($res) {
			$data['is_valid'] = 'y';
			$update = M('Activity')->where("id =".$id)->data($data)->save();
			if(!$update){
				$this->ajaxError("发布活动失败！");
			}
			$this->ajaxSuccess("活动发布成功！");
		}else{
			$this->ajaxError("此活动不存在！");
		}
	}

	/**
	 * 删除广告
	 * @return [type] [description]
	 */
	public function delAd(){
		$id = I('id');
		$res = M('Activity')->where("id =".$id." and is_valid = 'y'")->find();
		if($res){
			$data['is_valid'] = 'n';
			$del = M('Activity')->where("id =".$id)->data($data)->save();
			if ($del) {
				$this->ajaxSuccess("删除活动成功！");
			}else{
				$this->ajaxError("删除广告失败，请重试！");
			}
		}else{
			$this->ajaxError("此条广告不存在！");
		}
	}

	/**
	 * 修改活动信息
	 * @return [type] [description]
	 */
	public function editAd(){
		$id = I('id');
		$slogan = I('slogan');
		$comment = I('comment');
		$url = I('url');
		$filepath = I('adfile');
		$priority = I('priority');
		$res = M('Activity')->where("id =".$id)->find();
		if(!$res){
			$this->ajaxError("此活动不存在！");
		}
		if(IS_POST){
			if (empty($slogan) || empty($comment) || !is_numeric($priority)) {
				$this->ajaxError("表单项不能为空！");
			}
			//类型不为空，接收修改数据
			$data['slogan'] = $slogan;
			$data['comment'] = $comment;
			$data['linkurl'] = $url;
			if (!empty($filepath)) {
				$data['filepath'] = $filepath;
			}
			$data['priority'] = $priority;
			$data['is_valid'] = 'n';

			$update = M('Activity')->where("id =".$id)->data($data)->save();
			if (!$update) {
					$this->ajaxError("修改活动数据失败！");
				}else{
					$this->ajaxSuccess("修改成功！");
				}

		}else{
			//类型为空，展示页面
			$this->assign('adinfo',$res);
			$this->display();
		}
	}

	/**
	 * 友情链接
	 * @return 
	 */
	public function links(){
		$links = M("links a");
		$total = $links->count();
		$page = new \Think\Page($total,20);
		$show = $page->show();
		$res = $links->field("a.*,b.user_name as nickname")->where("is_valid = 'y'")->join("LEFT JOIN admin_user b ON a.uid = b.id")->order("createtime DESC")->select();
		$this->assign("page",$show);
		$this->assign("list",$res);
		$this->display();
	}

	/**
	 * 添加友情链接
	 */
	public function addLinks(){
		if (IS_POST) {
			$linkName = I('linkname');
			$linkUrl = I('linkurl');
			if (empty($linkName) || empty($linkUrl)) {
				$this->ajaxError("表单项不能为空");
			}
			$userinfo = $this->getUserinfo();
			if (!$userinfo) {
				$this->ajaxError("尚未登录，不能添加友情链接");
			}
		
			if (strstr($linkUrl, 'http')) {
				$data['uid'] = $userinfo['uid'];
				$data['linkname'] = $linkName;
				$data['linkurl'] = $linkUrl;
				$data['createtime'] = time();
				$data['is_valid'] = 'y';
				$res = M('links')->data($data)->add();
				if ($res) {
					$this->ajaxSuccess("友情链接添加成功");
				}else{
					$this->ajaxError("友情链接添加失败");
				}
			}else{
				$this->ajaxError("链接不合法，应以http开头");
			}
		}else{
			$this->display();
		}
		
	}

	/**
	 * 修改友情链接
	 * 
	 */
	public function editLinks(){
		
		$id = I('id');
		if (IS_POST) {
			$linkName = I('linkname');
			$linkUrl = I('url');
			$res = M('links')->where("id =".$id)->find();
			if (!$res || empty($linkName) || empty($linkUrl)) {
				$this->ajaxError("链接不存在或表单项为空");
			}

			if (preg_match("/^http:/", $linkUrl)) {
				$data['linkname'] = $linkName;
				$data['linkurl'] = $linkUrl;
				$update = M('links')->where('id ='.$id)->data($data)->save();
				if (!$update) {
					$this->ajaxError("更新友情链接失败");
				}
				$this->ajaxSuccess("友情链接修改成功");
			}else{
				$this->ajaxError("链接格式有误");
			}
		}else{
			$detail = M('links')->where("id =".$id." and is_valid = 'y'")->find();
			$this->assign("link",$detail);
			$this->display();
		}
	}

	/**
	 * 删除友情链接
	 * @return [type] [description]
	 */
	public function delLinks(){
		$id = I('id');
		$res = M('links')->where("id =".$id." and is_valid = 'y'")->find();
		if (!$res) {
			$this->ajaxError("此链接不存在");
		}else{
			$data['is_valid'] = 'n';
			$update = M('links')->where("id =".$id)->data($data)->save();
			if (!$update) {
				$this->ajaxError("友情链接删除失败");
			}
			$this->ajaxSuccess("友情链接删除成功");
		}
	}

	/**
	 *
	 * 查看访客信息
	 */
	public function guestHistory(){
		$total = M('guest')->count();
		$page = new \Think\Page($total,30);
		$page->lastSuffix = false;
        $page->rollPage = 1;
        $page->setConfig('prev','上一页');
        $page->setConfig('next','下一页');
        $page->setConfig('first','首页');
        $page->setConfig('last','末页');
        $page->setConfig('theme',' %FIRST% %UP_PAGE% 第%NOW_PAGE%页/共%TOTAL_PAGE%页 %DOWN_PAGE% %END% ');
		$show = $page->show();
		$res = M('guest a')->field('a.*,b.title')->join('LEFT JOIN article b ON a.record_id = b.id')->limit($page->firstRow,$page->listRows)->order("addtime DESC")->select();
		$this->assign('guest_list',$res);
		$this->assign('page',$show);
		$this->display();
	}

	/**
	 *
	 * 查看留言信息
	 */
	public function showMessage(){
		$total = M('message')->count();
		$page = new \Think\Page($total,10);
		$show = $page->show();
		$res = M('message')->limit($page->firstRow,$page->listRows)->order('addtime DESC')->select();
		$this->assign('message_list',$res);
		$this->assign('page',$show);
		$this->display();
	}

}