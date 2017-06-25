<?php
	$host           =       "host = 127.0.0.1";
        $port           =       "port = 5432";
        $dbname         =       "dbname = testdb";
        $username       =       $_POST['username'];
        $password       =       $_POST['password'];
	$credentials    =       "user = $username password=$password";
        $conn = pg_connect( " $host $port $dbname $credentials" );
	$imgDir = "/tmp/images/";
	 echo "<html>
                <head>
                        <title>Lintel</title>
                        <meta charset=\"utf-8\">
                        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
                        <link rel=\"stylesheet\" href=\"bootstrap/css/bootstrap.min.css\">
                        <link rel=\"stylesheet\" href=\"font-awesome/css/font-awesome.min.css\">
                </head><body><div class=\"container-fluid\" style=\"text-align:center\">";

	 if (!$conn) {
                echo "Please check your credentials <br>";
        }
	else {

		$name = $_POST['checkbox'];
		foreach ($name as $imgname){
			$query = "delete from image where name='${imgname}'";
			$result = pg_query($query);
        		if($result){
				echo "$imgname deleted<br>";
				$cmpImage = $imgDir . $imgname;
				 unlink($cmpImage);
			}
			else {
				echo "$imgname failed to delete<br>";
			}
		}
	}
	echo "&nbsp;&nbsp<a href=\"deletedisplay.php\">Back&nbsp;&nbsp<span class=\"glyphicon glyphicon-repeat\"></span></a>";
?>
