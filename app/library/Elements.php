<?php

/**
 * Elements
 *
 * Helps to build UI elements for the application
 */
class Elements extends Phalcon\Mvc\User\Component
{

    private $_placeholderImageUrlBase = 'http://placehold.it/';

    public function placeholderImageUrl($width, $height, $text = '', $bg = 'CCC', $color = 'FFF') {
        return 'http://placehold.it/'.$width.'x'.$height.'/'.$bg.'/'.$color.(strlen($text) > 0 ? '&text='.$text : '');
    }

    public function placeholderImageTag($width, $height, $text = '', $className = '', $bg = 'CCC', $color = 'FFF') {
        return '<img src="'.$this->placeholderImageUrl($width, $height, $text, $bg, $color).'" alt="'.$text.'"'.(strlen($className) > 0 ? ' class="'.$className.'"' : '').' />';
    }

    private $_adminMenu = array(
        'main-menu' => array(
        ),
        'signin-menu' => array(
            'login' => array(
                'caption' => 'Log out',
                'action' => 'end'
            ),
        )
    );

    /**
     * Builds header menu with left and right items
     *
     * @return string
     */
    public function outputAdminMenu()
    {

        $auth = $this->session->get('auth');
        if (!$auth) {
            return '';
        }

        echo '<nav>';
        $controllerName = $this->view->getControllerName();
        foreach ($this->_adminMenu as $menuClassName => $menu) {
            echo '<ul class="', $menuClassName, '">';
            foreach ($menu as $controller => $option) {
                if ($controllerName == $controller) {
                    echo '<li class="active">';
                } else {
                    echo '<li>';
                }
                $url = ($controller=='index'?'':$controller).($option['action']=='index'?'':'/'.$controller);
                echo Phalcon\Tag::linkTo($url, $option['caption']);
                echo '</li>';
            }
            echo '</ul>';
        }
        echo '</nav>';
    }
}
