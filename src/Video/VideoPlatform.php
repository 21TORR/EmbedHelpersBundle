<?php declare(strict_types=1);

namespace Torr\EmbedHelpers\Video;

enum VideoPlatform : string
{
	case Vimeo = "vimeo";

	case YouTube = "youtube";

	case YouTubeShort = "youtube-short";

	/**
	 *
	 */
	public function getEmbedUrl (string $id) : string
	{
		return match ($this)
		{
			self::Vimeo => \sprintf("https://vimeo.com/%s", $id),
			self::YouTube,
			self::YouTubeShort => \sprintf("https://www.youtube.com/embed/%s", $id),
		};
	}
}
