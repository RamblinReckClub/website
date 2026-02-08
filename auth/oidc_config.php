<?php

function oidc_env($key) {
    $value = getenv($key);
    if ($value === false || $value === '') {
        return null;
    }

    return $value;
}

function oidc_get_config() {
    $baseUrl = oidc_env('OIDC_BASE_URL');
    $redirectUri = null;
    if ($baseUrl) {
        // Callback path is fixed at /auth/oidc-callback.php
        $redirectUri = rtrim($baseUrl, '/') . '/auth/oidc-callback.php';
    }

    return [
        // Provider configuration
        'issuer' => oidc_env('OIDC_ISSUER'),
        'client_id' => oidc_env('OIDC_CLIENT_ID'),
        'client_secret' => oidc_env('OIDC_CLIENT_SECRET'),
        
        // Redirect configuration
        'base_url' => $baseUrl,
        'redirect_uri' => $redirectUri,
        
        // Claims and mapping
        'scope' => oidc_env('OIDC_SCOPE'),
        'username_claim' => oidc_env('OIDC_USERNAME_CLAIM'),
        'match_field' => oidc_env('OIDC_MATCH_FIELD'),
        
        // Optional features
        'debug' => oidc_env('OIDC_DEBUG') === '1',
        'use_ms_graph' => oidc_env('OIDC_USE_MS_GRAPH') === '1',
    ];
}

function oidc_is_enabled($config = null) {
    if ($config === null) {
        $config = oidc_get_config();
    }

    $required = ['issuer', 'client_id', 'client_secret', 'base_url', 'redirect_uri', 'scope', 'username_claim', 'match_field'];
    foreach ($required as $key) {
        if (empty($config[$key])) {
            return false;
        }
    }

    $allowedMatchFields = ['gtUsername', 'username', 'email'];
    if (!in_array($config['match_field'], $allowedMatchFields, true)) {
        return false;
    }

    return true;
}

function oidc_debug_enabled($config = null) {
    if ($config === null) {
        $config = oidc_get_config();
    }

    return !empty($config['debug']);
}
