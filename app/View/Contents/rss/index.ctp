<?php
$this->set('documentData', array(
    'xmlns:dc' => 'http://purl.org/dc/elements/1.1/'));

$this->set('channelData', array(
    'title' => 'مطالب جدید',
    'link' => $this->Html->url(array(
        'controller' => 'Contents', 
        'action' => 'index', 
        'ext' => 'rss'
        ), true),
    'description' => 'مطالب جدید',
    'language' => 'en-us'));
    
App::uses('Sanitize', 'Utility');

foreach ($contents as $content) {
    $description = $content['Content']['intro'];

  echo $this->Rss->item(array(), array(
    'title' => $content['Content']['title'],
    'link' => array( 
        'controller' => 'Contents', 
        'action' => 'view',
        $content['Content']['id'].'-'.$content['Content']['slug'],
    ),
    'description' => Sanitize::stripScripts($description),
    'pubDate' => Jalali::gregorian($content['Content']['created']),
  ));

}
