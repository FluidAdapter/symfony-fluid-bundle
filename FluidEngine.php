<?php

namespace Mfc\Symfony\Bundle\FluidBundle;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Templating\Loader\LoaderInterface;
use Symfony\Component\Templating\TemplateNameParserInterface;
use Symfony\Component\Templating\TemplateReferenceInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\ViewHelperResolver;
use TYPO3Fluid\Fluid\View\TemplatePaths;
use TYPO3Fluid\Fluid\View\TemplateView;

/**
 * Class FluidEngine
 * @package Mfc\Symfony\Bundle\FluidBundle
 * @author Christian Spoo <cs@marketing-factory.de>
 */
class FluidEngine implements EngineInterface
{
    /**
     * @var TemplateView
     */
    private $fluid;

    /**
     * @var TemplateNameParserInterface
     */
    private $nameParser;

    /**
     * @var LoaderInterface
     */
    private $loader;

    /**
     * @var ViewHelperResolver
     */
    private $viewHelperResolver;

    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(TemplateView $fluid, TemplateNameParserInterface $nameParser, LoaderInterface $loader, ViewHelperResolver $viewHelperResolver, ContainerInterface $container)
    {
        $this->fluid = $fluid;
        $this->nameParser = $nameParser;
        $this->viewHelperResolver = $viewHelperResolver;
        $this->loader = $loader;
        $this->container = $container;

        // Default template paths
        $templatePaths = [
            TemplatePaths::CONFIG_TEMPLATEROOTPATHS => [
                $container->getParameter('kernel.root_dir') . '/Resources/views/Templates'
            ],
            TemplatePaths::CONFIG_LAYOUTROOTPATHS => [
                $container->getParameter('kernel.root_dir') . '/Resources/views/Layouts'
            ],
            TemplatePaths::CONFIG_PARTIALROOTPATHS => [
                $container->getParameter('kernel.root_dir') . '/Resources/views/Partials'
            ]
        ];

        /**
         * Define a set of template dirs to look for. This will allow the
         * usage of the following syntax:
         * <code>WebkitBundle:Default:layout.html</code>
         */
        foreach ($container->getParameter('kernel.bundles') as $bundle) {
            $name = explode('\\', $bundle);
            $name = end($name);
            $reflection = new \ReflectionClass($bundle);
            if (is_dir($dir = dirname($reflection->getFilename()) . '/Resources/views')) {
                $templatePaths[TemplatePaths::CONFIG_TEMPLATEROOTPATHS][] = $dir . '/Templates';
                $templatePaths[TemplatePaths::CONFIG_LAYOUTROOTPATHS][] = $dir . '/Layouts';
                $templatePaths[TemplatePaths::CONFIG_PARTIALROOTPATHS][] = $dir . '/Partials';
            }
        }
        $this->fluid->getTemplatePaths()->fillFromConfigurationArray($templatePaths);
    }

    /**
     * Renders a view and returns a Response.
     *
     * @param string $view The view name
     * @param array $parameters An array of parameters to pass to the view
     * @param Response $response A Response instance
     *
     * @return Response A Response instance
     *
     * @throws \RuntimeException if the template cannot be rendered
     */
    public function renderResponse($view, array $parameters = array(), Response $response = null)
    {
        if (null === $response) {
            $response = new Response();
        }

        $response->setContent($this->render($view, $parameters));
        return $response;
    }

    /**
     * Renders a template.
     *
     * @param string|TemplateReferenceInterface $name A template name or a TemplateReferenceInterface instance
     * @param array $parameters An array of parameters to pass to the template
     *
     * @return string The evaluated template as a string
     *
     * @throws \RuntimeException if the template cannot be rendered
     */
    public function render($name, array $parameters = array())
    {
        //$templatePath = $this->load($name);
        //$this->fluid->getTemplatePaths()->setTemplatePathAndFilename($templatePath);

        $this->fluid->assignMultiple($parameters);
        $this->fluid->getRenderingContext()->getVariableProvider()->add('container', $this->container);
        $this->fluid->getRenderingContext()->setViewHelperResolver($this->viewHelperResolver);

        return $this->fluid->render($name);
    }

    /**
     * Returns true if the template exists.
     *
     * @param string|TemplateReferenceInterface $name A template name or a TemplateReferenceInterface instance
     *
     * @return bool true if the template exists, false otherwise
     *
     * @throws \RuntimeException if the engine cannot handle the template name
     */
    public function exists($name)
    {
        $this->load($name);

        return true;
    }

    /**
     * Returns true if this class is able to render the given template.
     *
     * @param string|TemplateReferenceInterface $name A template name or a TemplateReferenceInterface instance
     *
     * @return bool true if this class supports the given template, false otherwise
     */
    public function supports($name)
    {
        $template = $this->nameParser->parse($name);
        $engine = $template->get('engine');

        return 'fluid' === $engine || 'html' === $engine;
    }

    private function load($name)
    {
        $template = $this->nameParser->parse($name);
        $template = $this->loader->load($template);

        if ($template === false) {
            throw new \RuntimeException(sprintf(
                'Could not load template "%s"',
                $name
            ));
        }
        return (string)$template;
    }
}
