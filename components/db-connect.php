<?php
$des = mysqli_connect("localhost", "root", "");
mysqli_select_db($des, "products");
mysqli_set_charset($des, "utf8");
