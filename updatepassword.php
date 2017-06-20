<?php
        $host           =       "host = 127.0.0.1";
        $port           =       "port = 5432";
        $dbname         =       "dbname = testdb";
        $username       =       $_POST['username'];
        $password       =       $_POST['password'];
	$newpassword	=	$_POST['newpassword'];
        $credentials    =       "user = $username password=$password";
        $conn = pg_connect( " $host $port $dbname $credentials" );
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
	$query = "alter user $username password '$newpassword'";
	$result = pg_query($query);
        if($result){
			if (!$content = file_get_contents (".credentials.txt")){
         		       echo "1.Unable to update credentials for readfiles even though database passsword is updated, Please contact admin to correct it";
		        }
		        else {
                		$content = str_replace($password,$newpassword,$content);
			        if (!file_put_contents (".credentials.txt",$content)){
                        		echo "2.Unable to update credentials for readfiles even though database passsword is updated, Please contact admin to correct it";
		                }
                		else {
					echo "Password updated..! ${output}";
				}
				echo "&nbsp;&nbsp<a href=\"password.html\">Back&nbsp;&nbsp<span class=\"glyphicon glyphicon-check\"></span></a>";
			 }
	}	
        else{
		echo "Password update failed...!";
		echo "&nbsp;&nbsp<a href=\"password.html\">Retry&nbsp;&nbsp<span class=\"glyphicon glyphicon-repeat\"></span></a>";
	}
	echo "	</div></body></html>";
	pg_close($conn);
?>
