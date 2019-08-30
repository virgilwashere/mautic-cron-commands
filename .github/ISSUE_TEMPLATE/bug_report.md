---
name: 🐜 Bug report
about: Create a report to help us improve 📝
title: '[BUG] '
labels: ''
assignees: ''
---
# Bug Report

<!-- CLICK "Preview" TO SEE THE INSTRUCTIONS IN A MORE READABLE FORMAT -->

## Describe the bug

For bug reports, please provide as much *relevant* info as possible.

## How do you reproduce the issue?

Steps to reproduce the behaviour:

1. Open URI `https://mautic.example.com/commands.php?secretphrase`
1. Select task `mautic:is:awesome`
1. See error

## Does the task run from the command line?

### Using `console`

Create a shell alias for `console` if required and attempt to run the task.

```bash
alias console='sudo -H -u www-data php app/console -vvv'
cd /var/www/example/mautic
console mautic:is:awesome
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
console mautic:is:awesome
```

## Error Messages & `console` output

<!-- Expand the `save error message here` -->

<details><summary>save error message here</summary>

💡change the summary text

```console
COPY THE ERROR MESSAGE OR LOG INFORMATION HERE
```

</details>

## Environment

Tell us which operating system you are using, as well as which versions of Mautic, PHP, your webserver, and `commands.php`.

Run the following commands and save the data where indicated.

### Version Information

| Software                 | Version(s) | `command`            |
| ------------------------ | ---------- | -------------------- |
| Mautic                   |`         ` | `console | head -n 1`|
| PHP                      |`         ` | `php -v`             |
| Apache?                  |`         ` | `apache -v`          |
| nginx?                   |`         ` | `nginx -v`           |
| Operating System         |`         ` | `grep -i version /etc/os-release`      |
| Browser?                 |`         ` | eg [chrome://version/](chrome://version/) |

### Mautic

```shell
cd /path/to/mautic
# alias console='sudo -H -u www-data php app/console -vvv'
console | head -n 1
```

```text
COPY THE MAUTIC VERSION INFORMATION HERE
```

### PHP

```console
$ php -v
# or
$ php -V
```

```text
COPY THE PHP VERSION INFORMATION HERE
```

### Web Server

```console
$ nginx -v
$ apache -v
```

```text
COPY THE WEBSERVER VERSION INFORMATION HERE
```

### Operating System

```shell
grep -i version /etc/os-release
```

```text
COPY THE OS VERSION INFORMATION HERE
```

**Additional context**
Add any other context about the problem here.

## EXAMPLE 🐛 Bug Report

See [example_bug_report](/.github/ISSUE_TEMPLATE/example_bug_report.md) for an example of a 🐛 Bug Report for the task `does:not:exist`not working.
