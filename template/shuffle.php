<?php
include "../classes/db.php";

$r = $db->query("select * from table");
for($i=0;$i<500;$i++){
  $arr[$i] = mysqli_fetch_assoc($r);
}
shuffle($arr);