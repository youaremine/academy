<?php
/**
 *
 * @copyright 2007-2013 Xiaoqiang.Wu
 * @author Xiaoqiang.Wu <jamblues@gmail.com>
 * @version 1.01 , 2013-3-27
 */
include_once("../includes/config.inc.php");
$tmp1 = json_decode(file_get_contents('php://input', 'r'), true);
$tmp2 = $_REQUEST;
if (!empty($tmp1)) {//旧版本请求
    $data = $tmp1;
    if (!isset($data['q'])) {
        $data['q'] = $tmp2['q'];
    }
} else {
    $data = $tmp2;
}


switch ($data['q']) {

    case 'add' :
        add($data);
        break;
    case 'update' :
        update($data);
        break;
    case 'delete' :
        delete($data);
        break;
    case 'getlist' :
        getlist($data);
        break;
    default:
        echo "Params Error";
        break;
}



/**
 * 删除比赛
 * */
function delete($data) {
    global  $db;

    $survid = get_survid($data);

    $id = getArrNoNull($data, 'id');

    $sql = "UPDATE Survey_match SET is_del = 1 WHERE id=".$id;

    $res = $db->query($sql);

    $message = array(
        'status' => 'success',
        'msg' => '',
        'data' => []
    );
    die(json_encode($message));
}



/**
 * 查询比赛
 * */
function getlist($data) {
    global  $db;

    $survid = get_survid($data);

    $sql = "SELECT id,s_time,e_time,name,home_team,away_team,ht_avatar,at_avatar,ht_off_players,ht_res_players,ht_score,ht_scorers,at_off_players,at_res_players,at_score,at_scorers,create_time,stadium_place,stadium_pic,can_see_id
 FROM Survey_match where is_del = 0 ";

    $datas = $db->query($sql);
    $all_player_arr = array();//所有全員
    while ($data = mysqli_fetch_assoc($datas)) {
        $arr[] = $data;
    }

    if(!empty($arr)){
        foreach($arr as $one){
            if(!empty($one['can_see_id'])){
                $all_player_arr = array_merge(explode(',',$one['can_see_id']),$all_player_arr);
            }
        }
    }
    if(!empty($all_player_arr)){
        $all_player_arr = array_unique($all_player_arr);
        $all_player_ids = implode(',',$all_player_arr);
    }
    if(!empty($all_player_ids)){
        //查詢所有球員信息
        $all_player_sql = "SELECT survId, chiName,engName,contact FROM Survey_Surveyor where survId in({$all_player_ids})";
        $all_player_datas = $db->query($all_player_sql);
        $players = array();
        while ($all_player = mysqli_fetch_assoc($all_player_datas)) {
            $players[$all_player['survId']] = $all_player;
        }

        foreach($arr as &$onedata){
            if(!empty($onedata['ht_off_players'])){
                $ht_off_players_tmp_arr = explode(',',$onedata['ht_off_players']);
                $onedata['ht_off_players'] = array();

                foreach($ht_off_players_tmp_arr as $one_ht_off_players_tmp_arr){
                    array_push($onedata['ht_off_players'],$players[$one_ht_off_players_tmp_arr]);
                }
            }
            if(!empty($onedata['ht_res_players'])){
                $ht_res_players_tmp_arr = explode(',',$onedata['ht_res_players']);
                $onedata['ht_res_players'] = array();

                foreach($ht_res_players_tmp_arr as $one_ht_res_players_tmp_arr){
                    array_push($onedata['ht_res_players'],$players[$one_ht_res_players_tmp_arr]);
                }
            }
            if(!empty($onedata['at_off_players'])){
                $at_off_players_tmp_arr = explode(',',$onedata['at_off_players']);
                $onedata['at_off_players'] = array();

                foreach($at_off_players_tmp_arr as $one_at_off_players_tmp_arr){
                    array_push($onedata['at_off_players'],$players[$one_at_off_players_tmp_arr]);
                }
            }
            if(!empty($onedata['at_res_players'])){
                $at_res_players_tmp_arr = explode(',',$onedata['at_res_players']);
                $onedata['at_res_players'] = array();

                foreach($at_res_players_tmp_arr as $one_at_res_players_tmp_arr){
                    array_push($onedata['at_res_players'],$players[$one_at_res_players_tmp_arr]);
                }
            }

            if(!empty($onedata['ht_scorers'])){
                $ht_scorers_tmp_arr = explode(',',$onedata['ht_scorers']);
                $onedata['ht_scorers'] = array();

                foreach($ht_scorers_tmp_arr as $one_ht_scorers_tmp_arr){
                    array_push($onedata['ht_scorers'],$players[$one_ht_scorers_tmp_arr]);
                }
            }

            if(!empty($onedata['at_scorers'])){
                $at_scorers_tmp_arr = explode(',',$onedata['at_scorers']);
                $onedata['at_scorers'] = array();

                foreach($at_scorers_tmp_arr as $one_at_scorers_tmp_arr){
                    array_push($onedata['at_scorers'],$players[$one_at_scorers_tmp_arr]);
                }
            }

                $onedata['in_match'] = strpos($onedata['can_see_id'],$survid) !== false?1:0;
            unset($onedata['can_see_id']);
        }

    }


    $message = array(
        'status' => 'success',
        'msg' => '',
        'data' => $arr
    );
    die(json_encode($message));
}


/**
 * 增加比赛
 * */
function add($data) {
    global  $db;

    $survid = get_survid($data);

    $s_time = getArrNoNull($data, 's_time');
    $e_time = getArrNoNull($data, 'e_time');
    $name = getArrNoNull($data, 'name');
    $home_team = getArrNoNull($data, 'home_team');
    $away_team = getArrNoNull($data, 'away_team');

    $ht_avatar = getArrNoNull($data, 'ht_avatar');
    $at_avatar = getArrNoNull($data, 'at_avatar');
    $ht_off_players = array_key_exists('ht_off_players',$data)?$data['ht_off_players']:'';
    $ht_res_players = array_key_exists('ht_res_players',$data)?$data['ht_res_players']:'';
    $ht_score = array_key_exists('ht_score',$data)?$data['ht_score']:'';
    $ht_scorers = array_key_exists('ht_scorers',$data)?$data['ht_scorers']:'';
    $at_off_players = array_key_exists('at_off_players',$data)?$data['at_off_players']:'';
    $at_res_players = array_key_exists('at_res_players',$data)?$data['at_res_players']:'';
    $at_score = array_key_exists('at_score',$data)?$data['at_score']:'';
    $at_scorers = array_key_exists('at_scorers',$data)?$data['at_scorers']:'';
    $stadium_place = getArrNoNull($data, 'stadium_place');
    $stadium_pic = array_key_exists('stadium_pic',$data)?$data['stadium_pic']:'';
    $create_time = date('Y-m-d H:i:s');

    $can_see_id = '';
    $ht_off_players_arr = array();
    $ht_res_players_arr = array();
    $at_off_players_arr = array();
    $at_res_players_arr = array();

    if(!empty($ht_off_players)){
        $ht_off_players_arr = explode(',',$ht_off_players);
    }

    if(!empty($ht_res_players)){
        $ht_res_players_arr = explode(',',$ht_res_players);
    }

    if(!empty($at_off_players)){
        $at_off_players_arr = explode(',',$at_off_players);
    }

    if(!empty($at_res_players)){
        $at_res_players_arr = explode(',',$at_res_players);
    }
    $can_see_id_arr = array_merge($ht_off_players_arr,$ht_res_players_arr,$at_off_players_arr,$at_res_players_arr);
    if(!empty($can_see_id_arr)){
        $can_see_id_arr = array_unique($can_see_id_arr);
        $can_see_id = implode(',',$can_see_id_arr);
    }



    $sql = "INSERT into Survey_match(s_time,e_time,name,home_team,away_team,ht_avatar,at_avatar,ht_off_players,ht_res_players,ht_score,ht_scorers,at_off_players,at_res_players,at_score,at_scorers,create_time,create_id,can_see_id,stadium_place,stadium_pic)
 values ('$s_time','$e_time','$name','$home_team','$away_team','$ht_avatar','$at_avatar','$ht_off_players','$ht_res_players','$ht_score','$ht_scorers','$at_off_players','$at_res_players','$at_score','$at_scorers','$create_time','$survid','$can_see_id','$stadium_place','$stadium_pic')";
    $res = $db->query($sql);



    if($res){
        $message = array(
            'status' => 'success',
            'msg' => '',
            'data' => []
        );
        die(json_encode($message));
    }


}



/**
 * 修改比赛
 * */
function update($data) {
    global  $db;

    $survid = get_survid($data);

    $id = getArrNoNull($data, 'id');

    $can_see_id = '';
    $ht_off_players_arr = array();
    $ht_res_players_arr = array();
    $at_off_players_arr = array();
    $at_res_players_arr = array();

    if(!empty($data['ht_off_players'])){
        $ht_off_players_arr = explode(',',$data['ht_off_players']);
    }

    if(!empty($data['ht_res_players'])){
        $ht_res_players_arr = explode(',',$data['ht_res_players']);
    }

    if(!empty($data['at_off_players'])){
        $at_off_players_arr = explode(',',$data['at_off_players']);
    }

    if(!empty($data['at_res_players'])){
        $at_res_players_arr = explode(',',$data['at_res_players']);
    }
    $can_see_id_arr = array_merge($ht_off_players_arr,$ht_res_players_arr,$at_off_players_arr,$at_res_players_arr);
    if(!empty($can_see_id_arr)){
        $can_see_id_arr = array_unique($can_see_id_arr);
        $can_see_id = implode(',',$can_see_id_arr);
    }

    $sql_arr['s_time'] = $data['s_time'];
    $sql_arr['e_time'] = $data['e_time'];
    $sql_arr['name'] = $data['name'];
    $sql_arr['home_team'] = $data['home_team'];
    $sql_arr['away_team'] = $data['away_team'];
    $sql_arr['ht_avatar'] = $data['ht_avatar'];
    $sql_arr['at_avatar'] = $data['at_avatar'];
    $sql_arr['ht_off_players'] = $data['ht_off_players'];
    $sql_arr['ht_res_players'] = $data['ht_res_players'];
    $sql_arr['ht_score'] = $data['ht_score'];
    $sql_arr['ht_scorers'] = $data['ht_scorers'];

    $sql_arr['at_off_players'] = $data['at_off_players'];
    $sql_arr['at_res_players'] = $data['at_res_players'];
    $sql_arr['at_score'] = $data['at_score'];
    $sql_arr['at_scorers'] = $data['at_scorers'];
    $sql_arr['update_time'] = date('Y-m-d H:i:s');

    $sql_arr['stadium_pic'] = $data['stadium_pic'];
    $sql_arr['stadium_place'] = $data['stadium_place'];
    $sql_arr['can_see_id'] = $can_see_id;







    $query = makeSql($sql_arr,'update');
    $sql = "UPDATE Survey_match SET " .$query . "WHERE id=".$id;

    $res = $db->query($sql);

    $message = array(
        'status' => 'success',
        'msg' => '',
        'data' => []
    );
    die(json_encode($message));
}



function get_survid($data){
    global $conf;
    if (empty($data['sign'])) {
        $message = array(
            'status' => 'failed',
            'msg' => 'sign is null.',
            'data' => array()
        );
        die(json_encode($message));
    }
    $filename = $conf["path"]["sign"] . $data['sign'];
    $survId = file_get_contents($filename);

    if (empty($survId)) {
        $message = array(
            'status' => 'failed',
            'msg' => 'Login has expired.',
            'data' => array()
        );
        die(json_encode($message));
    }
    return $survId;
}


function getArrNoNull($arr, $field) {
    if (isset($arr[$field])) {
        return $arr[$field];
    } else {
        $message = array(
            'status' => 'failed',
            'msg' => $field . ' is required',
            'data' => array()
        );
        die(json_encode($message));
    }
}


function returnJson($status = 'success', $data = '', $msg = '', $other = '') {

    if (!empty($other)) {
        $message = array(
            'status' => $status,
            'msg' => $msg,
            'data' => $data,
            'other' => $other
        );
        die(json_encode($message));
    }
    $message = array(
        'status' => $status,
        'msg' => $msg,
        'data' => $data
    );
    die(json_encode($message));
}