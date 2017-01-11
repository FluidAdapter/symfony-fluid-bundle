<?php
namespace FluidAdapter\SymfonyFluidBundle\Fluid;

/*
 * This file belongs to the package "TYPO3 Fluid".
 * See LICENSE.txt that was shipped with this package.
 */
use Symfony\Component\DependencyInjection\ContainerInterface;
use TYPO3Fluid\Fluid\View\Exception\InvalidTemplateResourceException;
use TYPO3Fluid\Fluid\View\TemplatePaths;

/**
 * Template Paths Holder
 *
 * Class used to hold and resolve template files
 * and paths in multiple supported ways.
 *
 * The purpose of this class is to homogenise the
 * API that is used when working with template
 * paths coming from TypoScript, as well as serve
 * as a way to quickly generate default template-,
 * layout- and partial root paths by package.
 *
 * The constructor accepts two different types of
 * input - anything not of those types is silently
 * ignored:
 *
 * - a `string` input is assumed a package name
 *   and will call the `fillDefaultsByPackageName`
 *   value filling method.
 * - an `array` input is assumed a TypoScript-style
 *   array of root paths in one or more of the
 *   supported structures and will call the
 *   `fillFromTypoScriptArray` method.
 *
 * Either method can also be called after instance
 * is created, but both will overwrite any paths
 * you have previously configured.
 */
class SymfonyTemplatePaths extends \TYPO3Fluid\Fluid\View\TemplatePaths
{

    const DEFAULT_TEMPLATES_DIRECTORY = '/Resources/views/Templates/';
    const DEFAULT_LAYOUTS_DIRECTORY = '/Resources/views/Layouts/';
    const DEFAULT_PARTIALS_DIRECTORY = '/Resources/views/Partials/';

    public function __construct(ContainerInterface $container)
    {
        $bundle = $container->get('kernel')->getBundle('FluidBundle');
        $this->addBasePath($bundle->getPath() . '/..');
        $this->addBasePath($container->getParameter('kernel.root_dir'));
    }

    /**
     * @param array $path
     * @return void
     * @api
     */
    public function addBasePath($path)
    {
        $this->templateRootPaths[] = $path . self::DEFAULT_TEMPLATES_DIRECTORY;
        $this->layoutRootPaths[] = $path . self::DEFAULT_LAYOUTS_DIRECTORY;
        $this->partialRootPaths[] = $path . self::DEFAULT_PARTIALS_DIRECTORY;
    }

    /**
     * Tries to locate a Template file based on the provided path inside the templates directory
     *
     * @param string $path
     * @param string $format
     * @return string|NULL
     * @api
     */
    public function resolveTemplateFile($path, $format = self::DEFAULT_FORMAT)
    {
        if ($this->templatePathAndFilename !== null) {
            return $this->templatePathAndFilename;
        }
        if (!array_key_exists($path, self::$resolvedFiles['templates'])) {
            $templateRootPaths = $this->getTemplateRootPaths();
            try {
                return self::$resolvedFiles['templates'][$path] = $this->resolveFileInPaths($templateRootPaths, $path,
                    $format);
            } catch (InvalidTemplateResourceException $error) {
                self::$resolvedFiles['templates'][$path] = null;
            }
        }

        return isset(self::$resolvedFiles[self::NAME_TEMPLATES][$path]) ? self::$resolvedFiles[self::NAME_TEMPLATES][$identifier] : null;
    }

}
