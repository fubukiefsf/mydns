<?php
$mongo = new MongoClient();
$db = $mongo -> selectDB('mydns');
$col = new MongoCollection($db,"domeinlist");
foreach($col -> find() as $array ){
	echo $array['domin'].":";
	$mydns = new MyDns("ftp.mydns.jp");
	$mydns -> open();
	$mydns-> ftpCon($array['mydnsid'],$array['pass']);
	$mydns -> close();
	unset($mydns);
}
class MyDns{
	private $ftpUri;
	private $ftp;
	function __construct($ftpUri){
		$this -> ftpUri = $ftpUri;
	}
	public function open(){
		$this -> ftp = ftp_connect($this -> ftpUri )or die("なにかがおかしいよ");
	}
	public function ftpCon($userId,$pass){
		@ftp_login($this -> ftp,$userId,$pass);
		echo "成功しました!\n";
	}
	public function close(){
		ftp_close($this -> ftp);
	}
	
}
