# OIDC Authentication Setup

## Local Development

1. Copy `.env.example` to `.env` and fill in your OIDC credentials:
   ```bash
   cp .env.example .env
   ```

2. Install Composer dependencies:
   ```bash
   composer install
   ```

3. The `vendor/` directory is gitignored, so it won't be committed to the repo.

## Deployment to Production Server

Since `vendor/` is gitignored, you have two options:

### Option 1: Run Composer on the Server (Recommended)
After deploying your code to the server:
```bash
cd /path/to/website
composer install --no-dev --optimize-autoloader
```

This downloads and installs the OIDC library directly on the server.

### Option 2: Deploy vendor/ Manually (Plesk-friendly)
If your server doesn't have Composer or you can't run commands:

1. **Locally**, after `composer install`, commit the `vendor/` folder:
   - Remove `/vendor/` from `.gitignore` temporarily
   - Commit and push `vendor/`
   
2. **Or**, zip the entire `vendor/` folder locally and upload it via FTP/SFTP to your server at the same location.

The OIDC code will work as long as `vendor/autoload.php` exists and is readable by PHP.

## Required Environment Variables

Set these in Plesk's PHP settings or via `.env`:
- `OIDC_ISSUER` - Provider base URL (e.g., https://login.gatech.edu/oidc)
- `OIDC_CLIENT_ID` - Your registered client ID
- `OIDC_CLIENT_SECRET` - Your client secret
- `OIDC_BASE_URL` - Your site's base URL (e.g., https://reckclub.org)
- `OIDC_SCOPE` - Space-separated scopes (e.g., `openid email profile User.Read`)
- `OIDC_USERNAME_CLAIM` - Claim containing username (e.g., `preferred_username`)
- `OIDC_MATCH_FIELD` - Database column to match (e.g., `gtUsername`)
- `OIDC_USE_MS_GRAPH=1` - Enable Microsoft Graph username lookup (set to 1 for Microsoft/Azure AD)

## Register Your Callback URL

Register this redirect URI with your OIDC provider:
```
https://yourdomain.com/auth/oidc-callback.php
```

## Testing

Enable debug mode to see detailed error info:
```
OIDC_DEBUG=1
```

**Never use debug mode in production!**
