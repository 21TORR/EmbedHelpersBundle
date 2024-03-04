<?php declare(strict_types=1);

namespace Torr\EmbedHelpers\Video;

use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;
use Torr\EmbedHelpers\Video\Data\VideoDetails;
use Torr\EmbedHelpers\Video\Parser\VideoUrlParserInterface;

/**
 * The parser manager that manages all dedicated platform-specific partners
 */
final class VideoUrlParser
{
	public const SERVICE_LOCATOR_TAG = "21torr.embed-helpers.video-url-parser";

	/**
	 */
	public function __construct (
		/** @var iterable<VideoUrlParserInterface> */
		#[TaggedIterator(self::SERVICE_LOCATOR_TAG)]
		private readonly iterable $parsers,
	) {}

	/**
	 * Parses the video and returns the details
	 */
	public function parseVideoUrl (string $url) : ?VideoDetails
	{
		$url = \trim($url);

		foreach ($this->parsers as $parser)
		{
			$details = $parser->parseUrl($url);

			if (null !== $details)
			{
				return $details;
			}
		}

		return null;
	}
}
