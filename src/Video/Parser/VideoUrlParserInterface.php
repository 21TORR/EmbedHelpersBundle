<?php declare(strict_types=1);

namespace Torr\EmbedHelpers\Video\Parser;

use Torr\EmbedHelpers\Video\Data\VideoDetails;

interface VideoUrlParserInterface
{
	/**
	 * Tries to parse the url and return the video details
	 */
	public function parseUrl (string $url) : ?VideoDetails;
}
