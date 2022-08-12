<?php
class Route
{
    private $url;
    public function __construct()
    {
        // explode url
        $url = ["home", "index"];
        if (isset($_GET["method"])) {
            $url = rtrim($_GET["method"], "/");
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode("/", $url);
        }
        $this->url = $url;
    }

    public function get($route, $file)
    {
        if ($route == $this->url[0]) {
            require_once "views/" . $file . ".php";
            exit;
        }
    }

    public function notfound($file)
    {
        require_once "views/" . $file . ".php";
        exit;
    }
}
