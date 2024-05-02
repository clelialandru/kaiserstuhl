<?php
session_start();
require "controleur/routeur.class.php";

if(empty($_SESSION['lang'])){
    $_SESSION['lang'] = "en";
  }
  if(!empty($_GET['lang'])) $_SESSION['lang'] = $_GET['lang'];


$routeur = new Routeur();
$routeur->routerRequete();
