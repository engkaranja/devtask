<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Config
 *
 * @author KARANJA
 */
class Config {
    //put your code here
    
    public static function getAppConfiguration($config, $defaultIfNotExist = FALSE) {
        $configurations = array(
        /* Global Configurations */
        'b2cEndpoint' => '',
            
        );


        if (isset($configurations[$config])) {
            return $configurations[$config];
        } elseif (strlen(trim($defaultIfNotExist)) > 0) {
            Utils::logThis("INFO", "config $config not found, returning default $defaultIfNotExist");
            return $defaultIfNotExist;
        } else {
            Utils::logThis("ERROR", "requested Config $config not exist");
            return false;
        }
    }
}
