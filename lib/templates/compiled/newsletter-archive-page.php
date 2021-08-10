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
    return '<html>
<head>
  <title>ETEC Newsletter Archive</title>
  <style type="text/css">
  body{
    font-family: \'Helvetica Neue\', Arial, sans-serif;
    font-size: 1em;
  }
  .wrapper{
    max-width: 680px;
    margin: 40px auto;
    background: #eee;
    padding: 1.5em 2em;
    border-radius: 10px;
  }
  h1{
    margin: 0 0 1em 0;
  }
  </style>
</head>
<body>
  <div class="wrapper">
    <h1>ETEC Newsletter Archive</h1>
    <ul>
'.LR::sec($cx, (($inary && isset($in['newsletters'])) ? $in['newsletters'] : null), null, $in, true, function($cx, $in) {$inary=is_array($in);return '      <li><a href="'.htmlspecialchars((string)(($inary && isset($in['permalink'])) ? $in['permalink'] : null), ENT_QUOTES, 'UTF-8').'">'.(($inary && isset($in['title'])) ? $in['title'] : null).'</a></li>
';}).'    </ul>
  </div>
</body>
</html>';
};
?>