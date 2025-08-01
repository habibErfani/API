<?php

require_once 'vendor/autoload.php';

use Doctrine\ORM\EntityManager;
use Doctrine\Migrations\DependencyFactory;
use App\Infrastructure\DependencyInjection\Container;
use Doctrine\Migrations\Configuration\Migration\PhpFile;
use Doctrine\Migrations\Configuration\EntityManager\ExistingEntityManager;

$config = require __DIR__.'/config.php';

$container = Container::initWithDefaults($config);

$config = new PhpFile(__DIR__.'/migrations.php');

$entityManager       = $container->get(EntityManager::class);
$entityManager_notif = $container->get('em_notification');
$entityManager_even  = $container->get('em_evenement');

assert(
    $entityManager_even instanceof EntityManager
    && $entityManager instanceof EntityManager
    && $entityManager_notif instanceof EntityManager
);

$result = [
    'default' => DependencyFactory::fromEntityManager($config, new ExistingEntityManager($entityManager)),
    'em_evenement' => DependencyFactory::fromEntityManager($config, new ExistingEntityManager($entityManager_even)),
    'em_notification' => DependencyFactory::fromEntityManager($config, new ExistingEntityManager($entityManager_notif)),
];

return $result;
