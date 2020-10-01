<?php

namespace src;

class Redirect
{
    /*
    * PHP based redirection
    * avoids rendering of html
    */
    public function phploc($uri)
    {
        header("location: $uri");
    }
    /*
    * JS based redirection
    */
    public function jsloc($uri)
    {
        echo '<script> window.location.replace("' . $uri . '") </script>';
    }
    /*
    * Js basedd alert function
    */
    public function jsalert($msg)
    {
        echo '<script> alert(" ' . $msg . ' "); </script>';
    }
}
