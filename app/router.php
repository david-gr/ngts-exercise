<?php

class Router
{

    static public function parse($url, $request) {
        $url = trim($url);
        if ('/' == $url) {
            $request->controller = 'Companies';
            $request->action = 'index';
            $request->params = array();
        } else {
            $explode_url = explode('/', $url);
            $explode_url = array_slice($explode_url, 1);
            $request->controller = $explode_url[0];
            $request->action = $explode_url[1];
            $request->params = array_slice($explode_url, 2);
        }
    }

}
