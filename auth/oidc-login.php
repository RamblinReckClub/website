<?php

ob_start();
error_reporting(E_ALL & ~E_DEPRECATED);

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/oidc_config.php';

use Jumbojett\OpenIDConnectClient;

session_start();

function oidc_login_fail($message, $status = 500) {
    http_response_code($status);
    echo "<!doctype html>";
    echo "<html lang=\"en\"><head><meta charset=\"utf-8\"><title>Sign in error</title></head>";
    echo "<body><h2>Unable to start Georgia Tech sign-in</h2><p>" . htmlspecialchars($message) . "</p></body></html>";
    exit;
}

$config = oidc_get_config();

if (!oidc_is_enabled($config)) {
    oidc_login_fail('Georgia Tech sign-in is not configured.', 404);
}

$oidc = new OpenIDConnectClient($config['issuer'], $config['client_id'], $config['client_secret']);
$oidc->setRedirectURL($config['redirect_uri']);
$oidc->addScope(explode(' ', trim($config['scope'])));

$oidc->authenticate();

header('Location: /points.php');
exit;
