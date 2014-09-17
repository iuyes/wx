<?php
/**
 * menu
 */
$setting = array(
    'title' => '微信接口处理',
    'header' => '微信接口处理',
    'header_small' => 'ColdMaker',
    'default_url' => 'home.html',
);
$menu = array(
    array(
        'title' => '设置信息',
        'icon' => 'fa-cogs',
        'sub_menu' => array(
            array('title' => '设置信息','icon' => 'fa-cog','url' => 'home.html'),
        )
    ),
    array(
        'title' => '回复信息',
        'icon' => 'fa-wechat',
        'sub_menu' => array(
            array(
                'title' => '关注回复',
                'icon' => 'fa-user',
                'url' => 'home.html'
            ),
            array(
                'title' => '图文回复',
                'icon' => 'fa-paw',
                'url' => 'home.html'
            ),
            array(
                'title' => '文本回复',
                'icon' => 'fa-font',
                'url' => 'http://zealand.d-bluesoft.com',
            )
        )
    ),
    array(
        'title' => '自定义菜单',
        'icon' => 'fa-sitemap',
        'sub_menu' => array(
            array(
                'title' => '菜单设置',
                'icon' => 'fa-user',
                'url' => 'list.html'
            )
        )
    ),
    array(
        'title' => '帮助',
        'icon' => 'fa-user',
        'sub_menu' => array(
            array(
                'title' => 'FontAwesome图标',
                'icon' => 'fa-book',
                'url' => 'http://fortawesome.github.io/Font-Awesome/icons/',
            )
        )
    )
);
$setting['menu'] = $menu;
return json_encode($setting);
?>
