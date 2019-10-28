---
title: Contributing to mautic-cron-commands
copyright:
  - 2019 Virgil
  - All rights reserved
version: 1.0.0
date: 2019-10-28
author: Virgil <virgil@virgilwashere.co>
license: GPL3
link: <https://github.com/virgilwashere/mautic-cron-commands>
---
# Contributing to mautic-cron-commands

<img alt="mautibot" align="right" src="https://cdn.jsdelivr.net/gh/virgilwashere/mautic-cron-commands/assets/mautibot32.png">

:+1::tada: First off, thanks for taking the time to contribute! :tada::+1:

This project adheres to the Contributor Covenant [code of conduct].
By participating, you are expected to uphold this code. Please report unacceptable behavior to the project lead at virgil@virgilwashere.co

The following is a set of guidelines for contributing to our project. These are just guidelines, not rules, use your best judgment and feel free to propose changes to this document in a pull request.

## All Contributors Welcome

We define contributors as those who contribute to this project in any [category][contrib-cat] at any level of contribution. This specification is, by definition, inclusive of _all_ contributions.

We use the [AllContributors][contrib-bot] :robot: to automate acknowledging contributors to this project.

[contrib-bot]: <https://allcontributors.org/docs/en/bot/usage#all-contributors-add>
[contrib-cat]: <https://allcontributors.org/docs/en/emoji-key>

## [Issues][issues]

Issues are created [here][new issues].

<!-- - [How to Contribute in Issues](https://electronjs.org/docs/development/issues#how-to-contribute-in-issues) -->
- How to Contribute in Issues
<!-- - [Asking for General Help](https://electronjs.org/docs/development/issues#asking-for-general-help) -->
- Asking for General Help
<!-- - [Submitting a Bug Report](https://electronjs.org/docs/development/issues#submitting-a-bug-report) -->
- Submitting a Bug Report
<!-- - [Triaging a Bug Report](https://electronjs.org/docs/development/issues#triaging-a-bug-report) -->
- Triaging a Bug Report
<!-- - [Resolving a Bug Report](https://electronjs.org/docs/development/issues#resolving-a-bug-report) -->

## Pull Requests

Pull Requests are the way changes are made to the code, documentation, dependencies, and tools contained in this repository.

It is recommended to keep your changes grouped logically within individual commits. Many contributors find it easier to review changes that are split across multiple commits. There is no limit to the number of commits in a pull request.

```console
git add my/changed/files
git commit
```

> #### :information_source: **Note:**
> Multiple commits in a pull request can be squashed to a single commit when they are merged

### Commit message guidelines

A good commit message should describe what changed and why.

- Use the present tense ("add feature" not "added feature")
- Use the imperative mood ("move output to..." not "moves output to...")

We use [semantic commit messages][conventional] to streamline the release process.

Before a pull request can be merged, it **must** have a pull request title with a semantic prefix.
Having a consistent format allows us to automate [CHANGELOG] updates.

Examples of commit messages with semantic prefixes:

- `docs: 📝 address the upgrade process`
- `feat: ✨ add command write:docs:forme`
- `fix: 🐛 lookup the correct parameter`

#### Common prefixes

- feat: `:sparkles:` a new feature
- fix: `:bug:` a bug fix
- docs: `:pencil:` documentation changes
- refactor: `:art:` a code change that neither fixes a bug nor adds a feature
- refactor: `:rotating_light:` a code change that does not affect the meaning of the code (linting)
- perf: `:racehorse:` a code change that improves performance
- test: `:white_check_mark:` adding or changing tests
- chore: `:wrench:` performing repository maintenance
- chore: `:bookmark:` release 1.0.0
- ci: `:green_heart:` changes to our CI configuration files and scripts
- vendor: `:package:`bumping a dependency

Other things to keep in mind when writing a commit message:

> #### :bulb: **ProTip:**
> Other things to keep in mind when writing a commit message:
>
> - The first line should:
>   - contain a short description of the change (preferably 50 characters or less, and no more than 72 characters)
>   - be entirely in lowercase with the exception of proper nouns, acronyms, and the words that refer to code, like function/variable names
> - Keep the second line blank.
> - Wrap all other lines at 72 columns.
> - Reference issues and other pull requests liberally after the first line
> <!-- - When only changing documentation, you can include `[ci skip]` in the commit title -->

#### Emoji

You are encouraged to include an applicable emoji in commit messages after the semantic prefix:

- 🎉 `:tada:` when adding a feature
- ✨ `:sparkles:` when enhancing an existing feature
- 📝 `:memo:` when writing docs
- 🐛 `:bug:` when fixing a bug
- ✏️ `:pencil2:` when it's just a typo
- 🍱 `:bento:` when adding or updating assets
- 🚚 `:truck:` when moving or renaming files
- 🔥 `:fire:` when removing code or files
- 💥 `:boom:` when there is a **Breaking Change**
- 🎨 `:art:` when improving the format/structure of the code
- 🚨 `:rotating_light:` when removing linter warnings
- 💚 `:green_heart:` when fixing the CI build
- ✅ `:white_check_mark:` when adding tests
- 🔒 `:lock:` when dealing with security
- 🚀 `:rocket:` when deploying stuff
- ⬆️ `:arrow_up:` when upgrading dependencies
- ⬇️ `:arrow_down:` when downgrading dependencies
- 🐎 `:racehorse:` when improving performance

See the [gitmoji] [cheatsheet][gitmoji] for more inspiration.

### Breaking Changes

A commit that has the text `BREAKING CHANGE:` at the beginning of its third line, or footer section, introduces a **breaking change** (correlating with [Major in semantic versioning][conventional]). A breaking change can be part of commits of any type.

> e.g., a `fix:`, `feat:` & `chore:`

types would all be valid, in addition to any other type.

See [conventionalcommits.org][conventional] for more details.

## Coding conventions

Start reading our code and you'll get the hang of it. We optimize for readability.
If in doubt, you have some simple options:

- stay faithful to the existing style
- [just ask us][new issue]
- look at the [editorconfig] [settings in `.editorconfig`][.editorconfig]

> **TL;DR**

>~~TL;DWy~~
>~~(didnt write yet)~~

Follow the guidelines in your IDE of choice (ie [VS Code][vscode]) from the most popular language extensions.

<details><summary>Bash</summary>

### PHP

[WIP][PHP vscode]

</details>

<details><summary>Bash</summary>

### Bash

What? Wait a sec!<!-- markdownlint-disable MD033 -->
<sup id="a1">[1](#f1)</sup>
<!-- markdownlint-enable MD033 -->

#### Error messages

##### `STDOUT` vs `STDERR`

> All error messages should go to STDERR.

This makes it easier to separate normal status from actual issues.

A function to print out error messages along with other status information is recommended.

```bash
error() {
printf '[%(%Y-%m-%dT%X)T]: %s\n' "$@" >&2
}

if ! do_something; then
error "Unable to do_something"
exit "${E_DID_NOTHING}"
fi
```

#### Comments

##### File Header

> Start each file with a description of its contents.

- Every file must have a top-level comment including a brief overview of its contents.
- A copyright notice and author information are optional.

Example:

```bash
#!/usr/bin/env bash
#-*- coding: utf-8 -*-
#
# Perform hot backups of Oracle databases.
```

##### Function Comments

> Any function that is not both obvious and short must be commented. Any function in a library must be commented regardless of length or complexity.

It should be possible for someone else to learn how to use your program or to use a function in your library by reading the comments (and self-help, if provided) without reading the code.

All function comments should contain:

- Description of the function
- Global variables used and modified
- Arguments accepted
- Returned values other than the default exit status of the last command run

##### Implementation Comments

> Comment tricky, non-obvious, interesting or important parts of your code.
This follows general coding comment practice.

> Don't comment everything.

- If there's a complex algorithm or you're doing something out of the ordinary, put a short comment in.
- If you paused to think about the implementation, while _**writing
  it**_, put a meaningful comment in for the next person.
- It might be you.

#### Indentation

> Indent two spaces. No tabs.

- We indent using two spaces (soft tabs). Whatever you do, don't use tabs.
- Use blank lines between blocks to improve readability.

#### Line Length and Long Strings

> We use a line length of 80 characters

- If you have to write strings that are longer than 80 characters, this should be done with a HERE document or an embedded newline if possible.
- Literal strings that have to be longer than 80 chars and can't sensibly be split are OK, but it's strongly preferred to find a way to make it shorter.

#### Loops

> Put `; do` and `; then` on the same line as the `while`, `for` or `if`.

</details>

### Final thoughts

This is open-source software.

- Consider the people who will read your code, and make it look nice for them.

  > It's sort of like driving a car: perhaps you love doing donuts when you're alone, but with passengers, the goal is to make the ride as smooth as possible.

<!-- - Also for the CDN, always use cwd-relative paths rather than root-relative paths in image URLs in any CSS. So instead of url('/assets/blah.gif'), use url('../assets/blah.gif'). -->

[repo]: </virgilwashere/mautic-cron-commands/>
[CHANGELOG]: <CHANGELOG.md>
[code of conduct]: <CODE_OF_CONDUCT.md>
[issues]: <issues>
[new issue]: <issues/new/choose>
[.editorconfig]: <.editorconfig>
[editorconfig]: <https://editorconfig.org>
[contrib-bot]: <https://allcontributors.org/docs/en/bot/usage#all-contributors-add>
[contrib-cat]: <https://allcontributors.org/docs/en/emoji-key>
[conventional]: <https://conventionalcommits.org/>
[gitmoji]: <https://gitmoji.carloscuesta.me/>
[vscode]: <https://code.visualstudio.com>
[PHP vscode]: <https://code.visualstudio.com/docs/languages/php>

---

<!-- markdownlint-disable MD033 -->
1. <small id="f1">This is going to be a multi repo document</small> [↩](#a1)
<!-- markdownlint-enable MD033 -->