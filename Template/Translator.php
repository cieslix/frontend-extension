<?php

namespace Creativestyle\FrontendExtension\Template;

class Translator
{
    public function translate($args)
    {
        if(!is_array($args)){
            $args = [$args];
        }

        return call_user_func_array('__', $args);
    }
}