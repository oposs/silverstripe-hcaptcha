# hCaptcha spam protection

Protect your forms with hCaptcha

## Installation

As soon this module is published:

```
    composer require oetiker/silverstripe-hcaptcha dev
```

## Configuration

In  your `app/_config/hcaptcha.yml`

```yaml

Oetiker\hCaptcha\Forms\hCaptchaField:
  site_key: 'your_site_key'
  secret_key: 'your_secret_key'

```

## Usage

In php:

```injectablephp

use Oetiker\hCaptcha\hCaptchaProtector\Forms

new hCaptchaField('SpamProtection', 'SpamProtection', null);

```

Or if you use Userforms:

![img.png](img/img.png)


Contributions are welcome :)
