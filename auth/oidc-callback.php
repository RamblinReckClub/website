<?php

ob_start();
error_reporting(E_ALL & ~E_DEPRECATED);

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../database_connect.php';
require __DIR__ . '/auth_login.php';
require __DIR__ . '/oidc_config.php';

use Jumbojett\OpenIDConnectClient;

session_start();

function getMicrosoftUsername($oidc) {
    $accessToken = $oidc->getAccessToken();
    if (!$accessToken) {
        return null;
    }

    $graphUrl = 'https://graph.microsoft.com/v1.0/me?$select=onPremisesSamAccountName';
    $ch = curl_init($graphUrl);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $accessToken]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    if ($status === 200 && $response) {
        $data = json_decode($response, true);
        return $data['onPremisesSamAccountName'] ?? null;
    }
    
    return null;
}

function oidc_debug_dump($label, $data) {
    echo '<h3>' . htmlspecialchars($label) . '</h3>';
    echo '<pre style="white-space: pre-wrap; word-break: break-word;">' . htmlspecialchars(print_r($data, true)) . '</pre>';
}

function oidc_callback_fail($message, $status = 400, $debugContext = null) {
    http_response_code($status);
    echo "<!doctype html>";
    echo "<html lang=\"en\"><head><meta charset=\"utf-8\"><title>Sign in error</title></head>";
    echo "<body><h2>Georgia Tech sign-in failed</h2><p>" . htmlspecialchars($message) . "</p>";

    if (is_array($debugContext) && !empty($debugContext['debug'])) {
        oidc_debug_dump('Debug', [
            'request_uri' => $_SERVER['REQUEST_URI'] ?? null,
            'get' => $_GET,
            'session_keys' => array_keys($_SESSION ?? []),
            'config' => $debugContext['config'] ?? null,
            'note' => 'Client secret and tokens are not displayed.'
        ]);

        if (!empty($debugContext['exception'])) {
            oidc_debug_dump('Exception', $debugContext['exception']);
        }
    }

    echo "</body></html>";
    exit;
}

$config = oidc_get_config();
if (!oidc_is_enabled($config)) {
    oidc_callback_fail('Georgia Tech sign-in is not configured.', 404, [
        'debug' => oidc_debug_enabled($config),
        'config' => ['enabled' => false]
    ]);
}

$debugConfig = $config;
unset($debugConfig['client_secret']);

try {
    $oidc = new OpenIDConnectClient($config['issuer'], $config['client_id'], $config['client_secret']);
    $oidc->setRedirectURL($config['redirect_uri']);
    $oidc->addScope(explode(' ', trim($config['scope'])));

    $oidc->authenticate();

    // Get username from Microsoft Graph API or standard OIDC claims
    $username = null;
    if ($config['use_ms_graph']) {
        $username = getMicrosoftUsername($oidc);
    }
    
    if (!$username) {
        $username = $oidc->requestUserInfo($config['username_claim']);
    }
    
    if (!$username) {
        oidc_callback_fail('Unable to determine Georgia Tech username.', 400, [
            'debug' => oidc_debug_enabled($config),
            'config' => $debugConfig
        ]);
    }

    $matchField = $config['match_field'];
    $query = $db->prepare("SELECT * FROM Member WHERE {$matchField} = :value");
    $query->execute(['value' => $username]);
    $user = $query->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        oidc_callback_fail('No matching member account found.', 403, [
            'debug' => oidc_debug_enabled($config),
            'config' => $debugConfig,
            'exception' => ['matched_value' => $username, 'match_field' => $matchField]
        ]);
    }

    successfulLogin($user, $db);
    header('Location: /points.php');
    exit;
} catch (Throwable $e) {
    error_log('OIDC callback error: ' . $e->getMessage());

    oidc_callback_fail('Authentication failed.', 400, [
        'debug' => oidc_debug_enabled($config),
        'config' => $debugConfig,
        'exception' => ['type' => get_class($e), 'message' => $e->getMessage()]
    ]);
}
