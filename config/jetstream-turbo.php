<?php

use LaravelTurbo\JetstreamTurbo\Features;

return [

    /*
    |--------------------------------------------------------------------------
    | Features
    |--------------------------------------------------------------------------
    |
    | Some of Jetstream Turbo's features are optional. You may disable the features
    | by removing them from this array. You're free to only remove some of
    | these features or you can even remove all of these if you need to.
    |
    */

    'features' => [
        Features::teams(
            [
                //'invitations' => true,
                //'personal' => fasle,
                //'transfer' => true
                //'system' => true,
                //'type' => true,
            ]),
    ],

];
