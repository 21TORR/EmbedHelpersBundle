<?php declare(strict_types=1);

namespace Torr\EmbedHelpers\Video\Parser;

use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;
use Torr\EmbedHelpers\Video\Data\VideoDetails;
use Torr\EmbedHelpers\Video\VideoUrlParser;

#[AutoconfigureTag(VideoUrlParser::SERVICE_LOCATOR_TAG)]
interface VideoUrlParserInterface
{
	/**
	 * Tries to parse the url and return the video details
	 */
	public function parseUrl (string $url) : ?VideoDetails;
}
