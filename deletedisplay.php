<?php


	$host           =       "host = 127.0.0.1";
        $port           =       "port = 5432";
        $dbname         =       "dbname = testdb";
	$loginData = file('../.credentials.txt');
        foreach ($loginData as $line) {
                list($username, $password) = explode(',',$line);
        }
        $credentials    =       "user = $username password=$password";
        $conn = pg_connect( " $host $port $dbname $credentials" )
           or die ("Could not connect to server\n");

$temp = '/tmp/images/';
$query = "select name from image";
$result = pg_query($query);

 if($_POST["temptext"]){
                        $temp=$_POST["temptext"];
                        $count=count($temp);
                        echo $count;
                }
if($result)
{
	
	echo "<html>
		<head>
			<title>Lintel</title>
			<meta charset=\"utf-8\">
			<meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
			<link rel=\"stylesheet\" href=\"bootstrap/css/bootstrap.min.css\">
			<link rel=\"stylesheet\" href=\"font-awesome/css/font-awesome.min.css\">
			<script src=\"bootstrap/jquery.min.js\"></script>
			<script src=\"bootstrap/js/bootstrap.min.js\"></script>
			<style>
				body {
                margin:0;
        }

        .navbar {
                overflow: hidden;
                background-color: #EE1B24;
        }

        .navbar a.home {
                float: left;
                display: block;
                color: #ffffff;
                text-align: center;
                padding: 14px 16px;
                text-decoration: none;
                font-size: 17px;
        }
        .navbar a.nonhome {
                float: left;
                display: block;
                color: #ffffff;
                text-align: center;
                padding: 14px 16px;
                text-decoration: none;
                font-size: 17px;
                cursor: default;
        }
        .navbar a.home:hover {
          background-color: #ffe6e6;
          color: #EE1B24;
        }

				.fancy-checkbox-label > input[type=checkbox] {
					  position: absolute;
 					 opacity: 0;
  					cursor: inherit;
				}
				.fancy-checkbox-label {
 				 	font-weight: normal;
 				 	cursor: pointer;
					width : 50%;
					margin: 23px -300px auto auto;
				}
				.fancy-checkbox:before {
 					 font-family: FontAwesome;
  					content: '\\f00c';
 					background: #fff;
  					color: transparent;
  					border: 3px solid #ddd;
  					border-radius: 3px;
  					z-index: 1;
				}
				.fancy-checkbox-label:hover > .fancy-checkbox:before,
					input:focus + .fancy-checkbox:before {
  					border-color: #bdbdff;
				}
				.fancy-checkbox-label:hover > input:not(:checked) + .fancy-checkbox:before {
  					color: #eee;
				}
				input:checked + .fancy-checkbox:before {
  					color: #fff;
  					background: #bdbdff;
 	 				border-color: #bdbdff;
				}
				.fancy-checkbox-img:before {
  					position: absolute;
  					margin: 3px;
  					line-height: normal;
				}
				input:checked + .fancy-checkbox-img + img {
  					transform: scale(0.9);
  					box-shadow: 0 0 5px #bdbdff;
				}
				
			</style>
	
		</head>
	<body>
		 <div class=\"navbar navbar-fixed-top\">
                        <div class=\"container\" id=\"sidebar\" >
                                <div id=\"inside\" ><a class=\"home\" href=\"index.html\"><b><span class=\"glyphicon glyphicon-home\"></span>&nbsp;Home</b></a> </div>
                                <div id=\"inside\" ><a class=\"home\" href=\"lintelimage.html\"><b><span class=\"glyphicon glyphicon-inbox\"></span>&nbsp;Image</b></a> </div>
                                <div id=\"inside\" ><a class=\"nonhome\" href=\"#\"><b>&nbsp;&nbsp;&nbsp;Lintel Buliding Solutions</b></a> </div>
                        </div>
                </div><br><br><br>

		<form action=\"delete.php\" method=\"POST\">";
	while ($row = pg_fetch_row($result)) {
		$tempDir = $temp . $row[0];
		$tempDircpy = $tempDir;
		$query2 = "select lo_export(image, '$tempDir') from image where name = '${row[0]}'";
		$result2 = pg_query($query2);
		if ($result2) {
			echo "<label class=\"fancy-checkbox-label\">";
   				echo " <input type=\"checkbox\" name=\"checkbox[]\" value=\"${row[0]}\">";
    				echo "<span class=\"fancy-checkbox fancy-checkbox-img\"></span>";
			echo "<IMG SRC=show.php?imgFile=${tempDircpy} id=\"${row[0]}\" title=${row[0]} class=\"img-responsive\" style=\"max-width:50%\">";
			echo "</label>";
		}
	}

		echo "<br><br><div class=\"container-fluid\">
                                                        <div class=\"row\">
                                                                <div class=\"col-lg-2\">UserName :</div>
                                                                <div class=\"col-lg-2\"><input type=\"text\" name=\"username\" style=\"width:70%\" required/></div>
                                                                <div class=\"col-lg-*\"></div>
                                                        </div>
                                                        <br>
                                                        <div class=\"row\">
                                                                <div class=\"col-lg-2\">Password :</div>
                                                                <div class=\"col-lg-2\"><input type=\"password\" name=\"password\" style=\"width:70%\" required /></div>
                                                                <div class=\"col-lg-*\"></div>
                                                        </div>
							<div class=\"row\">
								<div class=\"col-lg-4\"><button type=\"submit\" id=\"temptext\" >Submit</button></div>
								<div class=\"col-lg-*\"></div>
							</div>
			</div>
			</form>
	</body>
	</html>";
	
}
pg_close($conn);

?>

