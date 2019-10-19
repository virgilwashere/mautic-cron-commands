<?php
/**
 * Execute Mautic console commands.
 *
 * This script can be used in environments where you do not have SSH access
 * to run the Mautic command line tool "console"
 *
 * @abstract    Script to run Mautic (mautic.org) commands from a web page.
 * @copyright   2019 Virgil. All rights reserved
 * @version     0.1.4
 * @date        2019-10-20
 * @author      Virgil <virgil@virgilwashere.co>
 * @license     GPL3
 * @param       string $secretphrase    URL parameter: passphrase to limit execution of commands
 * @param       string $pretty          URL parameter
 * @var         string $cdn             https://cdn.jsdelivr.net/gh/virgilwashere/mautic-cron-commands
 * @var         string $backarrow       img src
 * @var         string $logo            img src
 * @var         string $mautibot        img src
 * @link        https://github.com/virgilwashere/mautic-cron-commands
 * @link        https://mautic.org
 * @see         https://www.mautic.org/docs/en/setup/cron_jobs.html
 * @see         https://www.mautic.org/docs/en/tips/update-failed.html
 * @see         https://gist.github.com/escopecz/9a1a0b10861941a457f4
 * @filesource  commands.php
 * @since       Mautic 2.15.0
 *
 */

$author='Virgil <virgil@virgilwashere.co>';

$secretphrase= "mautibot_happy";
if (!isset($_GET[$secretphrase])) {
    echo 'The secret phrase is wrong.';
    die;
}
defined('IN_MAUTIC_CONSOLE') or define('IN_MAUTIC_CONSOLE', 1);
$version = file_get_contents(__DIR__.'/app/version.txt');
if (isset($_GET['pretty'])) {
    $pretty = $_GET['pretty'];
}
$request_uri =  "//{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";

/**
 * @todo create a displayCmds array to use for page generation.
 * Allows for aliased commands to be added to $allowedCmds
 *  eg mautic:segments:update and mautic:segments:rebuild
 * @var string[] $allowedCmds will still be authorative list commands.
 */

$allowedCmds = array(
    'list',
    'debug:router',
    'mautic:segments:update',
    'mautic:campaigns:update',
    'mautic:campaigns:trigger',
    'cache:clear',
    'mautic:emails:send',
    'mautic:emails:fetch',
    'mautic:broadcasts:send',
    'mautic:queue:process',
    'mautic:webhooks:process',
    'mautic:reports:scheduler',
    'mautic:plugins:update',
    'mautic:iplookup:download',
    'mautic:assets:generate',
    'mautic:segments:update --force',
    'mautic:campaigns:update --force',
    'mautic:campaigns:trigger --force',
    'mautic:campaigns:update --batch-limit=25',
    'mautic:campaigns:trigger --batch-limit=25',
    'mautic:campaigns:messages --channel=email',
    'mautic:campaigns:messages --channel=sms',
    'cache:clear --no-interaction --no-warmup --no-optional-warmers',
    'cache:warmup --no-interaction --no-optional-warmers',
    'mautic:social:monitoring',
    'social:monitor:twitter:hashtags',
    'social:monitor:twitter:mentions',
    'mautic:dashboard:warm',
    'debug:swiftmailer',
    'mautic:integration:pushleadactivity',
    'mautic:integration:fetchleads',
    'mautic:contacts:deduplicate',
    'mautic:import --limit=600 --quiet',
    'mautic:dnc:import --no-interaction',
    'mautic:maintenance:cleanup --no-interaction --days-old=90 --dry-run',
    'mautic:maintenance:cleanup --no-interaction --days-old=365 --dry-run',
    'mautic:maintenance:cleanup --no-interaction --days-old=90',
    'mautic:maintenance:cleanup --no-interaction --days-old=365',
    'mautic:update:find',
    'doctrine:mapping:info',
    'doctrine:migrations:status',
    'doctrine:migrations:status --show-versions',
    'doctrine:schema:update --no-interaction --dump-sql',
    'doctrine:migrations:migrate --no-interaction --allow-no-migration',
    'doctrine:schema:update --no-interaction --dump-sql --force',
    'mautic:install:data --no-interaction --force',
    'mautic:update:apply --no-interaction --force'
);
$css_container='<style type="text/css">
    body {
        padding: 20px;
        font-family: "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", Geneva, Arial, sans-serif;
    }
    li { font-size: smaller; }
    h3 {
        font-family: Open Sans, Helvetica, Arial,sans-serif;
    }
    .container {
        padding: 20px 20px 20px;
        max-width: 600px;
        background-color:#4E5E9E;
        border: 3px solid #4E5E9E;
    }
    .container__image {
        display: inline-block;
        vertical-align: top;
        margin: 0px 20px 0 0;
        width: 13%;
        border: 3px solid #4E5E9E;
    }
    .container__heading {
        display: inline-block;
        vertical-align: top;
        width: 80%;
        color:#FCB833;
        border: 3px solid #4E5E9E;
    }
    .container__arrow {
        display: inline-block;
        vertical-align: top;
        padding: 0px 10px 0px 0px;
        text-align:center;
        max-width: 160px;
        background-color:#4E5E9E;
        border: 3px solid #4E5E9E;
    }
    @media (max-width: 620px) {
        .container__heading {
            width: 100%;
        }
    }</style>';

    $html_head = '<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">';
$head_meta = '    <meta name="author" content="'. $author .'">
    <meta name="description" content="Mautic cron and maintenance commands">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow" />
    <link rel="shortcut icon" href="favicon.ico">
    <link rel="icon" type="image/x-icon" href="/media/images/favicon.ico" />
    <link rel="icon" sizes="72x72" href="/media/images/favicon.ico">
    <link rel="apple-touch-icon" href="/media/images/apple-touch-icon.png" />';

// If you want to use an inline image, add the base64 encoded image
// here, and uncomment the relevant parameter.

// $mautibot_base64 = 'iVBORw0KG...';
// $mautibot='"data:image/png;base64, '.$mautibot_base64.'"';
// $logo_base64 = 'iVBORw0KGgoA...';
// $logo='"data:image/png;base64, '.$logo_base64.'"';
$cdn='https://cdn.jsdelivr.net/gh/virgilwashere/mautic-cron-commands';
$mautibot=$cdn . '/assets/mautibot32.png';
$logo=$cdn . '/assets/mautic_logo.png';
$backarrow=$cdn . '/assets/arrow-left-trans.png';

if (!isset($_GET['task'])) {
    // Command selection
    echo "$html_head\n";
    echo "<title>Mautic Maintenance Commands</title>\n";
    echo "$head_meta\n";
    if (isset($pretty)) {
        echo "$css_container\n";
        echo "  </head><body>\n";
        echo '
    <div class="container">
        <a target="new" href="/s/login"><img class="container__image" src="'.$logo.'" alt="logo"></a>
        <div class="container__heading">'."
            <h3>{$_SERVER['HTTP_HOST']} maintenance commands</h3>
        </div>
    </div>\n";
    } else {
        echo "</head><body>\n";
        echo "<h3>{$_SERVER['HTTP_HOST']} maintenance commands</h3>\n";
    }
    if (isset($version)) {
        echo '<p title="version"><small>Mautic version: <strong style="color:blue">'.$version."</strong></small></p>\n";
    }
    echo '<p title="cmdlist">Select a command from the list:</p>'."\n";
    echo '<ul id="allowedcommandslist">'."\n";
    foreach ($allowedCmds as $task) {
        $link = $request_uri.'&task='.urlencode($task);
        echo '<li><a href="'.$link.'">'.$task."</a></li>\n";
    }
    echo "</ul><hr>\n";
    echo '<p title="warning">Please, <strong style="color:red">backup your database</strong> before executing <code>doctrine:*:*</code> commands! (or anything with <code>--force</code>)</p>'."\n";
    echo '<p>Mautic documentation: <a href="https://www.mautic.org/docs/en/setup/cron_jobs.html">Setup cronjobs</a> and <a href="https://www.mautic.org/docs/en/tips/update-failed.html">Upgrade troubleshooting</a>.</p>'."\n";
    echo "</body></html>\n";
    die;
}

$task = urldecode($_GET['task']);
if (!in_array($task, $allowedCmds)) {
    echo 'Command '.$task." is not allowed!\n";
    die;
}
// if (isset($pretty)) {
//     // $options = ' --ansi';
//     $options = '';
// } else {
    $options = '';
// }
$fullCommand = explode(' ', $task);
$command = $fullCommand[0];
$argsCount = count($fullCommand) - 1;
$console = array('console'.$options, $command);
if ($argsCount) {
    for ($i = 1; $i <= $argsCount; $i++) {
        $console[] = $fullCommand[$i];
    }
}
// Command results
    echo "$html_head\n";
    echo '<title>Command: '.implode(' ', $console)."</title>\n";
    echo "$head_meta\n";
if (isset($pretty)) {
    echo "$css_container\n";
    echo "</head><body>\n";
    echo '
<div class="container">
    <img class="container__image" src="'.$mautibot.'" alt="Mautibot™">
    <div class="container__heading">'."
        <h3>Executing console command</h3>
    </div>
</div>\n";
} else {
    echo "</head><body>\n";
    echo "<h3>Executing console command</h3>\n";
}
    echo "<pre>".implode(' ', $console)."</pre>\n";
require_once __DIR__.'/app/autoload.php';
require_once __DIR__.'/app/AppKernel.php';
require __DIR__.'/vendor/autoload.php';
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\BufferedOutput;

try {
    $input  = new ArgvInput($console);
    $output = new BufferedOutput();
    $kernel = new AppKernel('prod', false);
    $app    = new Application($kernel);
    $app->setAutoExit(false);
    $result = $app->run($input, $output);
    echo "<pre>\n{$output->fetch()}</pre>\n";
} catch (\Exception $e) {
    echo "Exception raised: {$e->getMessage()}\n";
} finally {
    if (isset($pretty)) {
        echo '
    <div class="container">
        <a href="javascript:history.back(1)" title="Return to the previous page">
            <img class="container__arrow" src="'.$backarrow.'" alt="&laquo; Go back">
        </a>
    </div>'."\n";
    }
    echo "</body></html>\n";
}
