<?php
        $file_count = count($_FILES['files']['name']);
		$errorFalg = "0" ;
		$errorMessage = "";
        $uploaddir      =       "/tmp/";
        $host           =       "host = 127.0.0.1";
        $port           =       "port = 5432";
        $dbname         =       "dbname = testdb";
        $credentials    =       "user = ** password=***";
        $conn = pg_connect( " $host $port $dbname $credentials" )
           or die ("Could not connect to server\n");

                for ( $i=0;$i<$file_count;$i++) {
                                $img_name = basename($_FILES['files']['name'][$i]);
                                if (strpos($img_name, 'jpeg') !== false || strpos($img_name, 'jpg') !== false || strpos($img_name, 'png') !== false || strpos($img_name, 'JPEG') !== false || strpos($img_name, 'JPG') !== false || strpos($img_name, 'PNG') !== false) {
									$uploadfile = $uploaddir . basename($_FILES['files']['name'][$i]);
									if (move_uploaded_file($_FILES['files']['tmp_name'][$i], $uploadfile)){
													$query = "insert into image values (lo_import('$uploadfile'),'$img_name')";
													$result = pg_query($query);
													if($result){
															unlink($uploadfile);
													}
													else{
															$errorFalg ="1";
															$errorMessage = $errorMessage . " Filename already exists " . $img_name;
															unlink($uploadfile);
													}
									}
									else {
											$errorFalg ="1";
											$errorMessage = $errorMessage . " Error getting image " . $img_name;
									}
                                }
                }
        pg_close($conn);
		if ( $errorFalg == "0" ) {
			echo "{\"success\":\"true\",\"error\":\"non\"}";
		}
		else{
			echo "{\"success\":\"flase\",\"error\":\"${errorMessage}\"}";
		}
?>
