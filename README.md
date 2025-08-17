The AI demo ran in an ephemeral sandbox; its database and media never left that
environment.

In WordPress, products, categories, prices, and all images live in the
database and in `wp-content/uploads/`—not in the theme folder.

This ZIP is theme-only (PHP/CSS/JS) and bundles just two images
(`images/hero.png`, `images/logo.png`). A fresh install renders layout but no
products until content and uploads are imported.

**verify.** Navigate to your `kantech_wp_theme` folder (Explorer or a
terminal/PowerShell) and list its contents. If you see exactly:
`footer.php  front-page.php  functions.php  header.php  images  index.php
README.md  script.js  single-product.php  style.css`
and, inside `images`, only `hero.png` and `logo.png`—with no
`wp-content/uploads/`, no `.xml` export, and no `.sql` dump—then this is the
theme only and the demo data stayed in the sandbox.

**Next steps.** Provide (1) a WordPress WXR export (Tools → Export → All
content, `.xml`) and (2) the `wp-content/uploads/` directory from the original
site. After import, go to Settings → Permalinks → Save, and set Settings →
Reading → Homepage if needed.

Appendix: [Windows 11 – Export content & collect uploads](docs/CONTENT_EXPORT_WINDOWS.md)

