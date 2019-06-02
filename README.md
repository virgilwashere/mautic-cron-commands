---
 author:     Virgil <virgil@endless.net.au>
 date:       2019-06-02
 version     0.1.0
 copyright   2019 Virgil
 license     GPL3
 prettyURL: `&pretty`
---
# ![Mautic](/assets/favicon_mautic.ico) Mautic <commands.php>

This script can be used in shared web hosting environments which do not allow execution of CLI commands to run Mautic cron and [maintenance tasks](#references).

## How to make it work

1. Copy the `commands.php` file in this directory to the root folder of Mautic. This is the same level as `app/`
1. Change `$secretphrase` in that script to some secret phrase (eg: `c3dXiEd0UmZ7`) so only you'll be able to run the commands.

## How to use it

When you execute the URL, you should get the list of available commands with URL addresses. You can click on those to run the command manually or use the commands http link in a cron UI/scheduler service, like Jenkins, or you could just use [Cronfig](https://cronfig.io).

1. Accessing this URL with your browser: `https://mautic.loc/commands.php?c3dXiEd0UmZ7`.
1. Append `&pretty` to URL to enable *conditional*inline base64-encoded logo and a **javascript** back button:  `https://mautic.loc/commands.php?c3dXiEd0UmZ7&pretty`.

The output from the script will be sent to the browser so you can see the results just as if you ran this `console` command from the shell.

```text
Executing console mautic:broadcasts:send

+---------+--------+----------+
| Channel | # sent | # failed |
+---------+--------+----------+
```

## Changes

- [x] Support Mautic version 2.15.x commands
- [x] Include version information in output `$version`
- [x] Add conditional base64 encoded logo `$logo_base64`
  - [x] Append `&pretty` to URL to enable.

## References

- [x] Original gist - <https://gist.github.com/escopecz/9a1a0b10861941a457f4>
- [x] Updated gist for Mautic 2.6 - <https://gist.github.com/ChgoChad/fe9950c628ad8169cd27a58ee64106e8>
- [x] Cronjob doco - <https://www.mautic.org/docs/en/setup/cron_jobs.html>
- [x] When upgrades fail - <https://johnlinhart.com/blog/uh-oh-mautic-upgrade-was-not-successful>
- [x] Cronfig - <https://cronfig.io>
