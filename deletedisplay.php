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
					width : 100%;
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
  					margin: 1px;
  					line-height: normal;
				}
				input:checked + .fancy-checkbox-img + img {
  					transform: scale(0.9);
  					box-shadow: 0 0 5px #bdbdff;
				}
				#mygalary {
					line-height: 0;
					-webkit-column-count: 5;
					-webkit-column-gap : 0px;
					-moz-column-count: 5;
					-moz-column-gap: 0px;
					column-count: 5;
					column-gap: 0px;
				}
				#mygalary IMG {
					width: 100% !important;
					height: auto !important;
					border : double 2px;
				}
				@media (max-width: 1200px) {
  #mygalary {
  -moz-column-count:    4;
  -webkit-column-count: 4;
  column-count:         4;
  }
}
@media (max-width: 1000px) {
  #mygalary {
  -moz-column-count:    3;
  -webkit-column-count: 3;
  column-count:         3;
  }
}
@media (max-width: 800px) {
  #mygalary {
  -moz-column-count:    2;
  -webkit-column-count: 2;
  column-count:         2;
  }
}
@media (max-width: 400px) {
  #mygalary {
  -moz-column-count:    1;
  -webkit-column-count: 1;
  column-count:         1;
  }
}
				
			</style>
	
		</head>
	<body style=\"padding-top: 70px;\">
		 <div class=\"navbar navbar-fixed-top\">
                        <div class=\"container\" id=\"sidebar\" >
                                <div id=\"inside\" ><a class=\"home\" href=\"index.html\"><b><span class=\"glyphicon glyphicon-home\"></span>&nbsp;Home</b></a> </div>
                                <div id=\"inside\" ><a class=\"home\" href=\"lintelimage.html\"><b><span class=\"glyphicon glyphicon-inbox\"></span>&nbsp;Image</b></a> </div>
                                <div id=\"inside\" ><a class=\"nonhome\" href=\"#\"><b>&nbsp;&nbsp;&nbsp;Lintel Buliding Solutions</b></a> </div>
                        </div>
                </div><br><br>

		<form action=\"delete.php\" method=\"POST\">";
		$rowcount = pg_num_rows($result);		
		if ($rowcount > 0 ) {
		echo "<section id=\"mygalary\">";
	while ($row = pg_fetch_row($result)) {
		$tempDir = $temp . $row[0];
		$tempDircpy = $tempDir;
		$query2 = "select lo_export(image, '$tempDir') from image where name = '${row[0]}'";
		$result2 = pg_query($query2);
		
		if ($result2) {
			echo "<label class=\"checkbox-inline fancy-checkbox-label\">
   				<input type=\"checkbox\" name=\"checkbox[]\" value=\"${row[0]}\">
    				<span class=\"fancy-checkbox fancy-checkbox-img\"></span>
			<IMG SRC=show.php?imgFile=${tempDircpy} id=\"${row[0]}\">
			</label>";
		}
	}
	echo "</section>";
	}
	else {
		$tempDircpy = $temp . "noimage.png";
		echo "<br><br><IMG SRC=show.php?imgFile=${tempDircpy} class=\"img-responsive\" style=\"max-width:100%;margin-left:10%\" alt=\"No images found\"><br><br>";
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
                                                        </div><br>
							<div class=\"row\">
								<div class=\"col-lg-2\"></div>
								<div class=\"col-lg-3\"><button type=\"submit\" class=\"btn btn-success mybtn\" id=\"temptext\" >Submit</button></div>
								<div class=\"col-lg-7\"></div>
							</div>
			</div>
			</form>
	</body>
	</html>";
	
}
pg_close($conn);

?>

