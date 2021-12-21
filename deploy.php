<?php

namespace Deployer;

require 'recipe/laravel.php';
require 'contrib/php-fpm.php';
require 'contrib/npm.php';

// Config

set('application', 'TheDragonCode');
set('repository', 'git@github.com:TheDragonCode/api.dragon-code.pro.git');
set('php_fpm_version', '8.1');

// Hosts

host('production')
    ->setHostname('api.dragon-code.pro')
    ->setRemoteUser('forge')
    ->setDeployPath('~/{{hostname}}');

host('staging')
    ->setHostname('api-staging.dragon-code.pro')
    ->setRemoteUser('forge')
    ->setDeployPath('~/{{hostname}}');

// Tasks

task('deploy', [
    'deploy:prepare',
    'deploy:vendors',
    'artisan:storage:link',
    'artisan:optimize:clear',
    'artisan:optimize',
    'artisan:view:cache',
    'artisan:event:cache',
    'artisan:migrate',
    'artisan:migrate:actions',
    'npm:install',
    'npm:run:prod',
    'deploy:publish',
    'php-fpm:reload',
    'artisan:queue:restart',
]);

task('artisan:migrate:actions', function () {
    cd('{{release_path}}');
    run('{{bin/php}} artisan migrate:actions --force');
});

task('npm:run:prod', function () {
    cd('{{release_path}}');
    run('npm run prod');
});

after('deploy:failed', 'deploy:unlock');
