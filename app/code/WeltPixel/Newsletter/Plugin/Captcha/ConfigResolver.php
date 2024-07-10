<?php

namespace WeltPixel\Newsletter\Plugin\Captcha;

use Magento\ReCaptchaUi\Model\UiConfigResolverInterface;

class ConfigResolver
{
    /**
     * @param UiConfigResolverInterface $subject
     * @param string $key
     * @return string[]
     */
    public function beforeGet(
        UiConfigResolverInterface $subject,
        string $key
    ) {
        if (in_array($key, ['wpn-recaptcha-newsletter'])) {
            $key = 'newsletter';
        }

        return [$key];
    }
}
