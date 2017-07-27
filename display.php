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
				div.mydiv {
					position: fixed;
					width: 100%;
					height: 100%;
					z-index: 10;
					background: black;
				}
				img.preview {
					 position:absolute;
					 top:0;
					 left:0;
					 right:0;
					 bottom:0;
					margin:auto;
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
			<script type=\"text/javascript\">
				function hidefun() {
					document.getElementById(\"previewdiv\").style.visibility = 'hidden';
					document.getElementById(\"imageviewer\").src = \"Images/loading.gif\";
				}
				function myfun(id) {
					document.getElementById(\"imageviewer\").src = \"show.php?imgFile=${temp}/\" + id;
                                        document.getElementById(\"previewdiv\").style.visibility = 'visible';
				}
			</script>
	
		</head>
	<body>
		<div class=\"container mydiv\" id=\"previewdiv\" onclick=\"hidefun();\">
			<img id=\"imageviewer\" src=\"\" style=\"max-width:100%\" onclick=\"hidefun();\" title=\"By: LintelBuligingSolutions\" class=\"preview\" />
		</div>
		<div class=\"container\">"
		;	
	$rowcount = pg_num_rows($result);
                if ($rowcount > 0 ) {
		echo "<section id=\"mygalary\">";
	while ($row = pg_fetch_row($result)) {
		$tempDir = $temp . $row[0];
		$tempDircpy = $tempDir;
		$query2 = "select lo_export(image, '$tempDir') from image where name = '${row[0]}'";
		$result2 = pg_query($query2);
		if ($result2) {
			echo "<IMG SRC=show.php?imgFile=${tempDircpy} id=\"${row[0]}\" title=\"LintelBuligingSolutions\" onclick=\"myfun(this.id)\">";
		}
	}
	echo "</section>";
	}
else {
	$tempDircpy = $temp . "noimage.png";
                echo "<br><br><IMG SRC=show.php?imgFile=${tempDircpy} class=\"img-responsive\" style=\"max-width:100%;margin:0 auto\" align=\"middle\" alt=\"No image found\" ><br><br>";
}

		echo "</div><script type=\"text/javascript\">
			document.getElementById(\"previewdiv\").style.visibility = 'hidden';
			document.getElementById(\"imageviewer\").src = \"Images/loading.gif\";
		</script>
	</body>
	</html>";
	
}
pg_close($conn);

?>

