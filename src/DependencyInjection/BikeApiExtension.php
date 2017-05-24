<?php

namespace Bike\Api\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Exception\LogicException;
use Symfony\Component\DependencyInjection\Definition;

use Bike\Common\Exception\Debug\DebugException;

class BikeApiExtension extends Extension implements PrependExtensionInterface
{
    private $container;

    public function prepend(ContainerBuilder $container)
    {
        $this->container = $container;
    }

    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration($configs, $container);
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));

        $this->registerDaoConfiguration($config, $container, $loader);
        $this->registerOAuth2Configuration($config, $container, $loader);

        // service
        $loader->load('service.xml');

        // compile class
        $this->addClassesToCompile(array(

        ));
    }

    protected function registerDaoConfiguration(array $config, ContainerBuilder $container, XmlFileLoader $loader)
    {
        if (!isset($config['dao'])) {
            return;
        }

        foreach ($config['dao'] as $k => $v) {
            $container->setAlias('bike.api.params.dao.' . $k . '.conn_id', $v['conn_id']);
            $container->setParameter('bike.api.params.dao.' . $k. '.db_name', $v['db_name']);
            $container->setParameter('bike.api.params.dao.' . $k. '.prefix', $v['prefix']);
        }

        $loader->load('dao/primary.xml');
        $loader->load('dao/oauth2.xml');
    }

    protected function registerOAuth2Configuration(array $config, ContainerBuilder $container, XmlFileLoader $loader)
    {
        if (!isset($config['oauth2'])) {
            return;
        }

        foreach ($config['oauth2'] as $k => $v) {
            $container->setParameter('bike.api.params.oauth2.' . $k, $v);
        }
        $loader->load('oauth2.xml');
    }

    public function getAlias()
    {
        return 'bike_api';
    }
}
