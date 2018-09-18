<?php

namespace Mvc\Helper;

class Url
{
    /*
     * Get the Base URL
     *
     * @param  boolean $atRoot
     * @param  boolean $atCore
     * @param  boolean $parse
     * @return string
     */
    function baseUrl($atRoot = false, $atCore = false, $parse = false)
    {
        if (isset($_SERVER['HTTP_HOST'])) {

            $http     = (isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off') ? 'https' : 'http';
            $hostname = $_SERVER['HTTP_HOST'];
            $dir      = str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
            $core     = preg_split('@/@', str_replace($_SERVER['DOCUMENT_ROOT'], '', realpath(dirname(__FILE__))), NULL, PREG_SPLIT_NO_EMPTY);
            $core     = $core[0];
            $tmplt    = ($atRoot) ? (($atCore) ? "%s://%s/%s/" : "%s://%s/") : (($atCore) ? "%s://%s/%s/" : "%s://%s%s");
            $end      = ($atRoot) ? (($atCore) ? $core : $hostname) : (($atCore) ? $core : $dir);
            $base_url = sprintf($tmplt, $http, $hostname, $end);

        } else {
            $base_url = 'http://localhost/';
        }

        if ($parse) {
            $base_url = parse_url($base_url);

            if (isset($base_url['path'])) {
                if ($base_url['path'] == '/') {
                    $base_url['path'] = '';
                }
            }
        }

        return $base_url;
    }

    /**
     * Get an Assets URL
     *
     * @param string $path The path to the asset
     */
    function assetUrl($path)
    {
        return $this->baseUrl() . 'assets/' . $path;
    }
}
