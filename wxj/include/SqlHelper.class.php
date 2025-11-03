<?php
/**
 * Author: by suxin
 * Date: 2019/12/01
 * Time: 15:24
 * Note: 数据库的操作
 */


	class SqlHelper
    {
        public $conn;
        public $dbname="xztx";
		public $username="root";
		public $password="root123456";
        public $host = "127.0.0.1:3307";

        public function __construct()
        {
            $this->conn = mysqli_connect($this->host, $this->username, $this->password);
            if (!$this->conn) {
                die("<span style='font-size:20px;'>游戏错误,请联系管理员</span>");
            }
            mysqli_select_db($this->conn, $this->dbname);
            mysqli_query($this->conn, "set names 'utf8'");
        }

        //执行dql语句，但是返回的是一个数组
        public function execute_dql($sql)
        {
            $arr = array();
            $res = mysqli_query($this->conn, $sql);
            while ($row = mysqli_fetch_assoc($res)) {
                $arr = $row;
            }

            //这里就可以马上把$res关闭
            mysqli_free_result($res);
            return $arr;

        }

        //执行dql语句，但是返回的是一个数组
        public function execute_dql2($sql)
        {
            $arr = array();
            $res = mysqli_query($this->conn, $sql);
            while ($row = mysqli_fetch_assoc($res)) {
                $arr[] = $row;
            }

            //这里就可以马上把$res关闭
            mysqli_free_result($res);
            return $arr;

        }

        //执行dml
        public function execute_dml($sql)
        {
            $b = mysqli_query($this->conn, $sql);
            if (!$b) {
                return 0;//表示失败
            } else {
                if (mysqli_affected_rows($this->conn) > 0) {
                    return 1;//表示执行成功
                } else {
                    return 2;//表示没有行数受到影响
                }
            }
        }

        //查询玩家s_user表里面的任意内容
        public function chaxun_wj_user_neirong($neirong)
        {
            $arr = 0;
            $sql = "select $neirong from s_user where s_name='$_SESSION[id]'";
            $res = mysqli_query($this->conn, $sql);
            while ($row = mysqli_fetch_row($res)) {
                $arr = $row[0];
            }

            //这里就可以马上把$res关闭
            mysqli_free_result($res);
            return $arr;
        }

        //修改玩家s_user表里面的任意内容_check
        public function xiugai_wj_user_neirong($neirong,$value){
            $arr = 0;
            $sql = "update s_user set $neirong='$value' where s_name='$_SESSION[id]'";
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

            //这里就可以马上把$res关闭
            mysqli_free_result($res);
            return $arr;
        }

        //增加玩家s_user表里面的任意内容
        public function add_wj_user_neirong($neirong, $add_zhi)
        {
            $sql = "update s_user set $neirong=$neirong+$add_zhi where s_name='$_SESSION[id]'";
            $b = mysqli_query($this->conn, $sql);
            if (!$b) {
                return 0;//表示失败
            } else {
                if (mysqli_affected_rows($this->conn) > 0) {
                    return 1;//表示执行成功
                } else {
                    return 2;//表示没有行数受到影响
                }
            }

            //这里就可以马上把$res关闭
            mysqli_free_result($res);
        }

        //减少玩家s_user表里面的任意内容
        public function jianshao_wj_user_neirong($neirong, $add_zhi)
        {
            $sql = "update s_user set $neirong=$neirong-$add_zhi where s_name='$_SESSION[id]'";
            $b = mysqli_query($this->conn, $sql);
            if (!$b) {
                return 0;//表示失败
            } else {
                if (mysqli_affected_rows($this->conn) > 0) {
                    return 1;//表示执行成功
                } else {
                    return 2;//表示没有行数受到影响
                }
            }

            //这里就可以马上把$res关闭
            mysqli_free_result($res);
        }

        //查询物品的数量
        public function chaxun_wp_counts($wp_name)
        {
            $arr = 0;
            $sql = "select wp_counts from s_wj_bag where wp_name='$wp_name' and s_name='$_SESSION[id]'";
            $res = mysqli_query($this->conn, $sql);
            while ($row = mysqli_fetch_row($res)) {
                $arr = $row[0];
            }

            //这里就可以马上把$res关闭
            mysqli_free_result($res);
            return $arr;

        }

        //考虑分页情况的查询,通用模板
        public function exectue_dql_fenye($sql1, $sql2, $fenyePage)
        {

            //这里我们查询了要分页显示的数据
            $res = mysqli_query($this->conn, $sql1);
            $arr = array();
            //把$res转移到$arr
            while ($row = mysqli_fetch_assoc($res)) {
                $arr[] = $row;
            }
            mysqli_free_result($res);
            $res2 = mysqli_query($this->conn, $sql2);
            if ($row = mysqli_fetch_row($res2)) {
                if ($row[0] > 200) {
                    $max_page_row = 200;
                } else {
                    $max_page_row = $row[0];
                }
                $fenyePage->pageCount = ceil($max_page_row / $fenyePage->pageSize);
                $fenyePage->rowCount = $max_page_row;
            }
            mysqli_free_result($res2);

            //把导航信息也封装到fenyePage对象中
            $navigate = "";
            if ($fenyePage->pageNow > 1) {
                $prePage = $fenyePage->pageNow - 1;

                global $date,$key_url_md_5;
                $jiami1 = 'pagenowid='.$prePage;
                $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);

                $navigate = "<a href='{$fenyePage->gotoUrl}?$url1'>上一页</a> ";
            }
            if ($fenyePage->pageNow < $fenyePage->pageCount) {
                $nextPage = $fenyePage->pageNow + 1;

                global $date,$key_url_md_5;
                $jiami1 = 'pagenowid='.$nextPage;
                $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);

                $navigate .= "<a href='{$fenyePage->gotoUrl}?$url1'>下一页</a>";
            }


            //显示当前页和共有多少页
            $navigate .= "(第{$fenyePage->pageNow}/{$fenyePage->pageCount}页)<br/>";

            //把$arr赋给$fenyepage
            $fenyePage->res_array = $arr;

            //print_r($arr);
            $fenyePage->navigate = $navigate;
        }

        //考虑分页情况的查询,背包专用模板
        public function exectue_dql_fenye_bag($sql1, $sql2, $fenyePage,$bag_url_fl)
        {
            //这里我们查询了要分页显示的数据
            $res = mysqli_query($this->conn, $sql1);
            $arr = array();
            //把$res转移到$arr
            while ($row = mysqli_fetch_assoc($res)) {
                $arr[] = $row;
            }
            mysqli_free_result($res);
            $res2 = mysqli_query($this->conn, $sql2);
            if ($row = mysqli_fetch_row($res2)) {
//                if ($row[0] > 200) {
//                    $max_page_row = 200;
//                } else {
                    $max_page_row = $row[0];
//                }
                $fenyePage->pageCount = ceil($max_page_row / $fenyePage->pageSize);
                $fenyePage->rowCount = $max_page_row;
            }
            mysqli_free_result($res2);

            //把导航信息也封装到fenyePage对象中
            $navigate = "";
            if ($fenyePage->pageNow > 1) {
                $prePage = $fenyePage->pageNow - 1;

                global $date,$key_url_md_5;
                $jiami1 = 'x='.$bag_url_fl.'&pagenowid='.$prePage;
                $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);

                $navigate = "<a href='{$fenyePage->gotoUrl}?$url1'>上一页</a> ";
            }
            if ($fenyePage->pageNow < $fenyePage->pageCount) {
                $nextPage = $fenyePage->pageNow + 1;

                global $date,$key_url_md_5;
                $jiami1 = 'x='.$bag_url_fl.'&pagenowid='.$nextPage;
                $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);

                $navigate .= "<a href='{$fenyePage->gotoUrl}?$url1'>下一页</a>";
            }


            //显示当前页和共有多少页
            $navigate .= "(第{$fenyePage->pageNow}/{$fenyePage->pageCount}页)<br/>";

            //把$arr赋给$fenyepage
            $fenyePage->res_array = $arr;

            $fenyePage->navigate = $navigate;
        }

        //考虑分页情况的查询,拍卖行某物品一览专用模板
        public function exectue_dql_fenye_pm_wplist($sql1, $sql2, $fenyePage,$dh_fl,$wp_num)
        {
            //这里我们查询了要分页显示的数据
            $res = mysqli_query($this->conn, $sql1);
            $arr = array();
            //把$res转移到$arr
            while ($row = mysqli_fetch_assoc($res)) {
                $arr[] = $row;
            }
            mysqli_free_result($res);
            $res2 = mysqli_query($this->conn, $sql2);
            if ($row = mysqli_fetch_row($res2)) {
                if ($row[0] > 200) {
                    $max_page_row = 200;
                } else {
                    $max_page_row = $row[0];
                }
                $fenyePage->pageCount = ceil($max_page_row / $fenyePage->pageSize);
                $fenyePage->rowCount = $max_page_row;
            }
            mysqli_free_result($res2);

            //把导航信息也封装到fenyePage对象中
            $navigate = "";
            if ($fenyePage->pageNow > 1) {
                $prePage = $fenyePage->pageNow - 1;

                global $date,$key_url_md_5;
                $jiami1 = 'x='.$dh_fl.'&id='.$wp_num.'&pagenowid='.$prePage;
                $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);

                $navigate = "<a href='{$fenyePage->gotoUrl}?$url1'>上一页</a> ";
            }
            if ($fenyePage->pageNow < $fenyePage->pageCount) {
                $nextPage = $fenyePage->pageNow + 1;

                global $date,$key_url_md_5;
                $jiami1 = 'x='.$dh_fl.'&id='.$wp_num.'&pagenowid='.$nextPage;
                $url1 = encrypt_url("$jiami1.$date", $key_url_md_5);

                $navigate .= "<a href='{$fenyePage->gotoUrl}?$url1'>下一页</a>";
            }


            //显示当前页和共有多少页
            $navigate .= "(第{$fenyePage->pageNow}/{$fenyePage->pageCount}页)<br/>";

            //把$arr赋给$fenyepage
            $fenyePage->res_array = $arr;

            $fenyePage->navigate = $navigate;
        }

        ############# ############ ############## ################
        ############# ############ ############## ################
        ############# ############ ############## ################
        ############# ############ ############## ################
        ############# ############ ############## ################










//
//        //考虑分页情况的查询，这是一个比较通用的并体现oop编程思想的代码
//        public function exectue_dql_fenye_friends($sql1, $fenyePage)
//        {
//            //这里我们查询了要分页显示的数据
//
////            $res=mysql_query($sql1,$this->conn) or die(mysql_error());
//            $res = mysqli_query($this->conn, $sql1);
//            $arr = array();
//            //把$res转移到$arr
//            while ($row = mysqli_fetch_assoc($res)) {
//                $arr = $row;
//            }
//
//            mysqli_free_result($res);
//
//            if (isset($arr["friends"])) {
//                $arr1 = explode(",", $arr["friends"]);
//
//                $arr = array_slice($arr1, ($fenyePage->pageNow - 1) * $fenyePage->pageSize, $fenyePage->pageSize);
//
//                $num_count = count($arr1);
//
//                $fenyePage->pageCount = ceil($num_count / $fenyePage->pageSize);
//                $fenyePage->rowCount = $num_count;
//
//                //把导航信息也封装到fenyePage对象中
//                $navigate = "";
//                if ($fenyePage->pageNow > 1) {
//                    $prePage = $fenyePage->pageNow - 1;
//                    $navigate = "<a href='{$fenyePage->gotoUrl}&pageNow=$prePage'>上一页</a>";
//                }
//                if ($fenyePage->pageNow < $fenyePage->pageCount) {
//                    $nextPage = $fenyePage->pageNow + 1;
//                    $navigate .= "<a href='{$fenyePage->gotoUrl}&pageNow=$nextPage'>下一页</a>";
//                }
//                //		$page_whole=10;
//                //		$start=floor(($fenyePage->pageNow-1)/$page_whole)*$page_whole+1;
//                //		$index=$start;
//                //		//整体每10页向前翻动
//                //		//如果当前pagenow在1-10页，就没有向前翻动的超链接
//                //		if($fenyePage->pageNow>$page_whole){
//                //			$navigate.="&nbsp;<a href='{$fenyePage->gotoUrl}?pageNow=".($start-1)."'><<</a>";
//                //		}
//                //		for(;$start<$index+$page_whole;$start++){
//                //			$navigate.="<a href='{$fenyePage->gotoUrl}?pageNow=$start'>[$start]</a>";
//                //		}
//                //		//整体每10页翻动
//                //		$navigate.="&nbsp;<a href='{$fenyePage->gotoUrl}?pageNow=$start'>>></a>";
//
//                //		//显示当前页和共有多少页
//                if ($fenyePage->pageCount <= 1) {
//                    $navigate .= "";
//                } else {
//                    $navigate .= "(第{$fenyePage->pageNow}/{$fenyePage->pageCount}页)";
//                }
//
//
//                //把$arr赋给$fenyepage
//                $fenyePage->res_array = $arr;
//                //print_r($arr);
//                $fenyePage->navigate = $navigate;
//            } else {
//                $fenyePage->res_array = "";
//            }
//        }
//




        //关闭连接的方法
        public function close_connect()
        {
            if (!empty($this->conn)) {
                mysqli_close($this->conn);
            }
        }

    }
?>