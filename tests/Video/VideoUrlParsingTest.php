<?php declare(strict_types=1);

namespace Video;

use PHPUnit\Framework\TestCase;
use Torr\EmbedHelpers\Video\Parser\VimeoUrlParser;
use Torr\EmbedHelpers\Video\Parser\YouTubeUrlParser;
use Torr\EmbedHelpers\Video\VideoPlatform;
use Torr\EmbedHelpers\Video\VideoUrlParser;

final class VideoUrlParsingTest extends TestCase
{
	/**
	 *
	 */
	public static function provideTestCases () : iterable
	{
		// YouTube: valid
		yield "youtube http" => ["http://www.youtube.com/watch?v=1234567890_", VideoPlatform::YouTube, "1234567890_"];
		yield "youtube https" => ["https://www.youtube.com/watch?v=1234567890_", VideoPlatform::YouTube, "1234567890_"];
		yield "youtube/v" => ["https://www.youtube.com/v/1234567890_?a=3&b=1", VideoPlatform::YouTube, "1234567890_"];
		yield "youtube/shorts" => ["https://www.youtube.com/shorts/1234567890_?a=3&b=1", VideoPlatform::YouTubeShort, "1234567890_"];
		yield "youtube/embed" => ["https://www.youtube.com/embed/1234567890_?a=3&b=1", VideoPlatform::YouTube, "1234567890_"];
		yield "youtu.be https" => ["https://youtu.be/1234567890_", VideoPlatform::YouTube, "1234567890_"];
		yield "youtu.be http" => ["http://youtu.be/1234567890_", VideoPlatform::YouTube, "1234567890_"];
		yield "youtube/oembed" => ["https://www.youtube.com/oembed?url=http%3A//www.youtube.com/watch?v%3D1234567890_&format=json", VideoPlatform::YouTube, "1234567890_"];
		yield "youtube http with space" => ["https://www.youtube.com/watch?v=1234567890_ ", VideoPlatform::YouTube, "1234567890_"];

		// YouTube: invalid
		yield "youtube/watch invalid id" => ["http://www.youtube.com/watch?v=123456789012", null];
		yield "youtube/watch missing query" => ["https://www.youtube.com/watch?missing", null];
		yield "youtube/v id too long" => ["https://www.youtube.com/v/123456789012?a=3&b=1", null];
		yield "youtube/v sub path" => ["https://www.youtube.com/v/1234567890_/sub?a=3&b=1", null];
		yield "youtu.be sub after" => ["https://youtu.be/1234567890_/sub", null];
		yield "youtu.be sub before" => ["https://youtu.be/sub/1234567890_", null];
		yield "youtu.be id too long" => ["https://youtu.be/123456789012", null];
		yield "youtube/oembed id too long" => ["https://www.youtube.com/oembed?url=http%3A//www.youtube.com/watch?v%123456789012&format=json", null];
		yield "youtube/oembed invalid query parameter" => ["https://www.youtube.com/oembed?url=http%3A//www.youtube.com/watch?a%3D1234567890_&format=json", null];
		yield "youtube/embed id too long" => ["https://youtube.com/embed/123456789012", null];
		yield "youtube/embed sub after" => ["https://youtube.com/embed/1234567890_/sub", null];
		yield "youtube/embed sub before" => ["https://youtube.com/embed/sub/1234567890_", null];

		// Vimeo: valid
		yield "vimeo https" => ["http://vimeo.com/123456789", VideoPlatform::Vimeo, "123456789"];
		yield "vimeo http" => ["https://vimeo.com/123456789", VideoPlatform::Vimeo, "123456789"];
		yield "vimeo with query" => ["https://vimeo.com/123456789?q=uery", VideoPlatform::Vimeo, "123456789"];
		yield "vimeo with fragment" => ["https://vimeo.com/123456789#fragment", VideoPlatform::Vimeo, "123456789"];
		yield "vimeo with query + fragment" => ["https://vimeo.com/123456789?q=uery#fragment", VideoPlatform::Vimeo, "123456789"];
		yield "vimeo staff picks" => ["https://vimeo.com/channels/staffpicks/123456789", VideoPlatform::Vimeo, "123456789"];

		// Vimeo: invalid
		yield "vimeo with before path" => ["https://vimeo.com/before/123456789", null];
		yield "vimeo with after path" => ["https://vimeo.com/123456789/after", null];
		yield "vimeo with before + after path" => ["https://vimeo.com/before/123456789/after", null];
	}

	/**
	 * @dataProvider provideTestCases
	 */
	public function testParsing (
		string $url,
		?VideoPlatform $expectedPlatform,
		?string $expectedId = null,
	) : void
	{
		$parser = new VideoUrlParser([
			new YouTubeUrlParser(),
			new VimeoUrlParser(),
		]);
		$result = $parser->parseVideoUrl($url);

		if (null === $expectedPlatform)
		{
			self::assertNull($result);
		}
		else
		{
			self::assertNotNull($result);
			self::assertSame($expectedPlatform, $result->platform);
			self::assertSame($expectedId, $result->id);
		}
	}
}
