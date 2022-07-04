<?php

/**
 * @author Andrey Vinichenko <andrey.vinichenko@gmail.com>
 */

namespace Ameotoko\ContaoEncoreBridge\EventListener;

use Contao\CoreBundle\ServiceAnnotation\Hook;
use Contao\FrontendTemplate;
use Contao\Template;
use Symfony\WebpackEncoreBundle\Asset\TagRenderer;

/**
 * @Hook("parseTemplate")
 */
class EncoreEntryTagsListener
{
    private TagRenderer $tagRenderer;

    public function __construct(TagRenderer $tagRenderer)
    {
        $this->tagRenderer = $tagRenderer;
    }

    public function __invoke(Template $template): void
    {
        if (!$template instanceof FrontendTemplate) {
            return;
        }

        $template->encoreEntryScriptTags = function (string $entryName, string $packageName = null, string $entrypointName = '_default', array $attributes = []): string {
            // return $this->tagRenderer->renderWebpackScriptTags($entryName, $packageName, $entrypointName, $attributes);
            return "Called with $entryName";
        };

        $template->encoreEntryLinkTags = function (string $entryName, string $packageName = null, string $entrypointName = '_default', array $attributes = []): string {
            return $this->tagRenderer->renderWebpackLinkTags($entryName, $packageName, $entrypointName, $attributes);
        };
    }
}
