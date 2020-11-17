<?php

namespace App\View\Helper;

use Cake\View\Helper\HtmlHelper;

class MyHtmlHelper extends HtmlHelper
{

    public function component($path, $type = 'css', array $options = array())
    {
        $path = '/bower_components/' . $path;
        return parent::{$type}($path, $options);
    }

    public function image($path, array $options = [])
    {
        if (!array_key_exists('onerror', $options)) {
            $options['onerror'] = "this.onerror=null;this.src='/img/not-found.png';";
        }
        if (array_key_exists('onerror-image', $options)) {
            if (is_string($options['onerror-image'])) {
                $errorImagePath = $this->Url->image($options['onerror-image'], $options);
            } else {
                $errorImagePath = $this->Url->build($$options['onerror-image'], $options);
            }
            $options['onerror'] = "this.onerror=null;this.src='{$errorImagePath}';";
            unset($options['onerror-image']);
        }
        return parent::image($path, $options);
    }
}
