<?php

include_once ("./includes/config.inc.php");
if (! UserLogin::IsLogin ()) {
    header ( "Location:login.php" );
    exit ();
}
include_once ('templates/advertisement_photo.html');
