<?php

require_once 'vendor/autoload.php';

use App\Container;
use Doctrine\ORM\EntityManager;
use Doctrine\Migrations\DependencyFactory;
use Doctrine\Migrations\Configuration\Migration\PhpFile;
use Doctrine\Migrations\Configuration\EntityManager\ExistingEntityManager;

$config = require __DIR__.'/config/config.php';

$container = Container::initWithDefaults($config);

$config = new PhpFile(__DIR__.'/config/migrations.php');

$entityManager = $container->get(EntityManager::class);
assert($entityManager instanceof EntityManager);

return DependencyFactory::fromEntityManager($config, new ExistingEntityManager($entityManager));
