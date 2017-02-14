<?php

namespace FluidAdapter\SymfonyFluidBundle;

use AppBundle\AppBundle;
use FluidAdapter\SymfonyFluidBundle\Fluid\SymfonyTemplatePaths;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\Config\Definition\Exception\Exception;
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
 * @package FluidAdapter\SymfonyFluidBundle
 * @author Christian Spoo <cs@marketing-factory.de>
 */
class FluidEngine implements EngineInterface
{
    /**
     * @var TemplateView
     */
    private $fluid;

    /**
     * @var ViewHelperResolver
     */
    private $viewHelperResolver;

    /**
     * @var TemplateNameParserInterface
     */
    protected $nameParser;

    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(TemplateView $fluid, TemplateNameParserInterface $nameParser, ContainerInterface $container)
    {
        $this->fluid = $fluid;
        $this->nameParser = $nameParser;
        $this->container = $container;

        $this->kernel = $this->container->get('kernel');
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
        $this->fluid->assignMultiple($parameters);
        $this->fluid->getTemplatePaths()->setTemplatePathAndFilename($this->load($name));
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
        return !empty($this->load($name));
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

    protected function load($name)
    {
        if (!preg_match('/^([^:]*):([^:]*):(.+)\.([^\.]+)\.*([^\.]*)$/', $name, $matches)) {
            return $this->fluid->getTemplatePaths()->resolveTemplateFile($name);
        }

        $bundle = $this->kernel->getBundle($matches[1]);
        if (!$bundle instanceof AppBundle) {
            throw new \Exception('Could not find a Bundle named "' . $matches[1] . '"');
        }

        $this->fluid->getTemplatePaths()->addBasePath($bundle->getPath());

        return $this->fluid->getTemplatePaths()->resolveTemplateFileForControllerAndActionAndFormat($matches[2], $matches[3]);
    }
}
