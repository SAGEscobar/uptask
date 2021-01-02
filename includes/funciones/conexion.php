<?php

// $conn = new mysqli('localhost', 'root', 'syclone', 'uptask_db');

$conn = new mysqli('sql301.epizy.com', 'epiz_27592613', 'utRw1CNyYC', 'epiz_27592613_uptask_db');

if($conn->connect_error){
    echo $conn->connect_error;
}

$conn->set_charset('utf8');