---
 author:     Virgil <virgil@virgilwashere.co>
 date:       2019-09-10
 version:    0.1.3
 copyright:  2019 Virgil
 license:    GPL3
---
<!-- markdownlint-disable MD033 -->
<img alt="Mautic" align="right" width=72 src="assets/mautic_logo.png?raw=true">
<!-- markdownlint-enable MD033 -->

# Mautic cron commands

[commands.php] can be used in environments where you do not have SSH access to run the Mautic [command line](#command-line) tool: [`app/console`](#command-line).

- [Requirements ☑️](#requirements-️)
- [Installation 🚀](#installation-)
- [How to use 🚴](#how-to-use-)
  - [Interactively 👪](#interactively-)
  - [Cron jobs 🕖](#cron-jobs-)
  - [Basic output 🔰](#basic-output-)
  - [Pretty output 💍](#pretty-output-)
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
   1. Change the `$secretphrase` parameter in the script to a **_new_** secret phrase so only you will be able to run the commands. 🔐
   1. Optional: replace `$logo` with another base64 encoded image string. 🎨\
   `base64 -w0 image.png`

1. 🐦Copy your modifed `commands.php` to the root folder of your Mautic installation via SSH terminal, (s)FTP upload or carrier pigeon.
    > ℹ️ **NOTE**\
    > This is the same level as Mautic's `LICENSE.txt` file and the directory `app/`

## How to use 🚴

<!-- markdownlint-disable MD033 -->
<!-- <img alt="mautibot" align="right" src="https://cdn.jsdelivr.net/gh/virgilwashere/mautic-cron-commands/assets/mautibot32.png"> -->
<img alt="mautibot" align="right" src="assets/mautibot32.png?raw=true">
<!-- markdownlint-enable MD033 -->

When you open the URL, you are presented with a list of available commands. You can click on those to run the command, or use the Encoded URL link to a specific command in a cronjob/scheduler service, like [Jenkins CI/CD][jenkins].

### Interactively 👪

1. 🌐 Open the `commands.php` URL with your browser
    ```http
    https://mautic.example.com/commands.php?mautibot_happy
    ```

1. ❔Optional. Append `&pretty` to the URL to display a logo and basic navigation
   ```http
    https://mautic.example.com/commands.php?mautibot_happy&pretty
   ```

![pretty-list](/assets/pretty-list.png?raw=true "command list")

### Cron jobs 🕖

1. :mag_right: Find the URL encoded link to a command
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
<!-- > `curl --request GET 'http://mautic.example.com/commands.php?mautibot_happy&task=mautic:campaigns:trigger'` -->

### Basic output 🔰

The output from the script will be sent to the browser so you can see the results just as if you ran this `console` command from the shell.

```console
Executing console mautic:campaigns:trigger
 Triggering events for campaign 5
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

### Pretty output 💍

![pretty-output](assets/pretty-output.png?raw=true "pretty format command output")

<!-- markdownlint-disable MD033 -->
<img alt="mautibot" align="right" width=64 src="assets/mautic_logo.png?raw=true">
<!-- markdownlint-enable MD033 -->

## Mautic documentation 📜

> ℹ️ **NOTE**\
> Access the complete Mautic documentation [here][documentation].

- [Setup cronjobs]
- [Update troubleshooting]
- [Command line]

<!-- markdownlint-disable MD033 -->
<img alt="mautibot" align="right" src="assets/mautibot32.png?raw=true">
<!-- markdownlint-enable MD033 -->

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
