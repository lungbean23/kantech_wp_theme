# Windows 11: Export content and collect media (preferred, simple, portable)

## What to deliver
- `export-*.xml` (WordPress WXR export)
- `uploads.zip` (the entire `wp-content/uploads/` directory)

## Tutorials
- WordPress: Tools → Export (WXR)  
  https://wordpress.org/documentation/article/tools-export-screen/
- WordPress: Tools → Import (for the receiver)  
  https://wordpress.org/documentation/article/tools-import-screen/
- Using an FTP/SFTP client to get files from hosting  
  https://wordpress.org/documentation/article/ftp-clients/
- Microsoft: Zip and unzip files in Windows  
  https://support.microsoft.com/windows/zip-and-unzip-files

## Quick steps — WXR export
1) Sign in to the WordPress **admin** of the site that currently has the content.  
2) Go to **Tools → Export → All content** → **Download Export File**.  
3) You’ll get something like `export-YYYY-MM-DD.xml`.

## Quick steps — collect `uploads/` (GUI)
- If the site is hosted:
  1) Open your host’s **File Manager** or use an **SFTP** client.  
  2) Navigate to `wp-content/`, right-click **uploads**, choose **Compress/Zip**, then **Download**.
- If it’s a local Windows install of WordPress:
  1) In File Explorer, go to your site folder → `wp-content`.  
  2) Right-click **uploads** → **Compress to Zip file** → rename to `uploads.zip`.

## Quick steps — collect `uploads/` (PowerShell)
```powershell
# From the WordPress root on Windows (where wp-config.php lives):
Compress-Archive -Path ".\wp-content\uploads\*" -DestinationPath ".\uploads.zip" -Force






Verify before sending

export-*.xml opens as XML and is > 0 KB.

uploads.zip contains year/month folders (e.g., 2024\11, 2025\01) and image files.

Do not send database passwords or wp-config.php.




# One-and-done shell to create + link (from repo root)
```bash
mkdir -p docs
cat > docs/CONTENT_EXPORT_WINDOWS.md <<'MD'
# Windows 11: Export content and collect media (preferred, simple, portable)

## What to deliver
- `export-*.xml` (WordPress WXR export)
- `uploads.zip` (the entire `wp-content/uploads/` directory)

## Tutorials
- WordPress: Tools → Export (WXR)
  https://wordpress.org/documentation/article/tools-export-screen/
- WordPress: Tools → Import (for the receiver)
  https://wordpress.org/documentation/article/tools-import-screen/
- Using an FTP/SFTP client to get files from hosting
  https://wordpress.org/documentation/article/ftp-clients/
- Microsoft: Zip and unzip files in Windows
  https://support.microsoft.com/windows/zip-and-unzip-files

## Quick steps — WXR export
1) Sign in to the WordPress **admin** of the site that currently has the content.
2) Go to **Tools → Export → All content** → **Download Export File**.
3) You’ll get something like `export-YYYY-MM-DD.xml`.

## Quick steps — collect `uploads/` (GUI)
- If the site is hosted:
  1) Open your host’s **File Manager** or use an **SFTP** client.
  2) Navigate to `wp-content/`, right-click **uploads**, choose **Compress/Zip**, then **Download**.
- If it’s a local Windows install of WordPress:
  1) In File Explorer, go to your site folder → `wp-content`.
  2) Right-click **uploads** → **Compress to Zip file** → rename to `uploads.zip`.

## Quick steps — collect `uploads/` (PowerShell)
```powershell
# From the WordPress root on Windows (where wp-config.php lives):
Compress-Archive -Path ".\wp-content\uploads\*" -DestinationPath ".\uploads.zip" -Force




Verify before sending

export-*.xml opens as XML and is > 0 KB.

uploads.zip contains year/month folders (e.g., 2024\11, 2025\01) and image files.

Do not send database passwords or wp-config.php.
MD

printf "\nAppendix: Windows 11 – Export content & collect uploads\n" >> README.md







Critique: burying stakeholder steps in `README.md` confuses audiences. `docs/` keeps it findable without cluttering the main narrative.
::contentReference[oaicite:0]{index=0}

