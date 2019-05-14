<?php


namespace App\Service;

class Paths
{

    private $url;

    public function __construct($url)
    {
        $this->url = parse_url($url);
    }

    public function returnUrl()
    {
        $return = $this->url['path'] . '?' . $this->url['query'];
        $return = (substr($return, -1) == "&") ? substr($return, 0, -1) : $return;
        $this->resetQuery();
        return $return;
    }

    public function changePath($path)
    {
        $this->url['path'] = $path;
    }

    public function editQuery($get, $value)
    {
        $parts = explode("&", $this->url['query']);
        $return = "";
        foreach ($parts as $p) {
            $paramData = explode("=", $p);
            if ($paramData[0] == $get) {
                $paramData[1] = $value;
            }
            $return .= implode("=", $paramData) . '&';

        }

        $this->url['query'] = $return;
    }

    public function resetQuery()
    {
        $this->url = parse_url($_SERVER['REQUEST_URI']);
    }
}
