<?php

return [
  'attr' => [
    'autoplay',
    'controls',
    'class',
    'id',
    'loop',
    'muted',
    'preload',
    'sources',
    'title',
  ],
  'html' => function($tag) {

    /**
     * Declare all variables used by the tag.
     */

    $file = null;
    $filePath = null;
    $autoplay = null;
    $content = [];
    $controls = 'true';
    $class = null;
    $id = null;
    $loop = null;
    $muted = null;
    $preload = null;
    $sources = null;
    $title = null;
    $src = null;

    /**
     * If the tag lead to a file,
     * assing the file to $file variable.
     */

    if ($tag->value) {
      $file = $tag->parent()->file($tag->value);
    }

    /**
     * If there is a file, get it's url
     * and assign it to $filePath. Use $src variable
     * as the tag src attribute for clarity.
     */

    if ($file && $file->exists()) {
      $filePath = $file->url();
      $src = $filePath;
    }

    /**
     * Boolean. If it's here, even set to false
     * the audi element will be played. So if the tag's autoplay
     * is set to true, assign a 'true string to $autoplay.'
     */

     if ($tag->autoplay == 'true') {
       $autoplay = 'true';
     }

     /**
      * Set to true by defaut. If the tag's controls attribute
      * is set to anything else than true, remove it from the
      * audio tag.
      */

     if ($tag->controls) {
       if ($tag->controls == 'true') {
         $controls = 'true';
       } else {
         $controls = null;
       }
     }

    /**
     * If there is a class attribute,
     * assign it's value to $class.
     */

     if ($tag->class) {
       $class = $tag->class;
     }

     /**
      * If there is a id attribute,
      * assign it's value to $id.
      */

     if ($tag->id) {
       $id = $tag->id;
     }

     /**
      * Boolean. If the loop attribute is set to 'true',
      * assign this string to $loop. Then the audio element
      * will be looped.
      */

     if ($tag->loop == 'true') {
       $loop = 'true';
     }

     /**
      * Boolean. If the muted attribute is set to 'true',
      * assign this string to $muted. Then the audio element
      * will be muted.
      */

     if ($tag->muted == 'true') {
       $muted = 'true';
     }

     /**
      * If the prelad tag is set to one of the accepted value
      * assign this value to $preload.
      * - none : audio element will not be cached.
      * - metadata : only metadata are preloaded.
      * - auto : all file can be preloaded.
      * All other value will return null.
      */

     if ($tag->preload) {
       switch ($tag->preload) {
         case 'none':
           $preload = 'none';
           break;

         case 'metadata':
           $preload = 'metadata';
           break;

         case 'auto':
           $preload = 'auto';
           break;
       }
     }

    /**
     * If the sources attribute is not empty,
     * set the $src value as a <source> tag,
     * then genrate a <source> tag foreach source
     * file.
     * Attribute has to be filled with filename
     * separated by a ','.
     */


     if ($tag->sources) {

      /* Split the attribute by ',' */
      $sources = Str::split($tag->sources, ',');

      /* Build the first <source> tag with the $src value */
      $content = [
        Html::tag(
          'source', // Create source tag.
          '', // passing an empty string to generate empty content.
          [
            'src' => $src, // First file path
            'type' => Mime::type($src), // mime type for $src.
          ]
        )
      ];

      /* The reset $src to disable src="" */
      $src = null;

      foreach ($sources as $source) {

        /**
         * If the source attribute lead to a file,
         * build the corresponding <source> tag.
         */

        if ($tag->parent()->file($source)) {

          $sourceFile = $tag->parent()->file($source);
          $sourceFilePath = $sourceFile->url();
          $mime = Mime::type($sourceFilePath);

          $content[] = Html::tag(
            'source', // Create source tag.
            '', // passing an empty string to generate empty content.
            [
              'src' => $sourceFilePath,
              'type' => $mime,
            ]
          );
        }
      }
     }

   /**
    * If there is a title attribute,
    * assign it's value to $title.
    */

    if ($tag->title) {
      $title = $tag->title;
    }

    /**
     * Build a sentence that will be printed
     * with a link to the audio file,
     * if the browser doesn't support html5 audio.
     *
     * Use translation to build the sentences.
     */

    $noSupport = tt(
      'no_support',
      [
        'link' => Html::a(
          $filePath,
          t('no_support_link')
        )
      ]
    );

    $noSupport = Html::tag('p', [$noSupport]);
    $content[] = $noSupport;

    /**
     *
     * Build the <audio> element with all the attributes
     * previously added.
     */

    if ($file && $filePath) {

      $audio = Html::tag(
        'audio',
        $content,
        [
          'autoplay' => $autoplay,
          'controls' => $controls,
          'class' => $class,
          'id' => $id,
          'loop' => $loop,
          'muted' => $muted,
          'preload' => $preload,
          'src' => $src,
          'title' => $title,
        ],
      );
      return $audio;
    }
  }
];
