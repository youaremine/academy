<?php
// Antispam example using a random string
include_once ('./includes/config.inc.php');
include_once ("../library/jpgraph/jpgraph_antispam-digits.php");

// Create new anti-spam challenge creator
// Note: Neither '0' (digit) or 'O' (letter) can be used to avoid confusion
$spam = new AntiSpam ();

// Create a random 4 char challenge and return the string generated
$chars = $spam->Rand ( 4 );

// add the chars to session.
$_SESSION ['antispamChars'] = strtolower ( $chars );

// Stroke random cahllenge
$spam->Stroke ();

?>