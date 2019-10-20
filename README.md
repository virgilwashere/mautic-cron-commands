---
author:     Virgil <virgil@virgilwashere.co>
date:       2019-10-20
version:    0.1.6
copyright:
  - 2019 Virgil
  - All rights reserved
license:    GPL3
link:       <https://github.com/virgilwashere/mautic-cron-commands>
---
<img alt="Mautic" align="right" width=128 src="assets/mautic_logo.png?raw=true">

# Mautic cron commands

[commands.php] can be used in environments where you do not have SSH access to run the Mautic [command line](#command-line) tool: [`app/console`](#command-line).

- [Requirements ☑️](#requirements-️)
- [Installation 🚀](#installation-)
  - [nginx config for shared vhosts](#nginx-config-for-shared-vhosts)
    - [`snippets/mautic_cron.conf`](#snippetsmautic_cronconf)
- [How to use 🚴](#how-to-use-)
  - [👪 Interactively](#-interactively)
  - [Cron jobs 🕖](#cron-jobs-)
  - [🔰 Basic output](#-basic-output)
  - [💍 Pretty output](#-pretty-output)
- [Mautic documentation 📜](#mautic-documentation-)
- [Related projects ⛅️](#related-projects-️)
- [Changelog 📔](#changelog-)

## Requirements ☑️

- a Mautic installation
  - works with Mautic 2.12+
- a webserver with PHP support

## Installation 🚀

> ⚠️**WARNING**\
> **_DO NOT_** leave the `$secretphrase` as `mautibot_happy`

1. ✏️Edit your local copy of [commands.php]
   1. 🔐 Change the `$secretphrase` parameter in the script to a **_new_** secret phrase so only you will be able to run the commands.
   1. 🎨 Optional: replace `$logo` with another `<img src=` link.

1. 🐦Copy your modifed `commands.php` to the root folder of your Mautic installation via SSH terminal, (s)FTP upload or carrier pigeon.
    > ℹ️ **NOTE**\
    > This is the same level as Mautic's `LICENSE.txt` file and the directory `app/`

### nginx config for shared vhosts

Add this to the `server` block for the vhost.

```nginx
server {
    #server_name      mautic.example.com;
    #...

    set $mautic_root /var/www/vhost1/mautic;
    include snippets/mautic_cron.conf;
}
```

#### `snippets/mautic_cron.conf`

```nginx
    location /cron/ {
        # URL would be https://mautic.example.com/cron/commands.php
        root    $mautic_root;
        index   commands.php;

        location ~ /(commands|import)\.php(/|$) {
            include snippets/fastcgi-php.conf;
            fastcgi_pass unix:/run/php/php7.2-fpm.sock;

            #override SCRIPT_FILENAME
            fastcgi_param  SCRIPT_FILENAME $request_filename;
            fastcgi_param  HTTP_PROXY   "";
            fastcgi_read_timeout        600;
            fastcgi_buffers             16 16k;
            fastcgi_buffer_size         32k;
            fastcgi_intercept_errors    on;
            fastcgi_param  MAUTIC_ROOT  $mautic_root;
        }
    }
```

## How to use 🚴

<!-- <img alt="mautibot" align="right" src="https://cdn.jsdelivr.net/gh/virgilwashere/mautic-cron-commands/assets/mautibot32.png"> -->
<img alt="mautibot" align="right" src="assets/mautibot32.png?raw=true">

When you open the URL, you are presented with a list of available commands. You can click on those to run the command, or use the Encoded URL link to a specific command in a cronjob/scheduler service, like [Jenkins CI/CD][jenkins].

### 👪 Interactively

1. 🌐 Open the `commands.php` URL with your browser

    ```http
    https://mautic.example.com/commands.php?mautibot_happy
    ```

1. ❔ Optional. Append `&pretty` to the URL to display a logo and basic navigation

   ```http
    https://mautic.example.com/commands.php?mautibot_happy&pretty
   ```

<!-- ![pretty-list](https://cdn.jsdelivr.net/gh/virgilwashere/mautic-cron-commands/assets/pretty-list.png "command list") -->
![caption: pretty mode command list](/assets/pretty-list.png?raw=true "command list")

<details><summary>command list</summary>

```php
$allowedCmds = array(
    'list',
    'mautic:segments:update',
    'mautic:campaigns:update',
    'mautic:campaigns:trigger',
    'cache:clear',
    'mautic:emails:send',
    'mautic:emails:fetch',
    'mautic:emails:send --quiet',
    'mautic:emails:fetch --quiet',
    'mautic:broadcasts:send',
    'mautic:broadcasts:send --quiet',
    'mautic:broadcasts:send --channel=email',
    'mautic:broadcasts:send --channel=sms',
    'mautic:messages:send',
    'mautic:campaigns:messages',
    'mautic:campaigns:messages --channel=email',
    'mautic:campaigns:messages --channel=sms',
    'mautic:queue:process',
    'mautic:webhooks:process',
    'mautic:reports:scheduler',
    'mautic:plugins:update',
    'mautic:iplookup:download',
    'mautic:assets:generate',
    'mautic:segments:update --force',
    'mautic:campaigns:update --force',
    'mautic:campaigns:trigger --force',
    'mautic:segments:update --max-contacts=300 --batch-limit=300',
    'mautic:segments:update --max-contacts=300 --batch-limit=300 --quiet',
    'mautic:segments:update --max-contacts=300 --batch-limit=300 --force',
    'mautic:segments:update --max-contacts=1000 --batch-limit=1000',
    'mautic:segments:update --max-contacts=1000 --batch-limit=1000 --quiet',
    'mautic:campaigns:update --max-contacts=100 --quiet',
    'mautic:campaigns:update --max-contacts=300 --quiet',
    'mautic:campaigns:trigger --quiet',
    'cache:clear --no-interaction --no-warmup --no-optional-warmers',
    'cache:warmup --no-interaction --no-optional-warmers',
    'mautic:social:monitoring',
    'mautic:integration:pushleadactivity --integration=XXX',
    'mautic:integration:fetchleads --integration=XXX',
    'mautic:import --limit=600',
    'mautic:import --limit=600 --quiet',
    'mautic:dnc:import --limit=600',
    'mautic:dnc:import --limit=600 --quiet',
    'mautic:maintenance:cleanup --no-interaction --days-old=90 --dry-run',
    'mautic:maintenance:cleanup --no-interaction --days-old=365 --dry-run',
    'mautic:maintenance:cleanup --no-interaction --days-old=90',
    'mautic:maintenance:cleanup --no-interaction --days-old=365',
    'doctrine:migrations:status',
    'doctrine:migrations:status --show-versions',
    'doctrine:migrations:migrate --allow-no-migration --dry-run',
    'doctrine:migrations:migrate --allow-no-migration --no-interaction',
    'doctrine:migrations:migrate --allow-no-migration --query-time --dry-run',
    'doctrine:migrations:migrate --allow-no-migration --query-time --no-interaction',
    'doctrine:schema:update',
    'doctrine:schema:update --dump-sql',
    'doctrine:schema:validate',
    'doctrine:schema:update --no-interaction --dump-sql --force',
    'doctrine:schema:update --no-interaction --force',
    'debug:swiftmailer',
    'debug:router',
    'doctrine:mapping:info',
    'debug:event-dispatcher',
    'mautic:install:data --no-interaction --force',
    'mautic:contacts:deduplicate',
    'mautic:unusedip:delete',
    'mautic:dashboard:warm',
    'mautic:campaign:summarize',
    'mautic:update:find',
    'mautic:update:apply --no-interaction --force',
);
```

</details>

### Cron jobs 🕖

1. 🔎 Find the URL encoded link to a command

    ```http
    https://mautic.example.com/commands.php?mautibot_happy&task=mautic%3Acampaigns%3Atrigger
    ```

1. 🌐 Request the URL

    ```crontab
    # min hr dom mth dow  command
    */15  *  *   *   *    curl -L http://mautic.example.com/commands.php?mautibot_happy&task=mautic%3Acampaigns%3Atrigger
    ```

    > 💡 ProTip\
    > `curl` can also use this syntax:\
    > `curl -L 'http://mautic.example.com/commands.php?mautibot_happy&task=mautic:campaigns:trigger'`

### 🔰 Basic output

The output from the script will be sent to the browser so you can see the results just as if you ran this `console` command from the shell.

```console
Executing console mautic:campaigns:trigger
 Triggering events for campaign 1
 Triggering events for newly added contacts
 2 total events(s) to be processed in batches of 100 contacts
  0/2 [>---------------------------]   0%
  2/2 [============================] 100%
 2 total events were executed
 0 total events were scheduled

 Triggering scheduled events
 0 total events(s) to be processed in batches of 100 contacts

 0 total events were executed
 0 total events were scheduled

 Triggering events for inactive contacts

 0 total events were executed
 0 total events were scheduled
```

### 💍 Pretty output

<!-- ![pretty format campaign trigger](https://cdn.jsdelivr.net/gh/virgilwashere/mautic-cron-commands/assets/pretty-output.png "pretty format command output") -->
![pretty format campaign trigger](assets/pretty-output.png?raw=true "pretty format campaign trigger")

![pretty format migrations status](assets/pretty-output2.png?raw=true "pretty format migrations status")

<!-- <img alt="Mautic logo" align="right" width=128 src="https://cdn.jsdelivr.net/gh/virgilwashere/mautic-cron-commands/assets/mautic_logo.png"> -->
<img alt="Mautic logo" align="right" width=128 src="assets/mautic_logo.png?raw=true">

## Mautic documentation 📜

> ℹ️ **NOTE**\
> Access the complete Mautic documentation [here][documentation].

- [Setup cronjobs]
- [Update troubleshooting]
- [Command line]

<!-- <img alt="mautibot" align="right" src="https://cdn.jsdelivr.net/gh/virgilwashere/mautic-cron-commands/assets/mautibot32.png"> -->
<img alt="mautibot" align="right" src="assets/mautibot32.png?raw=true">

## Related projects ⛅️

- [John Linhart][@escopecz]'s ([@escopecz]) [original gist](https://gist.github.com/escopecz/9a1a0b10861941a457f4).
  - [@ChgoChad]'s update for Mautic 2.6.
- John Linhart's [cronfig.io service][cronfig service] and [Mautic plugin][cronfig plugin]

## Changelog 📔

See [CHANGELOG](CHANGELOG.md)

[repo]: <https://github.com/virgilwashere/mautic-cron-commands>
[commands.php]: <commands.php>
[@escopecz]: <https://github.com/escopecz>
[jenkins]: <https://jenkins.io>
[@ChgoChad]: <https://gist.github.com/ChgoChad/fe9950c628ad8169cd27a58ee64106e8>
[documentation]: <https://www.mautic.org/docs>
[Setup cronjobs]: <https://www.mautic.org/docs/en/setup/cron_jobs.html>
[Update troubleshooting]: <https://www.mautic.org/docs/en/tips/update-failed.html#nossh>
[command line]: <https://www.mautic.org/docs/en/tips/command-line.html>
[cronfig service]: <https://docs.cronfig.io/integrations/mautic>
[cronfig plugin]: <https://github.com/cronfig/mautic-cronfig>
