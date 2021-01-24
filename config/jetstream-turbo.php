<?php

use LaravelTurbo\JetstreamTurbo\Features;

return [

    'version' => '20210132200005',

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
                //'transfer' =>
                //'system => true,
            ]),
    ],

];
