Quick path: All-in-One WP Migration (AIO)
A) Prep the local site (once)

Run these (from /var/www/html/kantech_site):


# 1) Make sure AIO is installed
wp plugin install all-in-one-wp-migration --activate

# 2) Turn off & purge optimizers/caches to keep the package tidy
wp plugin deactivate autoptimize wp-super-cache --quiet || true
wp cache flush
rm -rf wp-content/cache/* 2>/dev/null || true

# 3) Remove the tunnel-only helper (not needed on real domain)
rm -f wp-content/mu-plugins/00-tunnel-home.php

# 4) (Optional) Clear Woo transients/sessions
wp transient delete --all


Notes
• You don’t need to manually search/replace URLs — AIO does the domain swap on import.
• Your child theme + Woo pages + front-page=Shop settings will come along in the export.

B) Export the package (local)

Go to: https://localhost/wp-admin/admin.php?page=ai1wm_export

Click Advanced options and (optional) tick:

“Do not export spam comments”

“Do not export post revisions”

(Only if size is an issue) “Do not export media library”

Click Export To → File.

Download the .wpress file.

If the file is big and you didn’t exclude media, that’s normal — it’s your whole site (files + DB).

C) Import on GoDaddy Managed WordPress

In GoDaddy, create a new Managed WordPress site (temporary domain is fine).

Log in to that site’s wp-admin and install All-in-One WP Migration:

Plugins → Add New → search “all in one wp migration” → Install → Activate.

Go to All-in-One WP Migration → Import:
https://your-temp-domain/wp-admin/admin.php?page=ai1wm_import

Import From → File, choose your .wpress, wait for it to finish, click Proceed.

You’ll be logged out. Log back in (credentials are the ones from your local site).

Post-import tasks:

Settings → Permalinks → Post name → Save (refreshes rewrite rules).

Settings → General: set WordPress Address/Site Address to your real domain (when you’re ready to point DNS).

Plugins: re-activate Autoptimize / WP Super Cache if you want them, then clear their caches after first page load.

SMTP/Payments: install & configure before you go live.

Upload limit gotcha: If GoDaddy blocks large imports (common > 128–150 MB), either
• Use AIO’s paid File Extension to lift the cap, or
• Re-export excluding media, then re-upload /wp-content/uploads via SFTP, or
• Use Duplicator instead (it splits packages and has its own installer).

D) Point the domain & finish

In GoDaddy DNS: set A record for yourdomain.com to the site’s IP; CNAME www → @.

Wait for DNS to propagate.

Enable/confirm SSL in GoDaddy (Managed WP usually auto-provisions Let’s Encrypt).

Visit https://yourdomain.com, confirm:

Shop is the homepage

Cart, Checkout, My Account return 200 OK

Styles look right (if not, clear Autoptimize/Super Cache again)

Set up SMTP (WP Mail SMTP + SendGrid/Mailgun/SES or a GoDaddy mailbox) so registrations/orders reach inboxes.

Enable Stripe/PayPal in WooCommerce when you have live keys.

Is your current codebase/db “good” for this path?

Yes. You’ve got:

A working WooCommerce shop set as the homepage,

A child theme (clean, update-safe),

No hard-coded localhost URLs in templates,

The tunnel mu-plugin isolated (and we removed it before export).

That’s exactly the shape AIO expects. Export → Import → Save Permalinks → set SMTP/Payments → done.
