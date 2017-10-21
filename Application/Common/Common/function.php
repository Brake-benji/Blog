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
    $arr = array();
    $cate = M('Admin_auth_rule');
    $res = $cate->field('id,title,pid')->where('pid = '.$pid)->select();
    $arr = array_merge($arr, $res);
    foreach ($res as $key => $value) {
        $pidArr = getAllChildrenId($value['id']);
        $arr = array_merge($arr, $pidArr);
    }
    return $arr;
}

/*分页*/
function pageInit($total,$count){
    $page = new \Think\Page($total,$count);
    $page->lastSuffix = false;
    $page->rollPage = 1;
    $page->setConfig('prev','上一页');
    $page->setConfig('next','下一页');
    $page->setConfig('first','首页');
    $page->setConfig('last','末页');
    $page->setConfig('theme',' %FIRST% %UP_PAGE% 第%NOW_PAGE%页/共%TOTAL_PAGE%页 %DOWN_PAGE% %END% ');
    return $page;
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