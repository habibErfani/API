<?php

namespace App;

use Laminas;
use GuzzleHttp;
use Laminas\ServiceManager\ServiceManager;
use League\Fractal\Manager;
use Doctrine\DBAL\Connection;
use App\Service\LibraryService;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\DBAL\DriverManager;
use Spatie\Fractalistic\Fractal;
use Psr\Http\Client\ClientInterface;
use App\Repository\LibraryRepository;
use Psr\Container\ContainerInterface;
use Laminas\Di\Container\ConfigFactory;
use Psr\Http\Message\UriFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Spatie\Fractalistic\Fractal as Fractalistic;
use Psr\Http\Message\UploadedFileFactoryInterface;
use Psr\Http\Message\ServerRequestFactoryInterface;

class Container extends ServiceManager
{
    public static function initWithDefaults(array $options = []) : self
    {
        // Setup service manager
        $params = [
            'services' => [
                'config' => $options,
            ],
            'invokables' => [
                // PSR-17 HTTP Message Factories
                RequestFactoryInterface::class       => GuzzleHttp\Psr7\HttpFactory::class,
                ServerRequestFactoryInterface::class => GuzzleHttp\Psr7\HttpFactory::class,
                ResponseFactoryInterface::class      => GuzzleHttp\Psr7\HttpFactory::class,
                StreamFactoryInterface::class        => GuzzleHttp\Psr7\HttpFactory::class,
                UploadedFileFactoryInterface::class  => GuzzleHttp\Psr7\HttpFactory::class,
                UriFactoryInterface::class           => GuzzleHttp\Psr7\HttpFactory::class,

                // PSR-18 HTTP Client implementations
                ClientInterface::class => GuzzleHttp\Client::class,
            ],
            'factories' => [
                Laminas\Di\ConfigInterface::class   => ConfigFactory::class,
                Laminas\Di\InjectorInterface::class => Laminas\Di\Container\InjectorFactory::class,
            ],
        ];

        $container = new self($params);

        $container->setFactory(
            EntityManager::class,
            function (ContainerInterface $container) {
                $config = $container->get('config');
                \assert(\is_array($config));

                /** @var array{charset?:string} $em_conn */
                $em_conn  = $config['em_conn'];
                $em_config= $config['em_config'];
                \assert($em_config instanceof Configuration);

                /** @psalm-param Connection $connection */
                $connection = DriverManager::getConnection($em_conn, $em_config);

                return new EntityManager(
                    $connection,
                    $em_config
                );
            }
        );

        $container->setFactory(
            LibraryRepository::class,
            function (ContainerInterface $container) {
                $entityManager = $container->get(EntityManager::class);

                return new LibraryRepository($entityManager);
            }
        );

        $container->setFactory(
            LibraryService::class,
            function (ContainerInterface $container) {
                $repository = $container->get(LibraryRepository::class);

                return new LibraryService($repository);
            }
        );

        $container->setFactory(
            Fractalistic::class,
            function () {
                return new Fractalistic(
                    new Manager()
                );
            }
        );

        $container->setFactory(
            Manager::class,
            function () {
                return new Manager();
            }
        );

        $container->setFactory(
            Fractal::class,
            function (ContainerInterface $container) {
                $manager = $container->get(Manager::class);

                return new Fractal($manager);
            }
        );

        return $container;
    }
}
