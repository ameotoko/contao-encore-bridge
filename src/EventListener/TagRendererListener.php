<?php

/**
 * @author Andrey Vinichenko <andrey.vinichenko@gmail.com>
 */

namespace Ameotoko\ContaoEncoreBridge\EventListener;

use Symfony\WebpackEncoreBundle\Event\RenderAssetTagEvent;

class TagRendererListener
{
    private string $projectDir;
    private string $webDir;

    public function __construct(string $projectDir, string $webDir)
    {
        $this->projectDir = $projectDir;
        $this->webDir = $webDir;
    }

    public function __invoke(RenderAssetTagEvent $event): RenderAssetTagEvent
    {
        $attributes = $event->getAttributes();
        $attribute = $event->isLinkTag() ? 'href' : 'src';

        $src = $attributes[$attribute];
        $mtime = null;

        // Add the filemtime if not an external file
        if (!preg_match('@^https?://@', $src)) {
            if (file_exists($this->projectDir . '/' . $src)) {
                $mtime = filemtime($this->projectDir . '/' . $src);
            } else {
                // Handle public bundle resources in the contao.web_dir folder
                if (file_exists($this->webDir . '/' . $src)) {
                    $mtime = filemtime($this->webDir . '/' . $src);
                }
            }
        }

        if ($mtime) {
            $src .= '?v=' . substr(md5($mtime), 0, 8);
        }

        $event->setAttribute($attribute, $src);

        return $event;
    }
}
