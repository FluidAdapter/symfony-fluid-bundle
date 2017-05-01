<?php
namespace FluidAdapter\SymfonyFluidBundle\Translation;

use FluidAdapter\SymfonyFluidBundle\ViewHelpers\TranslateViewHelper;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\Translation\Extractor\AbstractFileExtractor;
use Symfony\Component\Translation\Extractor\ExtractorInterface;
use Symfony\Component\Translation\MessageCatalogue;
use TYPO3Fluid\Fluid\Core\Parser\SyntaxTree\EscapingNode;
use TYPO3Fluid\Fluid\Core\Parser\SyntaxTree\ViewHelperNode;
use TYPO3Fluid\Fluid\Core\Parser\TemplateParser;
use TYPO3Fluid\Fluid\View\TemplateView;

/**
 */
class FluidExtractor extends AbstractFileExtractor implements ExtractorInterface
{
    /**
     * Default domain for found messages.
     *
     * @var string
     */
    private $defaultDomain = 'messages';

    /**
     * Prefix for found message.
     *
     * @var string
     */
    private $prefix = '';

    /**
     * @var TemplateParser
     */
    protected $templateParser;

    /**
     * @var RenderingContextInterface
     */
    protected $renderingContext;

    /**
     * FluidExtractor constructor.
     * @param TemplateView $templateView
     */
    public function __construct(TemplateView $templateView)
    {
        $this->renderingContext = $templateView->getRenderingContext();
        $this->templateParser = $templateView->getRenderingContext()->getTemplateParser();
    }

    /**
     * {@inheritdoc}
     */
    public function extract($resource, MessageCatalogue $catalogue)
    {
        $files = $this->extractFiles($resource);
        foreach ($files as $file) {
            echo $file->getPathname() . chr(10);
            $this->extractTemplate(file_get_contents($file->getPathname()), $catalogue);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;
    }

    protected function extractTemplate($template, MessageCatalogue $catalogue)
    {
        $parsingState = $this->templateParser->parse($template);
        $this->nodeVisitor($parsingState->getRootNode(), $catalogue);
    }

    /**
     * @param $node
     * @param MessageCatalogue $catalogue
     */
    protected function nodeVisitor($node, MessageCatalogue $catalogue) {
        if ($node instanceof ViewHelperNode && $node->getViewHelperClassName() == TranslateViewHelper::class) {
            try {
                $node->evaluate($this->renderingContext);
                $arguments = $node->getUninitializedViewHelper()->getArguments();
                var_dump($arguments['text']);
                $catalogue->set($arguments['text'], $this->prefix.trim($arguments['text']), $arguments['domain'] ?: $this->defaultDomain);
            } catch(\Exception $e) {

            }
        }
        if ($node instanceof EscapingNode) {
            $this->nodeVisitor($node->getNode(), $catalogue);
        }
        foreach ($node->getChildNodes() as $childNode) {
            $this->nodeVisitor($childNode, $catalogue);
        }
    }

    /**
     * @param string $file
     *
     * @return bool
     */
    protected function canBeExtracted($file)
    {
        return $this->isFile($file) && 'twig' === pathinfo($file, PATHINFO_EXTENSION);
    }

    /**
     * @param string|array $directory
     *
     * @return array
     */
    protected function extractFromDirectory($directory)
    {
        $finder = new Finder();

        return $finder->files()->name('*.html')->in($directory);
    }
}
