<?php declare(strict_types=1);

namespace Video;

use PHPUnit\Framework\TestCase;
use Torr\EmbedHelpers\Video\VideoPlatform;

final class VideoPlatformTest extends TestCase
{
	/**
	 *
	 */
	public function testEmbedUrls () : void
	{
		self::assertSame("https://vimeo.com/123", VideoPlatform::Vimeo->getEmbedUrl("123"));
		self::assertSame("https://www.youtube.com/embed/123", VideoPlatform::YouTube->getEmbedUrl("123"));
	}
}
