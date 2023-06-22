<?php declare(strict_types=1);

namespace Torr\EmbedHelpers;

use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Torr\BundleHelpers\Bundle\BundleExtension;

final class TorrEmbedHelpersBundle extends Bundle
{
	/**
	 *
	 */
	public function getContainerExtension () : ?ExtensionInterface
	{
		return new BundleExtension($this);
	}
}
