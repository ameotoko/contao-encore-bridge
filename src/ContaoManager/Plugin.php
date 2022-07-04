<?php

/**
 * @author Andrey Vinichenko <andrey.vinichenko@gmail.com>
 */

namespace Ameotoko\ContaoEncoreBridge\ContaoManager;

use Ameotoko\ContaoEncoreBridge\AmeotokoContaoEncoreBridgeBundle;
use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Symfony\WebpackEncoreBundle\WebpackEncoreBundle;

class Plugin implements BundlePluginInterface
{
    public function getBundles(ParserInterface $parser): array
    {
        return [
            BundleConfig::create(WebpackEncoreBundle::class),
            BundleConfig::create(AmeotokoContaoEncoreBridgeBundle::class)
                ->setLoadAfter([ContaoCoreBundle::class, WebpackEncoreBundle::class]),
        ];
    }
}
