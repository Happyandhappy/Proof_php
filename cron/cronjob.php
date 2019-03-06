<?php
define("DBHOST", "localhost");
define("DBUSER", "root");
define("DBPASS", "");
define("DBNAME", "pos");
$externalContent = file_get_contents('http://checkip.dyndns.com/');
preg_match('/Current IP Address: \[?([:.0-9a-fA-F]+)\]?/', $externalContent, $m);
$serverip = $m[1];
if (!isset($serverip) || $serverip == '') exit;

$mysqli = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME, 3306);
if ($mysqli->connect_errno) {
    echo "Database Connection Error.";
    exit;
}


function getResponse($ip, $time){
	$curl = curl_init( $ip . "/api.php?time=" . $time);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
	$res = curl_exec($curl);
	curl_close($curl);
	return $res;
}


$remotes = $mysqli->query("SELECT * from remote");
if ($remotes){
	while ($row = $remotes->fetch_assoc()) {

		$ip = $row['ip'];
		$time = $row['timestamps'];

		if ($ip !== $serverip){
			$res = getResponse($ip, $time);
			$data = json_decode($res);
			foreach ($data as $row) {
				if (isset($row->postid)){
					// insert or update rposting data from response
					$res = $mysqli->query("SELECT COUNT(*) from `rposting` WHERE remote='" . $ip . "' and postid=" . $row->postid);

					// if already existed then update 
					if ($res && $res->fetch_assoc()['COUNT(*)'] > 0){
						$query = "UPDATE `rposting` SET username='" . $row->username . "', content='" . $row->content . "', `timestamps` = '" . $row->timestamps ."' WHERE remote='" . $ip . "' and postid=" . $row->postid;
					}else{
					// or insert new record
						$query = "INSERT INTO `rposting` (username, postid , content,`timestamps`, remote) VALUES ('" . $row->username . "',"  . $row->postid .",'" . $row->content . "','" . $row->timestamps . "','" . $ip . "')";	
					}
					$mysqli->query($query);

					// insert or update rimages data from response
					foreach ($row->images as $row1) {
						$res = $mysqli->query("SELECT COUNT(*) from `rimages` WHERE remote='" . $ip . "' and postid=" . $row->postid . " and imageid=" . $row1->id);

						if ($res && $res->fetch_assoc()['COUNT(*)'] > 0){
							$query = "UPDATE `rimages` SET url='" . $row1->url . "', `timestamps`='" . $row->timestamps . "' WHERE remote='" . $ip . "', and postid=" . $row->postid . ",imageid=" . $row1->id;
						}else{
							$query = "INSERT INTO `rimages` (remote, postid, imageid, url, `timestamps`) VALUES('" . $ip ."'," . $row->postid . "," . $row1->id . ",'" . $row1->url . "','" . $row->timestamps  . "')";
						}
						$mysqli->query($query);
					}
				}	
			}			
		}
		$mysqli->query("UPDATE `remote` SET `timestamps`=NOW() WHERE `ip`='" . $ip . "'");
	}
}
