<?php declare(strict_types=1);

namespace Torr\EmbedHelpers\Video\Parser;

use Torr\EmbedHelpers\Video\Data\VideoDetails;
use Torr\EmbedHelpers\Video\VideoPlatform;

final class YouTubeUrlParser implements VideoUrlParserInterface
{
	private const ID_PATTERN = "(?<id>[a-zA-Z0-9_-]{11})";

	/**
	 * @inheritDoc
	 */
	public function parseUrl (string $url) : ?VideoDetails
	{
		$urlParts = \parse_url($url);
		$host = $urlParts["host"] ?? null;
		$path = $urlParts["path"] ?? "";
		\parse_str($urlParts["query"] ?? "", $query);

		if ("youtube.com" === $host || "www.youtube.com" === $host)
		{
			if ("/watch" === $path)
			{
				return isset($query["v"]) && \is_string($query["v"])
					? $this->createVideoDetails($query["v"])
					: null;
			}

			if (\preg_match('~^/(?<type>v|embed|shorts)/(?<id>.*?)$~', $path, $match))
			{
				return $this->createVideoDetails(
					$match["id"],
					isFullVideo: "shorts" !== $match["type"],
				);
			}

			if ("/oembed" === $path)
			{
				return isset($query["url"]) && \is_string($query["url"])
					? $this->parseUrl($query["url"])
					: null;
			}
		}

		if ("youtu.be" === $host)
		{
			if (\preg_match(
				'~^/(?<id>.*?)$~',
				$path,
				$match,
			))
			{
				return $this->createVideoDetails($match["id"]);
			}
		}

		return null;
	}

	/**
	 *
	 */
	private function createVideoDetails (
		string $id,
		bool $isFullVideo = true,
	) : ?VideoDetails
	{
		if (\preg_match(
			\sprintf('~^%s$~', self::ID_PATTERN),
			$id,
		))
		{
			return new VideoDetails(
				$isFullVideo
					? VideoPlatform::YouTube
					: VideoPlatform::YouTubeShort,
				$id,
			);
		}

		return null;
	}
}
