<?php

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\Exception\InactiveScopeException;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use Symfony\Component\DependencyInjection\Exception\LogicException;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;
use Symfony\Component\DependencyInjection\ParameterBag\FrozenParameterBag;

/**
 * appDevDebugProjectContainer.
 *
 * This class has been auto-generated
 * by the Symfony Dependency Injection Component.
 */
class appDevDebugProjectContainer extends Container
{
    private $parameters;
    private $targetDirs = array();

    /**
     * Constructor.
     */
    public function __construct()
    {
        $dir = __DIR__;
        for ($i = 1; $i <= 3; ++$i) {
            $this->targetDirs[$i] = $dir = dirname($dir);
        }
        $this->parameters = $this->getDefaultParameters();

        $this->services =
        $this->scopedServices =
        $this->scopeStacks = array();

        $this->set('service_container', $this);

        $this->scopes = array();
        $this->scopeChildren = array();
        $this->methodMap = array(
            'genny.console.application' => 'getGenny_Console_ApplicationService',
            'genny.console.command.page_generator' => 'getGenny_Console_Command_PageGeneratorService',
            'genny.console.command.watch' => 'getGenny_Console_Command_WatchService',
            'genny.page_generator' => 'getGenny_PageGeneratorService',
            'genny.twig' => 'getGenny_TwigService',
            'genny.twig.loader' => 'getGenny_Twig_LoaderService',
        );

        $this->aliases = array();
    }

    /**
     * {@inheritdoc}
     */
    public function compile()
    {
        throw new LogicException('You cannot compile a dumped frozen container.');
    }

    /**
     * Gets the 'genny.console.application' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return \Kyoushu\Genny\Bundle\Console\Application A Kyoushu\Genny\Bundle\Console\Application instance.
     */
    protected function getGenny_Console_ApplicationService()
    {
        $this->services['genny.console.application'] = $instance = new \Kyoushu\Genny\Bundle\Console\Application($this);

        $instance->add($this->get('genny.console.command.page_generator'));
        $instance->add($this->get('genny.console.command.watch'));

        return $instance;
    }

    /**
     * Gets the 'genny.console.command.page_generator' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return \Kyoushu\Genny\Bundle\Console\Command\PageGeneratorCommand A Kyoushu\Genny\Bundle\Console\Command\PageGeneratorCommand instance.
     */
    protected function getGenny_Console_Command_PageGeneratorService()
    {
        $this->services['genny.console.command.page_generator'] = $instance = new \Kyoushu\Genny\Bundle\Console\Command\PageGeneratorCommand();

        $instance->setContainer($this);

        return $instance;
    }

    /**
     * Gets the 'genny.console.command.watch' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return \Kyoushu\Genny\Bundle\Console\Command\WatchCommand A Kyoushu\Genny\Bundle\Console\Command\WatchCommand instance.
     */
    protected function getGenny_Console_Command_WatchService()
    {
        $this->services['genny.console.command.watch'] = $instance = new \Kyoushu\Genny\Bundle\Console\Command\WatchCommand();

        $instance->setContainer($this);

        return $instance;
    }

    /**
     * Gets the 'genny.page_generator' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return \Kyoushu\Genny\Bundle\Generator\PageGenerator A Kyoushu\Genny\Bundle\Generator\PageGenerator instance.
     */
    protected function getGenny_PageGeneratorService()
    {
        return $this->services['genny.page_generator'] = new \Kyoushu\Genny\Bundle\Generator\PageGenerator($this->get('genny.twig'), ($this->targetDirs[1].'/../pages'), ($this->targetDirs[1].'/../dist'), ($this->targetDirs[1].'/../templates'));
    }

    /**
     * Gets the 'genny.twig' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return \Twig_Environment A Twig_Environment instance.
     */
    protected function getGenny_TwigService()
    {
        return $this->services['genny.twig'] = new \Twig_Environment($this->get('genny.twig.loader'));
    }

    /**
     * Gets the 'genny.twig.loader' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return \Twig_Loader_Filesystem A Twig_Loader_Filesystem instance.
     */
    protected function getGenny_Twig_LoaderService()
    {
        return $this->services['genny.twig.loader'] = new \Twig_Loader_Filesystem(($this->targetDirs[1].'/../templates'));
    }

    /**
     * {@inheritdoc}
     */
    public function getParameter($name)
    {
        $name = strtolower($name);

        if (!(isset($this->parameters[$name]) || array_key_exists($name, $this->parameters))) {
            throw new InvalidArgumentException(sprintf('The parameter "%s" must be defined.', $name));
        }

        return $this->parameters[$name];
    }

    /**
     * {@inheritdoc}
     */
    public function hasParameter($name)
    {
        $name = strtolower($name);

        return isset($this->parameters[$name]) || array_key_exists($name, $this->parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function setParameter($name, $value)
    {
        throw new LogicException('Impossible to call set() on a frozen ParameterBag.');
    }

    /**
     * {@inheritdoc}
     */
    public function getParameterBag()
    {
        if (null === $this->parameterBag) {
            $this->parameterBag = new FrozenParameterBag($this->parameters);
        }

        return $this->parameterBag;
    }

    /**
     * Gets the default parameters.
     *
     * @return array An array of the default parameters
     */
    protected function getDefaultParameters()
    {
        return array(
            'kernel.root_dir' => $this->targetDirs[1],
            'kernel.environment' => 'dev',
            'kernel.debug' => true,
            'kernel.name' => 'app',
            'kernel.cache_dir' => __DIR__,
            'kernel.logs_dir' => ($this->targetDirs[1].'/log'),
            'kernel.bundles' => array(
                'GennyBundle' => 'Kyoushu\\Genny\\Bundle\\GennyBundle',
            ),
            'kernel.charset' => 'UTF-8',
            'kernel.container_class' => 'appDevDebugProjectContainer',
            'genny.dist_dir' => ($this->targetDirs[1].'/../dist'),
            'genny.templates_dir' => ($this->targetDirs[1].'/../templates'),
            'genny.pages_dir' => ($this->targetDirs[1].'/../pages'),
        );
    }
}
