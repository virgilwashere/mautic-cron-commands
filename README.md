---
 author:     Virgil <virgil@virgilwashere.co>
 date:       2019-08-31
 version:    0.1.2
 copyright:  2019 Virgil
 license:    GPL3
---
<img alt="Mautic" align="right" width=64 src="./assets/mautic_logo.png">

# Mautic cron commands

[commands.php](commands.php) can be used in (shared) web hosting environments which do not allow execution of CLI commands to run [Mautic cron and maintenance tasks](#references).

## Installation

1. Change the `$secretphrase` parameter in the script to a **_new_** secret phrase (eg: `mautibot_happy`) so only you will be able to run the commands.
1. Copy `commands.php` to the top level folder of your Mautic installation.
    >This is the same level as `app/` and Mautic's `LICENSE.txt`

## How to use

<img alt="mautibot" align="right" src="./assets/mautibot32.png">

When you open the URL, you should see the list of available commands. You can click on those to run the command manually or use the URL encoded `https://` link to a command in a cron/cronjob/scheduler service, like Jenkins.

### interactively

1. Access `commands.php` URL with your browser.
   > `https://mautic.example.com/commands.php?mautibot_happy`.
1. Append `&pretty` to URL to display inline base64-encoded logo and a **javascript** back button:  `https://mautic.example.com/commands.php?mautibot_happy&pretty`.

### cron jobs

1. Find the URL encoded link to a command

    ```http
    http://mautic.example.com/commands.php?mautibot_happy&task=mautic%3Acampaigns%3Atrigger
    ```

1. Browse to the URL

    ```crontab
    # min hr dom mth dow  command
    */15  *  *   *   *    curl -L http://mautic.example.com/commands.php?mautibot_happy&task=mautic%3Acampaigns%3Atrigger
    ```

### output

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

## Changelog

See [CHANGELOG](CHANGELOG.md)

## Related projects

- Cronfig: <https://cronfig.io>
  - Mautic plugin: <https://docs.cronfig.io/integrations/mautic>
- Original gist: <https://gist.github.com/escopecz/9a1a0b10861941a457f4>
  - Mautic 2.6: <https://gist.github.com/ChgoChad/fe9950c628ad8169cd27a58ee64106e8>

## References

- Mautic Cron job docs - <https://www.mautic.org/docs/en/setup/cron_jobs.html>
- When upgrades fail - <https://johnlinhart.com/blog/uh-oh-mautic-upgrade-was-not-successful>

[repo]: <https://github.com/virgilwashere/mautic-cron-commands>
