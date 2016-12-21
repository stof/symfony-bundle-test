<?php

namespace Nyholm\BundleTest;

use Symfony\Component\DependencyInjection\ResettableContainerInterface;

/**
 *
 *
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
abstract class BaseBundleTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AppKernel
     */
    private $kernel;

    /**
     * @return string
     */
    protected abstract function getBundleClass();

    /**
     * Boots the Kernel for this test.
     *
     * @param array $options
     */
    protected function bootKernel()
    {
        $this->ensureKernelShutdown();

        $this->kernel->boot();
    }

    /**
     * @return \Symfony\Component\DependencyInjection\ContainerInterface
     */
    protected function getContainer()
    {
        return $this->kernel->getContainer();
    }

    /**
     * Get a kernel which you may configure with your bundle and services
     *
     * @return AppKernel
     */
    protected function createKernel()
    {
        require_once __DIR__.'/AppKernel.php';
        $class = 'Nyholm\BundleTest\AppKernel';

        $this->kernel = new $class(uniqid('cache'));
        $this->kernel->addBundle($this->getBundleClass());

        return $this->kernel;
    }

    /**
     * Shuts the kernel down if it was used in the test.
     */
    private function ensureKernelShutdown()
    {
        if (null !== $this->kernel) {
            $container = $this->kernel->getContainer();
            $this->kernel->shutdown();
            if ($container instanceof ResettableContainerInterface) {
                $container->reset();
            }
        }
    }

    /**
     * Clean up Kernel usage in this test.
     */
    protected function tearDown()
    {
        $this->ensureKernelShutdown();
    }
}
