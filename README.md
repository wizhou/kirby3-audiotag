# Kirby3 Audio tag plugin

## Introduction

This *kirbytag* creates an HTML5 `<audio>` element with any given audio file.

It can support multiple `<source>`, can be set with many attributes and provide a translatable sentence to show on browsers that [doesn't support HTML5 audio element](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/audio#Browser_compatibility).

## Installation
This plugin was built using Kirby 3. It will not work on earlier versions.

### Download

[Download the files](https://github.com/wizhou/kirby3-audiotag/archive/master.zip) and place them inside `site/plugins/kirby3-audiotag`.

### Git Submodule

You can add the plugin as a Git submodule.

~~~~ shell
cd your/project/root
git submodule add https://github.com/wizhou/kirby3-audiotag.git site/plugins/kirby3-audiotag
git submodule update --init --recursive
git commit -am "Add Kirby Audiotag plugin"
~~~~

Run these commands to update the plugin:

~~~~ shell
cd your/project/root
git submodule foreach git checkout master
git submodule foreach git pull
git commit -am "Update submodules"
git submodule update --init --recursive
~~~~

### Composer

You can install the plugin with composer.

~~~~ shell
composer require wizhou/kirby3-audiotag
~~~~

## Usage

### Minimal usage
For a minimal usage, and similar to an `image()` *kirbytag*, upload an audio file into your page and give it to the *kirbytag* with its extension.

~~~~ md
audio(audiofile.mp3)
~~~~

The following `<audio>` element will be generated :

~~~~ html
<audio controls="true" src="audiofile.mp3">
  <p>Your browser does not support the <code>audio</code> element. Here is a <a href="audiofile.mp3">link to the audio file </a> to download it.</p>
</audio>
~~~~

The `controls` attribute is set by default. To remove it, use the following attribute :

~~~~ md
audio(audiofile.mp3 controls: false)
~~~~

If you don't want to use the `control` attribute, thus the audio player won't include the browser's default controls. You can, however, create your own custom controls using JavaScript and the [HTMLMediaElement API](https://developer.mozilla.org/en-US/docs/Web/API/HTMLMediaElement).

### Advanced usage

Many attributes can be used inside the *kirbytag*.

| Attribute | Value | Description |
|-----------|-------|-------------|
| `autoplay` | `true` | Set to `true` to autoplay the audio. Any other value will not render the attribute, as the audio will autoplay even if it's set to false. |
| `controls` | `true`, `false` | Allow the browser to offer controls to allow the user to conrol audio playback, including volume, seeking, and pause/resume playback. Set to `true` by default. |
| `class` | String | Add any class to the `<audio>` element. |
| `id`| String | Add any id to the `<audio>` element.|
| `loop` | `true`, `false` | If specified, the audio player will restart upon the end of the audio. |
| `muted` | `true`, `false` | If specified, the audio player will be initially silenced. |
| `preload` | `none`, `metadata`, `auto` | Provide a hint to the browser about the file loading. `none` indicates that the audio should not be preloaded, `metadata` indicates that only audio metadata is fetched, `auto` indicates that the whole audio file can be downloaded. |
| `sources` | `audiofile.mp3, audiofile.ogg, audiofile.vorbis` … | You can provide mutliple source for the audio element. Then the browser will use the first one it undersand. You have to spearate eache filename with `,`. |


### Source

You can provide any amount of source audio files with the `source:` attribute.

It will replace the `src=""` attribute of the `<audio>` element with `<source>` elements. The audio file specified by calling the *kirbytag* will also be implemented as a source.

Also, the MIME type of each source will be added as a `type=""` attribute to the `<source>` element with the `Mime::type()` [class](https://getkirby.com/docs/reference/tools/mime/type).

~~~~
(audio: audiofile.mp3 sources: audiofile.vorbis, audiofile.ogg, audiofile.waw)
~~~~

Will turn into

~~~~ html
<audio controls="true">
  <source src="audiofile.mp3" type="audio/mpeg">
  <source src="audiofile.vorbis" type="audio/vorbis">
  <source src="audiofile.ogg" type="audio/ogg">
  <source src="audiofile.waw" type="audio/waw">
  <p>Your browser does not support the <code>audio</code> element. Here is a <a href="audiofile.mp3">link to the audio file </a> to download it.</p>
</audio>
~~~~

### Fallback

For viewers who use a browser in which the `<audio>` element is not supported, there is some content included inside the audio element.

It is composed of a sentence and a direct download link to the audio file.

~~~~ html
<p>Your browser does not support the <code>audio</code> element. Here is a <a href="audiofile.mp3">link to the audio file </a> to download it.</p>
~~~~

The plugin use the translate by key `tt()` [helper](https://getkirby.com/docs/reference/templates/helpers/tt) to provide the sentence, it is builded as follow :

~~~~ php
<?php
tt('no_support', [
  'link' => Html::a($filePath, t('no_support_link'))
]);
~~~~

You can overide by changing the value of `no_support` and `no_support_link` inside a translation file and a plugin.

~~~~ php
<?php
'translations' => [
  'en' => [
    'no_support' => 'Your browser does not support the <code>audio</code> element. Here is a { link } to download it.',
    'no_support_link' => 'link to the audio file '
  ]
]
~~~~

For now, english and french translations are included in the plugin, in the future more translation will be added.


## Help

Please [create an issue](https://github.com/wizhou/kirby3-audiotag/issues/new) if you encounter any difficulties while using the plugin.


## Contributing & Roadmap

Any contribution will be welcome !

- [ ] Implement `crossorigin` as attribute.
- [ ] Implement `currentTime` as attribute.
- [ ] Add more tranlsation for the fallback content.

## Disclaimer

This plugin is provided "as is" with no guarantee. Use it at your own risk and always test it yourself before using it in a production environment. If you encounter any problem, please [create an issue](https://github.com/wizhou/kirby3-audiotag/issues/new).

## License

This project is licensed under MIT license.

****

More infomation about the HTML 5 `<audio>` element :
- [\<audio>: The Embed Audio element](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/audio)
- [Video and audio content](https://developer.mozilla.org/en-US/docs/Learn/HTML/Multimedia_and_embedding/Video_and_audio_content)
