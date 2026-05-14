# Google OAuth Setup Guide

## Step 1: Install Laravel Socialite

Run this command in the Backend directory:
```bash
composer require laravel/socialite
```

## Step 2: Get Google OAuth Credentials

1. Go to [Google Cloud Console](https://console.cloud.google.com/)
2. Create a new project or select existing one
3. Enable **Google+ API**
4. Go to **Credentials** → **Create Credentials** → **OAuth 2.0 Client ID**
5. Configure OAuth consent screen if prompted
6. Application type: **Web application**
7. Add these URLs:
   - **Authorized JavaScript origins**: `http://localhost`
   - **Authorized redirect URIs**: `http://localhost/auth/google/callback`

8. Copy your **Client ID** and **Client Secret**

## Step 3: Update .env File

Add these lines to your `.env` file:

```env
GOOGLE_CLIENT_ID=your-google-client-id-here
GOOGLE_CLIENT_SECRET=your-google-client-secret-here
GOOGLE_REDIRECT_URL=http://localhost/auth/google/callback
```

## Step 4: Update config/services.php

This has been done automatically. The file now includes:

```php
'google' => [
    'client_id' => env('GOOGLE_CLIENT_ID'),
    'client_secret' => env('GOOGLE_CLIENT_SECRET'),
    'redirect' => env('GOOGLE_REDIRECT_URL'),
],
```

## Step 5: Database Migration

Run this to add OAuth fields to users table:
```bash
php artisan migrate
```

## Step 6: Test the Integration

1. Click "Continue with Google" on the login page
2. Authorize with your Google account
3. You should be logged in automatically!

## Troubleshooting

### Error: redirect_uri_mismatch
- Make sure the redirect URI in Google Console matches exactly: `http://localhost/auth/google/callback`
- Update it if using a different domain

### Error: Client ID not found
- Double-check your `.env` file has the correct credentials
- Run `php artisan config:clear` to clear cached config

### Users not being created
- Check the database migration ran successfully
- Verify `google_id` and `avatar` columns exist in users table
