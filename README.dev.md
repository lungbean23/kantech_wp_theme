# Kantex – Dev Notes

## Abstract
Kantex is a minimalist e-commerce site built on **WordPress + WooCommerce**.  
The storefront is the homepage (Shop at `/`), with a slim navigation, clean product grid, and Woo defaults for Cart, Checkout, and My Account.  
It’s ready to be hosted on GoDaddy or any LAMP stack. Payments and email are intentionally left as owner-supplied credentials.

---

## What’s in here
- **WordPress** with WooCommerce
- **Theme**: `kantech-child` (inherits from `kantech_wp_theme`)
  - Slim, sticky top bar + minimal footer
  - Live cart count (Woo AJAX fragments)
  - Front page renders the Woo Shop grid
  - Small, cache-busted asset pipeline (`assets/css/app.css`, `assets/js/theme.js`)
- **Woo pages** published: Shop, Cart, Checkout, My Account
- **Temporary payment methods** (for dev/demo only): Cash on Delivery, Bank Transfer, Manual Invoice

---

## Still to do (owner credentials required)
1. **Domain & SSL**
   - Point a real domain (e.g. `shop.example.com`) at the host.
   - Update WordPress URLs to `https://shop.example.com`.

2. **Email (transactional)**
   - Pick a provider: SendGrid / Mailgun / Amazon SES.
   - Authenticate the *domain* (SPF/DKIM/DMARC), then configure WP Mail SMTP with API key.
   - Use `sales@yourdomain.com` as the From address.

3. **Payments**
   - Enable Stripe and/or PayPal in **WooCommerce → Settings → Payments**.
   - Enter live API keys and complete onboarding.

4. **SEO & Analytics**
   - Finish Yoast setup (site title, meta, sitemap submission).
   - Add Google Analytics / Tag Manager.

5. **Performance**
   - Autoptimize + WP Super Cache: enable and test with the theme.
   - Consider image compression (Imagify/Smush) after uploads exist.

6. **Security & Backups**
   - Install a security plugin (Wordfence/All-In-One).
   - Schedule DB + files backups (e.g. Jetpack Backup, UpdraftPlus, or host-level backup).

---

## Hand-off to hosting (GoDaddy or similar)
A hosting rep can follow this checklist:

1. **Environment**
   - PHP 8.1+ (8.2 preferred), MySQL 5.7+/MariaDB 10.4+, Apache with `mod_rewrite`.
2. **Files**
   - Upload site files to the docroot (e.g. `public_html`) or the chosen webroot.
3. **Database**
   - Create a database & user; import SQL dump (if provided).
   - Update `wp-config.php` with DB name/user/password/host.
4. **Site URLs**
   - Set WordPress URLs to the production domain:
     ```php
     // in wp-config.php (optional safety)
     define('WP_HOME',    'https://shop.example.com');
     define('WP_SITEURL', 'https://shop.example.com');
     ```
   - Or with WP-CLI after it’s live:
     ```bash
     wp option update home    'https://shop.example.com'
     wp option update siteurl 'https://shop.example.com'
     ```
5. **Permalinks**
   - Ensure `.htaccess` is writable; visit **Settings → Permalinks** and click **Save** (or `wp rewrite flush --hard`).
6. **HTTPS**
   - Install SSL (GoDaddy SSL / Let’s Encrypt) and force HTTPS at the vhost level.

---

## Local dev quick commands
```bash
# Set the Shop as the homepage
wp option update show_on_front page
wp option update page_on_front "$(wp option get woocommerce_shop_page_id)"

# Flush permalinks
wp rewrite structure '/%postname%/' --hard

# Create a test product
PID=$(wp post create --post_type=product --post_title="Kantex Demo" --post_status=publish --porcelain)
wp post meta update $PID _price 29
wp post meta update $PID _regular_price 29
wp post meta update $PID _stock_status instock

# View Woo orders (HPOS)
wp db query "SELECT id,status,total_amount,date_created_gmt FROM wp_wc_orders ORDER BY id DESC LIMIT 10;"

