2.1.0
=====

* (improvement) Allow Symfony 8.
* (improvement) Remove unused requires on `symfony/console`, `symfony/string` and `symfony/validator`, add missing require on `symfony/dependency-injection`.
* (improvement) Replace deprecated `#[TaggedIterator]` with `#[AutowireIterator]`.


2.0.0
=====

* (bc) Remove `videoType` from video data.
* (feature) Add new `youtube-short` provider.


1.0.3
=====

* (improvement) Trim URLs before parsing.
* (improvement) Require Symfony 7 and PHP 8.3+.


1.0.2
=====

* (improvement) `VideoDetails::$videoType` is now required and will default to `"video"`.
* (improvement) Renamed the YouTube video type "shorts" to "short".


1.0.1
=====

* (bug) Add missing bundle config.
* (improvement) Add direct getter for `VideoDetails::getEmbedUrl()`.


1.0.0
=====

Initial release `\o/`
