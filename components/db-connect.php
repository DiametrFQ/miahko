<?php
$des = mysqli_connect("localhost", "root", "");
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
mysqli_select_db($des, "products");
mysqli_set_charset($des, "utf8");
