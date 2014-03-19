<?php

error_reporting(E_ALL);
#session_start();
require_once("db_connection.php");
require_once("lib/nusoap.php");

$ns = "http://arif04cuet.my.phpcloud.com/nusoap";

$server = new soap_server();
$server->configureWSDL('TimeTrackerService', $ns, '', 'document');
$server->wsdl->schemaTargetNamespace = $ns;


$server->register('authenticate', array(
    'username' => 'xsd:string',
    'password' => 'xsd:string'
	), array('return' => 'xsd:string'), $ns);

$server->register('pressStart', array(
    'token' => 'xsd:string',
    'project_id' => 'xsd:int',
    'memo' => 'xsd:string',
	), array('return' => 'xsd:string'), $ns);

$server->register('saveTimeSlot', array(
    'token' => 'xsd:string',
    'image' => 'xsd:string'
	), array('return' => 'xsd:string'), $ns);

$server->register('pressStop', array(
    'token' => 'xsd:string',
	), array('return' => 'xsd:string'), $ns);

$server->register('logout', array(
    'token' => 'xsd:string',
	), array('return' => 'xsd:string'), $ns);

//soap function list
function authenticate($username, $password)
{
    $password = md5($password);
    $sql = "select * from users where username='" . $username . "' and password='" . $password . "' and user_type=3 and status=1 limit 1";
    $result = mysql_query($sql);
    $count = mysql_num_rows($result);
    $data = "0";
    if ($count)
    {
	$developer = mysql_fetch_object($result);
	#$_SESSION['developer'] = $developer;
	#get/set Token object
	$sessionToken = uniqid("", true);
	$sql = "insert into token (developer_id,sessionToken) values($developer->id,'" . $sessionToken . "')";
	mysql_query($sql) or die(mysql_error());
	#get clients of this developer
	$sql = "select c.id,c.name,c.username from users as c inner join clients_developers as cd on(cd.client_id = c.id) where cd.developer_id=$developer->id";
	$c_result = mysql_query($sql) or die(mysql_error());
	$clients = mysql_num_rows($c_result);
	$str = "";
	if (count($clients))
	{
	    while ($client = mysql_fetch_object($c_result))
	    {
		#buyers
		$str.='|' . $client->id . ':' . $client->username;
		$sql = "select p.id,p.title from projects as p inner join projects_developers as pd on(p.id = pd.project_id) where p.status=1 and p.client_id=$client->id and pd.developer_id=$developer->id";
		$p_result = mysql_query($sql) or die(mysql_error());
		$projects = mysql_num_rows($p_result);
		if (count($projects))
		{
		    $str.= '#';
		    #projects
		    while ($project = mysql_fetch_object($p_result))
		    {
			$str.= $project->id . ':' . $project->title;
			#memos
			$sql = "select * from memus where project_id=$project->id and developer_id=$developer->id";
			$m_result = mysql_query($sql) or die(mysql_error());
			$memos = mysql_num_rows($m_result);
			if (count($memos))
			{
			    $str.= '=';
			    while ($memo = mysql_fetch_object($m_result))
			    {
				$str.= $memo->id . ':' . $memo->title . '^';
			    }
			    $str = rtrim($str, '^=');
			    $str.=';';
			}
		    }
		    $str = rtrim($str, ';');
		}
	    }
	}
	$data = '1' . $str . '?' . $sessionToken;
    }
    #unset($_SESSION['developer']);
    return $data;
}

function pressStart($tokenKey, $project_id, $memo)
{

    $sql = "select * FROM token WHERE sessionToken='" . $tokenKey . "' limit 1";
    $result = mysql_query($sql);
    $token = mysql_fetch_object($result);

    $memo_id = (int) $memo;
    if (!$memo_id)
    {
	$sql = "insert into memus(project_id,developer_id,title,status) value($project_id,$token->developer_id,'" . $memo . "',0)";
	mysql_query($sql) or die(mysql_error());
	$memo_id = mysql_insert_id();
    }
    $duration = rand(4, 6);
    $startTime = date("Y-m-d H:i:s");
    $sql = "update token SET project_id=$project_id , memo_id=$memo_id , duration=$duration , start_time='" . $startTime . "' WHERE sessionToken = '" . $tokenKey . "'";
    mysql_query($sql) or die(mysql_error());
    #save initial timeslot
    saveTimeSlot($tokenKey);
    return $tokenKey . '|' . $duration;
}

function saveTimeSlot($tokenKey, $image = "")
{
    $sql = "select * FROM token WHERE sessionToken='" . $tokenKey . "' limit 1";
    $result = mysql_query($sql);
    $token = mysql_fetch_object($result);
    $startTime = date("Y-m-d H:i:s", strtotime("$token->start_time"));
    $numMinutes = $token->duration;
    $currentDate = strtotime("$token->start_time");
    $futureDate = $currentDate + (60 * $numMinutes);
    $endTime = ($image) ? date("Y-m-d H:i:s", $futureDate) : $startTime;


    #create new time slot
    $sql = "insert INTO time_slots(start_time,end_time,image,memu_id,status) VALUES ('" . $startTime . "','" . $endTime . "','" . $image . "',$token->memo_id,1)";
    $inserted = mysql_query($sql) or die(mysql_error());
    #update token
    $sql = "update token SET start_time='" . $endTime . "' WHERE sessionToken='" . $tokenKey . "'";
    mysql_query($sql) or die(mysql_error());
    return getReturn($inserted);
}

function pressStop($tokenKey)
{
    $sql = "update memus set status=1 where id=(select memo_id from token where sessionToken='" . $tokenKey . "')";
    $result = mysql_query($sql) or die(mysql_error());
    return getReturn($result);
}

function logout($tokenKey)
{
    $sql = "delete from token where sessionToken='" . $tokenKey . "'";
    $result = mysql_query($sql) or die(mysql_error());
    return getReturn($result);
}

function getReturn($result)
{
    return ($result) ? "1" : "0";
}

$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
$server->service($HTTP_RAW_POST_DATA);