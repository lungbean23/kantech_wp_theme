# Developer Notes (private)

**Current state:** we have a **theme only**. No database content, no media
library. The front page/template code is fine; it renders empty because the DB
has zero `product` posts, zero `product_category` terms, and no attachments.

---

## 1) What we need from the boss (choose ONE path)

**Preferred (simple, portable)**
- WXR export (`Tools → Export → All content`) → `export-*.xml`
- A ZIP of `wp-content/uploads/`

**Alternative (exact replica)**
- DB dump (`.sql`)
- ZIP of `wp-content/uploads/`

**Fallback (if the demo DB is gone)**
- A folder of product JPGs **and** a tiny CSV:

title,excerpt,category,price,image_filename
Door Controller A,Compact controller,Access Control Panels,1299.00,k1.jpg
RFID Reader X,High-sec reader,Readers,349.00,k2.jpg

(Or, no CSV: folder-per-category `/KantechImages/<Category>/*.jpg`.)

**Do NOT** ask for images to be added to the theme. Product photos belong in
the Media Library (`wp-content/uploads`), not in `theme/.../images`.

---

## 2) Where “off” becomes “on” (ASCII demarcation)

**OFF (what we have now)**

Browser
↓
Apache/PHP → WordPress → MariaDB ──┐
├── No posts/terms/meta → empty loops
Theme (our ZIP) ───────────────────┘
Assets in theme: logo/hero only
Media library: empty (no uploads)


**ON (when content/media exist)**

Browser
↓
Apache/PHP → WordPress → MariaDB ──┐
posts: product
terms: product_category ├── queries return rows → cards render
meta: _kantech_price │
Media: wp-content/uploads/ ─────────┘ (attachments resolved)
Theme (our ZIP) renders data via WP APIs


If the DB has rows and `uploads/` has images, the front page populates. If not,
you see “No product categories…” and placeholder images. That’s expected.

---

## 3) What the dev will do next (procedures)

### A) If we receive **WXR + uploads** (preferred)

1. WP Admin → **Tools → Import → WordPress** → upload `export-*.xml`  
   Check **“Download and import file attachments.”**  
   If images don’t appear, SFTP `uploads/` to `wp-content/uploads/`.

2. WP Admin → **Settings → Permalinks → Save** (flush rewrites).  
   If using `front-page.php`: **Settings → Reading → set Homepage**.

3. Smoke test:
   - `/` shows categories + product cards
   - Individual product pages render featured image, price, and content

### B) If we receive **DB dump + uploads**

From the WP root (where `wp-config.php` lives):

```bash
mysql -u <user> -p <db_name> < /path/to/site.sql
# place uploads
unzip /path/to/uploads.zip -d wp-content/
# fix URLs if domain changed
wp search-replace 'https://old-site' 'http://localhost/kantech_site' --all-tables --precise
wp rewrite flush --hard

C) If we receive images + CSV (rebuild content)

Place images at /tmp/images/ and CSV at /tmp/products.csv, then:

# 0) Import images to Media Library
wp media import /tmp/images/* --porcelain > /tmp/media_ids.txt

# 1) Create products/terms, set price + featured image
while IFS=, read -r title excerpt category price image; do
  [ "$title" = "title" ] && continue
  wp term create product_category "$category" --by=name 2>/dev/null || true
  pid=$(wp post create --post_type=product --post_status=publish \
        --post_title="$title" --post_excerpt="$excerpt" --porcelain)
  wp term set "$pid" product_category "$category" --by=name
  wp post meta update "$pid" _kantech_price "$price"
  mid=$(wp media list --format=ids --name="$image")
  [ -n "$mid" ] && wp post meta update "$pid" _thumbnail_id "$mid"
done < /tmp/products.csv

wp rewrite flush --hard

Variant (no CSV): folder-per-category /tmp/kantech-images/<Category>/*.jpg

find /tmp/kantech-images -type f -iname '*.jpg' | while read -r f; do
  cat=$(basename "$(dirname "$f")")
  base=$(basename "$f"); title="${base%.*}"; title="${title//_/ }"
  wp term create product_category "$cat" --by=name 2>/dev/null || true
  pid=$(wp post create --post_type=product --post_status=publish \
        --post_title="$title" --post_excerpt='Pending description' --porcelain)
  wp term set "$pid" product_category "$cat" --by=name
  mid=$(wp media import "$f" --porcelain)
  [ -n "$mid" ] && wp post meta update "$pid" _thumbnail_id "$mid"
  wp post meta update "$pid" _kantech_price 'Contact for pricing'
done
wp rewrite flush --hard

4) Reality checks / gotchas

    Cart: our theme shows a button, but there is no cart. This is not
    WooCommerce. The “cart” is a placeholder. Real e-commerce would require
    WooCommerce or a custom plugin.

    Theme vs data: hero/logo ship inside the theme; product photos are
    content and must live in the Media Library.

    Don’t commit DB dumps or wp-content/uploads/ to Git. If we must demo,
    keep a tiny, sanitized sample.

    Permalinks: always Save once post-import.

    Security: if any creds were given to an agent, rotate WP admin, DB,
    and SFTP passwords. Use least-privilege DB users.

5) Minimal email/Slack ask to the boss

    Please send either (a) a WordPress export (Tools → Export → All content,
    .xml) and a ZIP of wp-content/uploads/, or (b) a folder of product
    JPGs and this CSV (header):
    title,excerpt,category,price,image_filename.
    We’ll import and wire everything; you won’t need to install anything locally.

6) Acceptance checklist (dev)

Products appear on / grouped by category

Featured images render; missing ones fall back to hero image

Single product page shows gallery/price/excerpt/content

Permalinks flushed; homepage set if needed

    No PHP notices in logs


Blunt critique of your plan: shipping product images inside the theme is wrong
layering; it makes editors powerless and breaks migrations. Keep code in the
theme, content in the DB + uploads. The docs above make that separation
unambiguous.
