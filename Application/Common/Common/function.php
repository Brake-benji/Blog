<?php
/**
 * description: 递归菜单
 * @param unknown $array
 * @param number $fid
 * @param number $level
 * @param number $type 1:顺序菜单 2树状菜单
 * @return multitype:number
 */
function get_column($array,$type=1,$fid=0,$level=0)
{
    $column = [];
    if($type == 2)
        foreach($array as $key => $vo){
        if($vo['pid'] == $fid){
            $vo['level'] = $level;
            $column[$key] = $vo;
            $column [$key][$vo['id']] = get_column($array,$type=2,$vo['id'],$level+1);
        }
    }else{
        foreach($array as $key => $vo){
            if($vo['pid'] == $fid){
                $vo['level'] = $level;
                $column[] = $vo;
                $column = array_merge($column, get_column($array,$type=1,$vo['id'],$level+1));
            }
        }
    }
    
    return $column;
}


function getAllChildrenId($pid){
    //var_dump($pid);die;
    $arr = array();
    $cate = M('Admin_auth_rule');
    $res = $cate->field('id,title,pid')->where('pid = '.$pid)->select();
    //var_dump($res);

    //if ($res) {
        foreach ($res as $key => $value) {
            //var_dump($value['id']);
            $pidArr = getAllChildrenId($value['id']);
            //var_dump($pidArr);die;
            $arr = array_merge($res, $pidArr);
            var_dump($arr);die;
        }
        
    //}
    var_dump($arr);die;
    return $arr;
}

function ajaxError($msg='', $fields=array())
{
    //header('Content-Type:application/json; charset=utf-8');
    $data = array('status'=>error, 'msg'=>$msg, 'fields'=>$fields);
    return json_encode($data);
}
    
function ajaxSuccess($msg, $_data=array())
{
    //header('Content-Type:application/json; charset=utf-8');
    $data = array('status'=>true, 'msg' => $msg ,'result'=>$_data);
    return json_encode($data);
}