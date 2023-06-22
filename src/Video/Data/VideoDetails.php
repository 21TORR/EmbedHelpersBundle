<?php declare(strict_types=1);

namespace Torr\EmbedHelpers\Video\Data;

use Torr\EmbedHelpers\Video\VideoPlatform;

final class VideoDetails
{
	/**
	 */
	public function __construct (
		public readonly VideoPlatform $platform,
		public readonly string $id,
		public readonly ?string $videoType = null,
	) {}

	/**
	 */
	public function getEmbedUrl () : string
	{
		return $this->platform->getEmbedUrl($this->id);
	}
}
