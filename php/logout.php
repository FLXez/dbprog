<?php
session_start();
session_destroy();

header("Location:../site/index.php");