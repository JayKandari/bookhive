<?php
class Redirect
{
    public function jsalert($msg)
    {
        echo '<script> alert(" ' . $msg . ' "); </script>';
    }
    public function jsloc($uri)
    {
        echo '<script> window.location.replace("' . $uri . '") </script>';
    }
    public function phploc($uri)
    {
        header("location: $uri");
    }
}
