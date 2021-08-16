<?php
use \LightnCandy\SafeString as SafeString;use \LightnCandy\Runtime as LR;return function ($in = null, $options = null) {
    $helpers = array();
    $partials = array();
    $cx = array(
        'flags' => array(
            'jstrue' => false,
            'jsobj' => false,
            'jslen' => false,
            'spvar' => true,
            'prop' => false,
            'method' => false,
            'lambda' => false,
            'mustlok' => false,
            'mustlam' => false,
            'mustsec' => false,
            'echo' => false,
            'partnc' => false,
            'knohlp' => false,
            'debug' => isset($options['debug']) ? $options['debug'] : 1,
        ),
        'constants' => array(),
        'helpers' => isset($options['helpers']) ? array_merge($helpers, $options['helpers']) : $helpers,
        'partials' => isset($options['partials']) ? array_merge($partials, $options['partials']) : $partials,
        'scopes' => array(),
        'sp_vars' => isset($options['data']) ? array_merge(array('root' => $in), $options['data']) : array('root' => $in),
        'blparam' => array(),
        'partialid' => 0,
        'runtime' => '\LightnCandy\Runtime',
    );
    
    $inary=is_array($in);
    return '<div class="row center-xs events">
  <div class="content">
    <div class="col-md">
      <h2>ETEC Friday Meetings</h2>
    </div>
  </div>
</div>
<div class="row center-xs events">
'.LR::sec($cx, (($inary && isset($in['events'])) ? $in['events'] : null), null, $in, true, function($cx, $in) {$inary=is_array($in);return '    <div class="col-sm event">
      <a href="'.htmlspecialchars((string)(($inary && isset($in['permalink'])) ? $in['permalink'] : null), ENT_QUOTES, 'UTF-8').'"><img src="'.htmlspecialchars((string)(($inary && isset($in['thumbnail'])) ? $in['thumbnail'] : null), ENT_QUOTES, 'UTF-8').'" width="400" height="300" /></a>
      <h3 class="title"><a href="'.htmlspecialchars((string)(($inary && isset($in['permalink'])) ? $in['permalink'] : null), ENT_QUOTES, 'UTF-8').'">'.htmlspecialchars((string)(($inary && isset($in['title'])) ? $in['title'] : null), ENT_QUOTES, 'UTF-8').'</a></h3>
      <p>'.(($inary && isset($in['details'])) ? $in['details'] : null).'</p>
    </div>
';}).'</div>';
};
?>