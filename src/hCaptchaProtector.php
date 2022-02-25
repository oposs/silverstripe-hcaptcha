<?php

namespace Oetiker\hCaptcha;


use Oetiker\hCaptcha\Forms\hCaptchaField;

class hCaptchaProtector implements \SilverStripe\SpamProtection\SpamProtector
{

    /**
     * @inheritDoc
     */
    public function getFormField($name = 'hCaptcha', $title = 'hCaptcha', $value = null)
    {
        return new hCaptchaField($name, $title, $value);
    }

    /**
     * @inheritDoc
     */
    public function setFieldMapping($fieldMapping)
    {
        // TODO: Implement setFieldMapping() method.
    }
}