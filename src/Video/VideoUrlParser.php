<?php declare(strict_types=1);

namespace Torr\EmbedHelpers\Video;

use Torr\EmbedHelpers\Video\Data\VideoDetails;
use Torr\EmbedHelpers\Video\Parser\VideoUrlParserInterface;
use Torr\EmbedHelpers\Video\Parser\VimeoUrlParser;
use Torr\EmbedHelpers\Video\Parser\YouTubeUrlParser;

final class VideoUrlParser
{
	/**
	 */
	public function __construct (
		/** @var iterable<VideoUrlParserInterface> */
		private readonly iterable $parsers,
	) {}

	/**
	 * Parses the video and returns the details
	 */
	public function parseVideoUrl (string $url) : ?VideoDetails
	{
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

	/**
	 *
	 */
	public static function createDefaultParser () : self
	{
		// the parsers are sorted in order of most likely usage
		return new self([
			new YouTubeUrlParser(),
			new VimeoUrlParser(),
		]);
	}
}
