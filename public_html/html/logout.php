<?php
include_once 'conf.php';
session_reset();
session_destroy();
redirect('index.php');