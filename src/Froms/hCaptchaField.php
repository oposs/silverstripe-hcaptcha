<?php

namespace Oposs\hCaptcha\Forms;

use SilverStripe\Control\Controller;
use SilverStripe\Forms\FormField;
use SilverStripe\View\Requirements;

class hCaptchaField extends FormField
{
    /**
     * @var string Your siteKey
     */
    private static $site_key = "";

    /**
     * @var string Your secret key
     */
    private static $secret_key = "";

    /**
     * @var string Currently supports [light|dark]
     */
    private static $data_theme = "light";

    /**
     * @var string Currently supports [normal|invisible|compact]
     */
    private static $data_size = "normal";

    /**
     * @var string Set tabindex
     */
    private static $data_tabindex = "0";

    /**
     * @var bool Submit remote ip in validation requests
     */
    private static $submit_remote_ip = false;

    /**
     * Use this array to configure the options listed here https://docs.hcaptcha.com/configuration
     * Technically you can add arbitrary key/value pairs here
     *
     * @var string[]
     */
    private static $api_configuration = [
        'recaptchacompat' => 'on',
        'render' => 'onload',
    ];

    public function __construct($name, $title = null, $value = null)
    {
        // Set default title
        if ($title === null) $title = _t('Oposs\hCaptcha\Forms\hCaptchaField.DEFAULT_TITLE', 'Spam protection');
        parent::__construct($name, $title, $value);
    }

    /**
     * Validates the h-captcha-response
     * @inerhitDoc
     */
    public function validate($validator): bool
    {

        $captchaResponse = Controller::curr()->getRequest()->requestVar('h-captcha-response');
        $submit_remote_ip = self::config()->get('submit_remote_ip');

        // Empty response
        if (empty($captchaResponse)) {
            $validator->validationError($this->name, _t('Oposs\hCaptcha\Forms\hCaptchaField.EMPTY', '_Please answer the captcha, if you do not see the captcha you must enable JavaScript'));
            return false;
        }

        $validatorRequest = [
            'secret' => self::config()->get('secret_key'),
            'response' => $captchaResponse,
            'sitekey' => self::getSiteKey()
        ];

        // Submit remote ip if enabled
        if ($submit_remote_ip) $validatorRequest['remoteip'] = Controller::curr()->getRequest()->getIP();

        $curlOptions = [
            CURLOPT_URL => 'https://hcaptcha.com/siteverify',
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($validatorRequest),
            CURLOPT_RETURNTRANSFER => true,
        ];
        $verify = curl_init();
        curl_setopt_array($verify, $curlOptions);
        $response = curl_exec($verify);

        $responseData = json_decode($response);
        if ($responseData->success) {
            return true;
        } else {
            $validator->validationError($this->name, _t('Oposs\hCaptcha\Forms\hCaptchaField.VALIDATE_ERROR', '_Captcha could not be validated'));
            return false;
        }

    }

    public function Field($properties = [])
    {
        $siteKey = self::getSiteKey();
        $secretKey = self::config()->get('secret_key');
        $api_config = self::config()->get('api_configuration');

        $url_params = http_build_query($api_config);

        if (empty($siteKey) || empty($secretKey)) {
            user_error('You must configure hCaptcha $site_key and $secret_key', E_USER_ERROR);
        }

        Requirements::javascript("https://js.hcaptcha.com/1/api.js?{$url_params}");

        return parent::Field($properties);
    }

    /**
     * @return string
     */
    public static function getSiteKey(): string
    {
        return self::config()->get('site_key');
    }

    /**
     * @return string
     */
    public static function getDataTheme(): string
    {
        return self::config()->get('data_theme');
    }

    /**
     * @return string
     */
    public static function getDataSize(): string
    {
        return self::config()->get('data_size');
    }

    /**
     * @return string
     */
    public static function getDataTabindex(): string
    {
        return self::config()->get('data_tabindex');
    }


}