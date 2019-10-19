<?php
/**
 * Execute Mautic console commands.
 *
 * This script can be used in environments where you do not have SSH access
 * to run the Mautic command line tool "console"
 *
 * @abstract    Script to run Mautic (mautic.org) commands from a web page.
 * @copyright   2019 Virgil. All rights reserved
 * @version     0.1.5
 * @date        2019-10-20
 * @author      Virgil <virgil@virgilwashere.co>
 * @license     GPL3
 * @param       string $secretphrase    URL parameter: passphrase to limit execution of commands
 * @param       string $pretty          URL parameter
 * @var         string $cdn             https://cdn.jsdelivr.net/gh/virgilwashere/mautic-cron-commands
 * @var         string $backarrow       img src
 * @var         string $logo            img src
 * @var         string $mautibot        img src
 * @var         string $server_name     HTTP header SERVER_NAME
 * @var         string $docroot         directory where script resides
 * @var         string $version         Mautic version
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

$server_name = filter_input(INPUT_SERVER, 'SERVER_NAME');
if (isset($_SERVER['APP_ROOT'])) {
    $docroot = filter_input(INPUT_SERVER, 'APP_ROOT').'/mautic';
} else {
    $docroot = __DIR__;
}

require_once $docroot.'/app/autoload.php';
require_once $docroot.'/app/AppKernel.php';
require $docroot.'/vendor/autoload.php';

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\BufferedOutput;

$secretphrase= "mautibot_happy";
if (!isset($_GET[$secretphrase])) {
    http_response_code(401);
    die('Unauthorized');
}
defined('IN_MAUTIC_CONSOLE') or define('IN_MAUTIC_CONSOLE', 1);

$version = file_get_contents($docroot.'/app/version.txt');
if (isset($_GET['pretty'])) {
    $pretty = $_GET['pretty'];
}
$request_uri =  "//{$server_name}{$_SERVER['REQUEST_URI']}";

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

// color:#FCB833;
$css='    <style type="text/css">
        .black   { color: #111111 }
        .gray    { color: #AAAAAA }
        .silver  { color: #DDDDDD }
        .white   { color: #FFFFFF }
        .aqua    { color: #7FDBFF }
        .blue    { color: #0074D9 }
        .navy    { color: #001F3F }
        .teal    { color: #39CCCC }
        .green   { color: #2ECC40 }
        .olive   { color: #3D9970 }
        .lime    { color: #01FF70 }
        .yellow  { color: #FFDC00 }
        .orange  { color: #FF851B }
        .red     { color: #FF4136 }
        .fuchsia { color: #F012BE }
        .purple  { color: #B10DC9 }
        .maroon  { color: #85144B }
        a {
            transition: color .4s;
            color: #265C83;
        }
        a:link,
        a:visited { color: #265C83; }
        a:hover   { color: #7FDBFF; }
        a:active  {
            transition: color .3s;
            color: #0074D9;
        }
        .link { text-decoration: none; }
        body {
            padding: 20px;
            font-family: "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", Geneva, Arial, sans-serif;
        }
        li { font-size: smaller; }
        h3 {
            font-family: Open Sans, Helvetica, Arial,sans-serif;
        }
        .container {
            padding: 0px 20px 0px;
            max-width: 600px;
            background-color:#4E5E9E;
            border: 3px solid #4E5E9E;
        }
        .container__logo {
            display: inline-block;
            vertical-align: top;
            margin: 20px 20px 0 0;
            width: 45%;
            border: 3px solid #4E5E9E;
        }
        .container__heading {
            display: inline-block;
            vertical-align: top;
            text-align: center;
            width: 45%;
            color:#FFDC00;
            border: 3px solid #4E5E9E;
        }
        .container__image {
            display: inline-block;
            vertical-align: top;
            margin: 5px 10px 5px 0;
            width: 13%;
            border: 3px solid #4E5E9E;
        }
        .container__results {
            display: inline-block;
            vertical-align: top;
            width: 80%;
            color:#FFDC00;
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
            .container__results {
                width: 100%;
            }
        }
    </style>';
$html_meta = '    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="author" content="'. $author .'">
    <meta name="description" content="Mautic cron and maintenance commands">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow" />
    <link rel="shortcut icon" href="/media/images/favicon.ico">
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
$mautibot=$cdn . '/assets/mautibot.png';
$logo=$cdn . '/assets/mautic_logo.png';
$backarrow=$cdn . '/assets/arrow-left-trans.png';

if (!isset($_GET['task'])) {

    // Command selection ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Mautic Maintenance Commands</title>
<?php if (isset($pretty)) {
        echo "$html_meta\n";
        echo "$css\n"; ?>
</head><body>
    <div class="container">
        <a target="_blank" href="/s/login"><img class="container__logo" src="<?php echo $logo ?>" alt="logo"></a>
        <div class="container__heading">
            <h3><?php echo $server_name ?></h3><h3>maintenance commands</h3>
        </div>
    </div>
<?php } else { ?>
</head><body>
    <h3><?php echo $server_name ?> maintenance commands</h3>

<?php }

    if (isset($version)) { ?>
        <p title="version"><small>Mautic version: <strong style="color:blue"><?php echo $version ?></strong></small></p>

<?php } ?>
    <p title="cmdlist">Select a command from the list:</p>
    <ul id="allowedcommandslist">
<?php
    foreach ($allowedCmds as $task) {
        $link = $request_uri.'&task='.urlencode($task);
        echo '<li><a href="'.$link.'">'.$task."</a></li>\n";
    } ?>
    </ul><hr>
    <p title="warning">Please, <strong style="color:red">backup your database</strong> before executing <code>doctrine:*:*</code> commands! (or anything with <code>--force</code>)</p>
    <p><a target="_blank" href="https://www.mautic.org/docs">Mautic documentation</a>: <a href="https://www.mautic.org/docs/en/setup/cron_jobs.html" target="_blank">Setup cronjobs</a> and <a href="https://www.mautic.org/docs/en/tips/update-failed.html" target="_blank">Upgrade troubleshooting</a>.</p>
</body></html>
<?php
    die;
}

$task = urldecode($_GET['task']);
if (!in_array($task, $allowedCmds)) {
    http_response_code(403);
    die("Command {$task} is not allowed!");
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

// Command results ?>
<?php if (isset($pretty)) { ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Command: <?php echo implode(' ', $console) ?></title>
    <?php echo "$html_meta\n" ?>
    <?php echo "$css\n" ?>
</head><body>
    <div class="container">
        <img class="container__image" src="<?php echo $mautibot ?>" alt="Mautibot™">
        <div class="container__results">
            <h3><?php echo $server_name ?> command output</h3>
            <p>Executing <code><?php echo implode(' ', $console) ?></code></p>
        </div>
    </div>
<?php } else { ?>
<?php echo $server_name ?> command output<br />
Executing <code><?php echo implode(' ', $console) ?></code><br />
<?php }

// Run the application

try {
    $input  = new ArgvInput($console);
    $output = new BufferedOutput();
    $kernel = new AppKernel('prod', false);
    $app    = new Application($kernel);
    $app->setAutoExit(false);
    $result = $app->run($input, $output);

    // command output
    echo "\n<pre>\n{$output->fetch()}</pre>\n";

} catch (\Exception $e) {
    echo "\nException raised: {$e->getMessage()}\n";

} finally {
    if (isset($pretty)) { ?>
    <div class="container">
        <a href="javascript:history.back(1)" title="Return to the previous page">
            <img class="container__arrow" src="<?php echo $backarrow ?>" alt="&laquo; Go back">
        </a>
    </div>
</body></html>

<?php }
}
