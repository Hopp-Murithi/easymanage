<?php

/**
 * 
 * @package easymanage
 */

namespace Inc;

class Init
{
    public static function get_services()
    {
        return [
            Pages\PMroutes::class,
            Pages\TrainerRoutes::class,
            Pages\TraineeRoutes::class,
            Pages\createTables::class,
            Pages\cohortRoutes::class,
            Pages\projectRoutes::class,

        ];
    }

    public static function register_services()
    {
        foreach (self::get_services() as $class) {
            $service = self::instantiate($class);
            if (method_exists($service, 'register')) {
                $service->register();
            }
        }
    }

    private static function instantiate($class)
    {
        $service = new $class;
        return $service;
    }
}