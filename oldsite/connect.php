<?php
function Conection(){
   if (!($link=mysql_connect("localhost","USERNAME","PASSWORD")))  {
      exit();
   }
   if (!mysql_select_db("dht",$link)){
      exit();
   }
   return $link;
}
?>