<?php
session_start();
$source = $_SESSION['source'];
session_destroy();

header("Location: " . $source);
