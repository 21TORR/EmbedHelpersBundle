<?php declare(strict_types=1);

namespace Torr\EmbedHelpers\Video\Parser;

use Torr\EmbedHelpers\Video\Data\VideoDetails;
use Torr\EmbedHelpers\Video\VideoPlatform;

final class VimeoUrlParser implements VideoUrlParserInterface
{
	/**
	 * @inheritDoc
	 */
	public function parseUrl (string $url) : ?VideoDetails
	{
		$id = $this->parseVideoId($url);

		return (null !== $id)
			? new VideoDetails(
				VideoPlatform::Vimeo,
				$id,
				\sprintf("https://vimeo.com/%s", $id),
				"video",
			)
			: null;
	}

	/**
	 *
	 */
	private function parseVideoId (string $url) : ?string
	{
		$urlParts = \parse_url($url);
		$host = $urlParts["host"] ?? null;
		$path = $urlParts["path"] ?? "";

		return ("vimeo.com" === $host && \preg_match("~^/(?:channels/[^/]+/)?(?<id>\\d+)$~", $path, $matches))
			? $matches["id"]
			: null;
	}
}
