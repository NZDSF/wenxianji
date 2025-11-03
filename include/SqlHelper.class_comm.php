<?php

	//这是一个工具类,作用是完成对数据库的操作
	class SqlHelper {
		public $conn;
		public $dbname="xztx";
		public $username="root";
		public $password="root123456";
		public $host="127.0.0.1:3307";

		public function __construct(){
			$this->conn=mysqli_connect($this->host,$this->username,$this->password);
			if(!$this->conn){
                die("<span style='font-size:20px;'>游戏错误,请联系管理员</span>");
			}
			mysqli_select_db($this->conn, $this->dbname);
			mysqli_query($this->conn, "set names 'utf8'");
		}
		
		//执行dql语句，但是返回的是一个数组
		public function execute_dql($sql){
			$arr=array();
			$res=mysqli_query($this->conn, $sql);
			while($row=mysqli_fetch_assoc($res)){
				$arr=$row;	
			}
			//这里就可以马上把$res关闭
			mysqli_free_result($res);
			return $arr;
			
		}

		//执行dml
		public function execute_dml($sql){
			$b=mysqli_query($this->conn, $sql);
			if(!$b){
				return 0;//表示失败
			}else{
				if(mysqli_affected_rows($this->conn)>0){
					return 1;//表示执行成功
				}else{
					return 2;//表示没有行数受到影响
				}
			}
		}
		
		//关闭连接的方法
		public function close_connect(){
			if(!empty($this->conn)){
				mysqli_close($this->conn);
			}
		}
	
	}
?>