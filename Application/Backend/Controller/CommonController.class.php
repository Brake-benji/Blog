<?php
namespace Backend\Controller;
use Think\Controller;
use Think\Auth;

class CommonController extends Controller {
    
    var $obj_data;
    
    /**
     * 构造函数
     * @author luduoliang <luduoliang@imohoo.com> (2016/12/01)
     */
    public function __construct()
    {
        parent::__construct();
        $user_info = session('user_info');
        if(!$user_info['id']){
            $this->redirect('Login/login');
        }
        

            $name = CONTROLLER_NAME . '/' . ACTION_NAME;
            if(CONTROLLER_NAME != 'Index'){
            
            $auth = new Auth();
            $auth_result = $auth->check($name, $user_info['id']);
            if($auth_result === false){
                if(IS_AJAX){
                    $this->ajaxError('没有权限!');
                }else{
                    $this->error('没有权限!');
                }
                
            } 
        } 
    }
    /**
     * @description:错误返回
     * @author wuyanwen(2016年11月22日)
     * @param string $msg
     * @param unknown $fields
     */
    protected function ajaxError($msg='', $fields=array())
    {
        header('Content-Type:application/json; charset=utf-8');
        $data = array('status'=>'error', 'msg'=>$msg, 'fields'=>$fields);
        echo json_encode($data);
        exit;
    }
    
    protected function ajaxSuccess($msg, $_data=array())
    {
        header('Content-Type:application/json; charset=utf-8');
        $data = array('status'=>'success', 'msg' => $msg ,'data'=>$_data);
        echo json_encode($data);
        exit;
    }

    /**
     * 统一数据交互方法
     * @param  [type] $type 回复类型
     * @param  [type] $code 错误码
     * @param  [type] $msg  提示信息
     * @return [type]       
     */
    public function app_echodata($type,$code,$msg)
    {
        $result = array();
        $result['state']    = true;
        $result['code']     = '000000';
        $result['msg']  = empty($msg)?"":$msg;
        $result['result']   = $this->obj_data;
        if (!empty($code)) {
            $result['state']        = false;
            $result['code']         = $code;
            $result['result']       = null;
            if (isset($msg)) {
                $result['msg']  = $msg;
            }
        }

        if ($this->getResult) {
            if ($result['state'] === false) {
                return $result;
            }else{
                return $this->obj_data;
            }
        }
        
        switch ($type) {
            //10001返回json数据
            case 10001:
                echo $_GET['callback'].json_encode($result);
                break;
            //10002返回字符串
            case 10002:
                echo $_GET['callback'].'"'.$this->obj_data.'"';
                break;
            //10003返回带回调的对象格式
            case 10003:
                echo $_GET['callback'].$this->obj_data;
                break;
            //10004返回无回调json对象数据
            case 10004:
                echo json_encode($this->obj_data);
                break;
            //10005直接返回对象，无回调
            case 10005:
                return $this->obj_data;
                break;
        }
        exit;
    }

    /**
     * 
     * 获取用户登录信息
     * @return [type] [description]
     */
    public function getUserinfo()
    {
        $userinfo = session('user_info');
        if (!$userinfo) {
            $this->app_echodata(10001,'000009','请先登录');
        }else{
            $uinfo = array(
                'uid' => $userinfo['id'],
                'nickname' => $userinfo['user_name'],
                'logintime' => $userinfo['lastlogin_time']
                );
            return $uinfo;
        }
    }
}