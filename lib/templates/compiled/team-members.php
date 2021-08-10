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
    return '
'.LR::sec($cx, (($inary && isset($in['team_members'])) ? $in['team_members'] : null), null, $in, true, function($cx, $in) {$inary=is_array($in);return '<div class="team_member">
  <div class="row">
    <div class="col-md-3">
      <div class="stretchy-wrapper">
        <div class="photo" style="background-image: url(\''.htmlspecialchars((string)(($inary && isset($in['photo'])) ? $in['photo'] : null), ENT_QUOTES, 'UTF-8').'\')"></div>
      </div>
    </div>
    <div class="col-md-9">
        <h3>
          '.((LR::ifvar($cx, ((isset($cx['scopes'][count($cx['scopes'])-1]) && is_array($cx['scopes'][count($cx['scopes'])-1]) && isset($cx['scopes'][count($cx['scopes'])-1]['linktopage'])) ? $cx['scopes'][count($cx['scopes'])-1]['linktopage'] : null), false)) ? '<a href="'.htmlspecialchars((string)(($inary && isset($in['permalink'])) ? $in['permalink'] : null), ENT_QUOTES, 'UTF-8').'">' : '').''.htmlspecialchars((string)(($inary && isset($in['name'])) ? $in['name'] : null), ENT_QUOTES, 'UTF-8').''.((LR::ifvar($cx, ((isset($cx['scopes'][count($cx['scopes'])-1]) && is_array($cx['scopes'][count($cx['scopes'])-1]) && isset($cx['scopes'][count($cx['scopes'])-1]['linktopage'])) ? $cx['scopes'][count($cx['scopes'])-1]['linktopage'] : null), false)) ? '</a>' : '').'
          <span class="">'.htmlspecialchars((string)(($inary && isset($in['title'])) ? $in['title'] : null), ENT_QUOTES, 'UTF-8').'</span>
        </h3>
        '.(($inary && isset($in['bio'])) ? $in['bio'] : null).'
        <ul class="elementor-icon-list-items elementor">
          <li class="elementor-icon-list-item">
            <a href="tel:'.htmlspecialchars((string)(($inary && isset($in['tel'])) ? $in['tel'] : null), ENT_QUOTES, 'UTF-8').'" style="text-decoration: none;">
              <span class="elementor-icon-list-icon"><i aria-hidden="true" class="fas fa-phone-square-alt"></i></span><span class="elementor-icon-list-text">'.htmlspecialchars((string)(($inary && isset($in['phone'])) ? $in['phone'] : null), ENT_QUOTES, 'UTF-8').'</span>
            </a>
          </li>
          '.((LR::ifvar($cx, (($inary && isset($in['email'])) ? $in['email'] : null), false)) ? '<li class="elementor-icon-list-item">
            <a href="mailto:'.htmlspecialchars((string)(($inary && isset($in['email'])) ? $in['email'] : null), ENT_QUOTES, 'UTF-8').'" style="text-decoration: none;">
              <span class="elementor-icon-list-icon"><i aria-hidden="true" class="fas fa-envelope"></i></span><span class="elementor-icon-list-text">'.htmlspecialchars((string)(($inary && isset($in['email'])) ? $in['email'] : null), ENT_QUOTES, 'UTF-8').'</span>
            </a>
          </li>' : '').'
        </ul>
    </div>
  </div>
  <hr/>
</div>
';}).'';
};
?>