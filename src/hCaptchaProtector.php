<?php

namespace Oposs\hCaptcha;


use Oposs\hCaptcha\Forms\hCaptchaField;

class hCaptchaProtector implements \SilverStripe\SpamProtection\SpamProtector
{

    /**
     * @inheritDoc
     */
    public function getFormField($name = 'hCaptcha', $title = 'Captcha', $value = null)
    {
        return new hCaptchaField($name, $title);

    }

    /**
     * @inheritDoc
     */
    public function setFieldMapping($fieldMapping)
    {
        //Not used
    }
}