<?php  
include_once('config/connection.php');

mysqli_query($link, "UPDATE participants SET score = '0'");
mysqli_query($link, "TRUNCATE TABLE m_tests");
mysqli_query($link, "TRUNCATE TABLE test_logs");