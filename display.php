<?php


	$host           =       "host = 127.0.0.1";
        $port           =       "port = 5432";
        $dbname         =       "dbname = testdb";
        $credentials    =       "user = **  password=****";

        $conn = pg_connect( " $host $port $dbname $credentials" )
           or die ("Could not connect to server\n");

$temp = '/tmp/';
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
					display:block;
					margin:auto;
				}
			</style>
			<script type=\"text/javascript\">
				function hidefun() {
					document.getElementById(\"previewdiv\").style.visibility = 'hidden';
				}
				function myfun(id) {
					document.getElementById(\"imageviewer\").src = \"show.php?imgFile=${temp}/\" + id;
					document.getElementById(\"previewdiv\").style.visibility = 'hidden';
                                        document.getElementById(\"previewdiv\").style.visibility = 'visible';
				}
			</script>
	
		</head>
	<body>
		<div class=\"container-fluid mydiv\" id=\"previewdiv\" onclick=\"hidefun();\">
			<img id=\"imageviewer\" src=\"\" style=\"max-width:100%\" onclick=\"hidefun();\" class=\"preview\"/>
		</div>";	
	while ($row = pg_fetch_row($result)) {
		$tempDir = $temp . $row[0];
		$tempDircpy = $tempDir;
		$query2 = "select lo_export(image, '$tempDir') from image where name = '${row[0]}'";
		$result2 = pg_query($query2);
		if ($result2) {
			echo "<IMG SRC=show.php?imgFile=${tempDircpy} id=\"${row[0]}\" title=${row[0]} onclick=\"myfun(this.id)\" style=\"max-width:50%\">";
		}
	}

		echo "<script type=\"text/javascript\">
			document.getElementById(\"previewdiv\").style.visibility = 'hidden';
		</script>
	</body>
	</html>";
	
}
pg_close($conn);

?>

