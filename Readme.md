# hCaptcha spam protection

Protect your forms with [hCaptcha](https://www.hcaptcha.com/), a GDPR, CCPA, LGPD, PIPL and more compliant spam prodection
(according their website) 

## Installation

Make sure you met the following requirements beforehand:

- SilverStripe 4.x
- SilverStripe Spam Protection 3.x
- PHP CURL and JSON

```
composer require oposs/silverstripe-hcaptcha dev
```

And set hCaptcha as your default spamprotector:

```yaml

SilverStripe\SpamProtection\Extension\FormSpamProtectionExtension:
  default_spam_protector: Oposs\hCaptcha\hCaptchaProtector

```

## Configuration

In  your `app/_config/hcaptcha.yml`

```yaml

Oposs\hCaptcha\Forms\hCaptchaField:
  site_key: 'your_site_key'
  secret_key: 'your_secret_key'

```

For more configuration options check comments in [hCaptchaField.php](src/Froms/hCaptchaField.php)

## Usage

In php:

```injectablephp

use Oposs\hCaptcha\hCaptchaProtector\Forms

new hCaptchaField('SpamProtection', 'SpamProtection', null);

```

Or if you use [Userforms](https://github.com/silverstripe/silverstripe-userforms):

![img.png](img/img.png)


Contributions are welcome :)
