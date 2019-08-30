---
name: "Example Bug report \U0001F41C"
about: "Create a report to help us improve \U0001F4DD"
title: "[BUG] "
labels: ''
assignees: ''

---

# Bug Report

<!-- CLICK "Preview" TO SEE THE INSTRUCTIONS IN A MORE READABLE FORMAT -->

## Describe the bug

Task `does:not:exist`is not working

## How do you reproduce the issue?

Steps to reproduce the behaviour:

1. Open URI `https://mautic.example.com/commands.php?secretphrase`
1. Select task `does:not:exist`
1. See error

## Does the task run from the command line?

### Using `console`

Create a shell alias for `console` if required and attempt to run the task.

```bash
alias console='sudo -H -u www-data php app/console -vvv'
cd /var/www/example/mautic
console does:not:exist
```

### Clear application cache

```bash
cd /var/www/example/mautic
sudo rm -rf app/cache/prod
console cache:clear
```

### Try again

```bash
cd /var/www/example/mautic
console does:not:exist
```

## Support information

### Error Messages & `console` output

<details><summary>console error</summary>

```console
$ console does:not:exist

  [Symfony\Component\Console\Exception\CommandNotFoundException]
  There are no commands defined in the "does:not" namespace.

Exception trace:
 () at /var/www/example/mautic/vendor/symfony/console/Application.php:478
 Symfony\Component\Console\Application->findNamespace() at /var/www/example/mautic/vendor/symfony/console/Application.php:512
 Symfony\Component\Console\Application->find() at /var/www/example/mautic/vendor/symfony/framework-bundle/Console/Application.php:94
 Symfony\Bundle\FrameworkBundle\Console\Application->find() at /var/www/example/mautic/vendor/symfony/console/Application.php:190
 Symfony\Component\Console\Application->doRun() at /var/www/example/mautic/vendor/symfony/framework-bundle/Console/Application.php:84
 Symfony\Bundle\FrameworkBundle\Console\Application->doRun() at /var/www/example/mautic/vendor/symfony/console/Application.php:117
 Symfony\Component\Console\Application->run() at /var/www/example/mautic/app/console:41
```

</details>

### Environment

<details><summary>Version information</summary>

Tell us which operating system you are using, as well as which versions of Mautic, PHP, your webserver, and `commands.php`.

Run the following commands and save the data where indicated.

### Version Information

| Software         | Version(s)             | `command`|
| ---------------- | ---------------------- | --- |
| Mautic           | `2.15.2`               | `console | head -n 1`                    |
| PHP              | `7.0`                  | `php -v`                                  |
| nginx?           | `1.16`                 | `nginx -v`                                |
| Operating System | `Ubuntu 16.04`         | `grep -i version /etc/os-release`         |
| Browser?         | `Chrome 76.0.3809.132` | eg [chrome://version/](chrome://version/) |

### Mautic

```text
Mautic version 2.15.2 - app/prod
```

### PHP

```text
PHP 7.0.33-8+ubuntu16.04.1+deb.sury.org+1 (cli) (built: May 31 2019 11:34:07) ( NTS )
Copyright (c) 1997-2017 The PHP Group
Zend Engine v3.0.0, Copyright (c) 1998-2017 Zend Technologies
    with Zend OPcache v7.0.33-8+ubuntu16.04.1+deb.sury.org+1, Copyright (c) 1999-2017, by Zend Technologies
```

### Web Server

```text
nginx version: nginx/1.16.1
built with OpenSSL 1.1.1c  28 May 2019
TLS SNI support enabled
configure arguments: --with-cc-opt='-g -O2 -fPIE -fstack-protector-strong -Wformat -Werror=format-security -fPIC -Wdate-time -D_FORTIFY_SOURCE=2' --with-ld-opt='-Wl,-Bsymbolic-functions -fPIE -pie -Wl,-z,relro -Wl,-z,now -fPIC' --prefix=/usr/share/nginx --conf-path=/etc/nginx/nginx.conf --http-log-path=/var/log/nginx/access.log --error-log-path=/var/log/nginx/error.log --lock-path=/var/lock/nginx.lock --pid-path=/run/nginx.pid --modules-path=/usr/lib/nginx/modules --http-client-body-temp-path=/var/lib/nginx/body --http-fastcgi-temp-path=/var/lib/nginx/fastcgi --http-proxy-temp-path=/var/lib/nginx/proxy --http-scgi-temp-path=/var/lib/nginx/scgi --http-uwsgi-temp-path=/var/lib/nginx/uwsgi --with-debug --with-pcre-jit --with-http_ssl_module --with-http_stub_status_module --with-http_realip_module --with-http_auth_request_module --with-http_v2_module --with-http_dav_module --with-http_slice_module --with-threads --with-http_addition_module --with-http_flv_module --with-http_geoip_module=dynamic --with-http_gunzip_module --with-http_gzip_static_module --with-http_image_filter_module=dynamic --with-http_mp4_module --with-http_perl_module=dynamic --with-http_random_index_module --with-http_secure_link_module --with-http_sub_module --with-http_xslt_module=dynamic --with-mail=dynamic --with-mail_ssl_module --with-stream=dynamic --with-stream_ssl_module --with-stream_ssl_preread_module --add-dynamic-module=/build/nginx-r_oNKP/nginx-1.16.1/debian/modules/http-headers-more-filter --add-dynamic-module=/build/nginx-r_oNKP/nginx-1.16.1/debian/modules/http-auth-pam --add-dynamic-module=/build/nginx-r_oNKP/nginx-1.16.1/debian/modules/http-cache-purge --add-dynamic-module=/build/nginx-r_oNKP/nginx-1.16.1/debian/modules/http-dav-ext --add-dynamic-module=/build/nginx-r_oNKP/nginx-1.16.1/debian/modules/http-ndk --add-dynamic-module=/build/nginx-r_oNKP/nginx-1.16.1/debian/modules/http-echo --add-dynamic-module=/build/nginx-r_oNKP/nginx-1.16.1/debian/modules/http-fancyindex --add-dynamic-module=/build/nginx-r_oNKP/nginx-1.16.1/debian/modules/nchan --add-dynamic-module=/build/nginx-r_oNKP/nginx-1.16.1/debian/modules/http-lua --add-dynamic-module=/build/nginx-r_oNKP/nginx-1.16.1/debian/modules/rtmp --add-dynamic-module=/build/nginx-r_oNKP/nginx-1.16.1/debian/modules/http-uploadprogress --add-dynamic-module=/build/nginx-r_oNKP/nginx-1.16.1/debian/modules/http-upstream-fair --add-dynamic-module=/build/nginx-r_oNKP/nginx-1.16.1/debian/modules/http-subs-filter --add-dynamic-module=/build/nginx-r_oNKP/nginx-1.16.1/debian/modules/ssl-ct --add-dynamic-module=/build/nginx-r_oNKP/nginx-1.16.1/debian/modules/http-geoip2
```

### Operating System

```text
VERSION="16.04.6 LTS (Xenial Xerus)"
VERSION_ID="16.04"
VERSION_CODENAME=xenial
```

</details>
