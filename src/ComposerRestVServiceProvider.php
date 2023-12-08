<?php

namespace Wirke\ComposerRestV;

use Illuminate\Support\ServiceProvider;

class ComposerRestVServiceProvider extends ServiceProvider
{
    public function register()
    {
        add_action('rest_api_init', function () {
            register_rest_route('composer-rest/v1', '/getVersions', [
                'methods' => 'GET',
                'callback' => function () {
                    $installed = file_get_contents('../vendor/composer/installed.json');
                    $json = json_decode($installed);
                    $output = (object) [];
                    foreach ($json->packages as $package) {
                        $output->{$package->name} = $package->version;
                    }
                    return $output;
                },
                'permission_callback' => '__return_true',
            ]);
        });
    }

    public function boot()
    {
        
    }
}
