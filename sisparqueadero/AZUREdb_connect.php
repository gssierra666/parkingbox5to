<?php 
$con = mysqli_init();
mysqli_ssl_set($con,NULL,NULL, "DigiCertGlobalRootCA.crt.pem", NULL, NULL);
mysqli_real_connect
($conn, "svrappsau.mysql.database.azure.com", "adm", "Latitude3340", "dbparqueo", 3306, MYSQLI_CLIENT_SSL);
?>