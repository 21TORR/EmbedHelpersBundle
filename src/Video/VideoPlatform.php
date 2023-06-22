<?php declare(strict_types=1);

namespace Torr\EmbedHelpers\Video;

enum VideoPlatform : string
{
	case YouTube = "youtube";

	case Vimeo = "vimeo";
}
