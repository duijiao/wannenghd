

<?php
header('Content-type:text/json;charset=utf-8');
require "../data/config.php";
//  require '../config.php';
//  $user=$_REQUEST['user'];
//  $pass=$_REQUEST['pass'];
//  $appid=$_REQUEST['appid'];
 // $type=$_REQUEST['type'];
  $value=$_REQUEST['value'];
  $number=$_REQUEST['number'];
  $key=$_REQUEST['key'];
  if($value==''||$number==''){
    $array=[
      'code'=>'-1',
      'msg'=>'参数不完整'
    ];
    echo json_encode($array);
  }
  else{
    if(is_numeric($value)){
      if(is_numeric($number)){
        if($number>50){
          $array=[
            'code'=>'-1',
            'msg'=>'一次添加不可超过50张卡密'
          ];
          echo json_encode($array);
        }
        else{

                      //数组
                      function randomkeys($length) 
                      { 
                         $pattern = '1234567890ZXCVBNMASDFGHJKLQWERTYUIOP';
                         for($i=0;$i<$length;$i++) 
                         { 
                            $key .= $pattern{mt_rand(0,35)}; //生成php随机数 
                         } 
                         return $key; 
                      }
                      $kmsj=$appid.'km'; 
                    //  $data=date('Y-m-d H:i:s');
                      $data=date('Y-m-d',strtotime("+'$value' day"));
                      $msg='创建'.$number.'张卡密成功';
                      for($i=0;$i<$number;$i++){
                         $kmcz='true';

                         $sqls="insert into app_kami (kami,cs,time) values ('$km','false','$data')";
                         $fs = mysqli_query($con, $sqls);
                         $array=json_encode(array('dense'=>$km));
                         $list = $array . ',' . $list;
                      }
                      $list1='['.substr($list,0,-1).']';
                      $list2=json_decode($list1,true);
                      $datb=array(
                       'code'=>'1',
                       'msg'=>$msg,
                       'list'=>$list2
                      );
                      echo json_encode($datb);
                    }

      else{
        $array=[
          'code'=>'-1',
          'msg'=>'生成数量只能是数字'
        ];
        echo json_encode($array);
      }
    }
    else{
      $array=[
        'code'=>'-1',
        'msg'=>'卡密额度只能是数字'
      ];
      echo json_encode($array);
    }
  }
?>