// The arduino connects directly to this page and passes the temperature and humidity values.
<?php


   include("connect.php");
   $link=Conection();
   $Sql="insert into dht (tf,hum)  values ('".$_GET["tf"]."', '".$_GET["hum"]."')";     
   mysql_query($Sql,$link);
   header("Location: index.php");
   

?>
