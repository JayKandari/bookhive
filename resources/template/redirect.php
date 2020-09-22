<?php

namespace Redirect;

class Redirect
{
    public function phploc($uri)
    {
        header("location: $uri");
    }
    public function jsloc($uri)
    {
        echo '<script> window.location.replace("' . $uri . '") </script>';
    }
    public function jsalert($msg)
    {
        echo '<script> alert(" ' . $msg . ' "); </script>';
    }
}
