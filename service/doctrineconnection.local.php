<?php

/**
 * This file will only be needed if you didn't set up a Doctrine-Connection yet
 */
return array(
    'doctrine' => array(
        'connection' => array(
            'orm_default' => array(
                'driverClass' => 'Doctrine\DBAL\Driver\PDOMySql\Driver',
                'params' => array(
                    'host' => 'localhost',
                    'port' => '3306',
                    'user' => 'outsoux3_time',
                    'password' => 'r?hssG%Fv9Th',
                    'dbname' => 'outsoux3_time'
                )
            )
        )
    )
);