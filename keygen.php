<?php
/**
 * APP_KEY generator — PHP 5.6 safe.
 *
 * Why this file exists
 * --------------------
 * Laravel's own `php artisan key:generate` uses random_bytes(), which is a
 * PHP 7 function. On PHP 5.6 it only works because Laravel loads the
 * paragonie/random_compat polyfill through Composer's autoloader. Any
 * hand-rolled one-liner (`php -r 'echo base64_encode(random_bytes(32));'`)
 * therefore FAILS on PHP 5.6 with "Call to undefined function random_bytes()",
 * and keys copied from the web are very often 16 bytes, which produces:
 *
 *     RuntimeException: The only supported ciphers are AES-128-CBC and
 *     AES-256-CBC with the correct key lengths.
 *
 * This script uses openssl_random_pseudo_bytes(), which IS native to PHP 5.6,
 * and sizes the key from config/app.php so it always matches the cipher.
 *
 * Usage
 * -----
 *   php keygen.php            show a valid key (copy it into .env yourself)
 *   php keygen.php --write    write it straight into .env
 *
 * No SSH? Copy this file into public/, open it in a browser, copy the key,
 * then DELETE it from public/.
 */

$isCli = (PHP_SAPI === 'cli');
$eol   = $isCli ? "\n" : "<br>\n";

if (! $isCli) {
    header('Content-Type: text/html; charset=utf-8');
    echo '<pre style="font:14px/1.6 monospace;padding:20px">';
}

$base = __DIR__;

// ---------------------------------------------------------------- cipher
$cipher = 'AES-256-CBC';
$appConfig = $base . '/config/app.php';
if (is_file($appConfig)) {
    $src = file_get_contents($appConfig);
    if (preg_match("/'cipher'\s*=>\s*'([^']+)'/", $src, $m)) {
        $cipher = $m[1];
    }
}
$bytes = ($cipher === 'AES-128-CBC') ? 16 : 32;

// ---------------------------------------------------------------- generate
if (! function_exists('openssl_random_pseudo_bytes')) {
    echo 'ERROR: the openssl extension is not enabled. Enable it, or run '
       . '"php artisan key:generate" instead.' . $eol;
    exit(1);
}

$strong = false;
$raw = openssl_random_pseudo_bytes($bytes, $strong);

if ($raw === false || strlen($raw) !== $bytes) {
    echo 'ERROR: could not generate ' . $bytes . ' random bytes.' . $eol;
    exit(1);
}
if (! $strong) {
    echo 'WARNING: openssl reported a weak random source on this server.' . $eol;
}

$key = 'base64:' . base64_encode($raw);

echo 'Cipher in config/app.php : ' . $cipher . $eol;
echo 'Required key length      : ' . $bytes . ' bytes' . $eol;
echo 'Generated key            : ' . $key . $eol;
echo $eol;

// ---------------------------------------------------------------- write
$write = $isCli && in_array('--write', array_slice($argv, 1), true);

if ($write) {
    $envPath = $base . '/.env';

    if (! is_file($envPath)) {
        echo 'ERROR: .env not found at ' . $envPath . $eol;
        exit(1);
    }
    if (! is_writable($envPath)) {
        echo 'ERROR: .env is not writable.' . $eol;
        exit(1);
    }

    $env = file_get_contents($envPath);

    if (preg_match('/^APP_KEY=.*$/m', $env)) {
        $env = preg_replace('/^APP_KEY=.*$/m', 'APP_KEY=' . $key, $env, 1);
    } else {
        $env = rtrim($env) . "\nAPP_KEY=" . $key . "\n";
    }

    file_put_contents($envPath, $env);
    echo 'Written to .env' . $eol;
} else {
    echo 'Copy that line into .env as:' . $eol;
    echo '    APP_KEY=' . $key . $eol;
    if ($isCli) {
        echo $eol . 'Or re-run with --write to update .env automatically.' . $eol;
    }
}

// ------------------------------------------------- cached-config warning
$cachedConfig = $base . '/bootstrap/cache/config.php';
if (is_file($cachedConfig)) {
    echo $eol;
    echo '!! bootstrap/cache/config.php exists. While that file is present,' . $eol;
    echo '!! Laravel IGNORES .env entirely and your new key will not be used.' . $eol;
    echo '!! Delete it (or run: php artisan config:clear) after changing .env.' . $eol;
}

if (! $isCli) {
    echo '</pre>';
    echo '<p style="font:14px monospace;color:#FF0000">'
       . 'Delete this file from public/ once you have copied the key.</p>';
}
