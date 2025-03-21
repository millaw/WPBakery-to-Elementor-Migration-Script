# WPBakery to Elementor Migration Script

## Overview
This script automates the migration of WordPress pages from WPBakery shortcodes to Elementor widgets. It:
✅ Scans all WordPress pages for WPBakery shortcodes.  
✅ Replaces WPBakery shortcodes with Elementor-compatible structure.  
✅ Preserves content (text, images, buttons) in Elementor widgets.  
✅ Automatically updates posts and pages without manual work.  

---

## 📌 Steps to Use This Script
### 1. Backup Your Website!
Before running the script, **create a full backup of your WordPress database** to prevent data loss.

### 2. Run the Script
- Upload the `wpbakery-to-elementor` folder to your WordPress plugins directory.
- Go to **WordPress Dashboard → Plugins**.
- Find **"WPBakery to Elementor Migration"** and click **"Activate"**.
- Navigate to **Tools → WPBakery to Elementor**.
- Click **"Start Migration"** to convert all WPBakery shortcodes into Elementor widgets.

---

## **🛠️ What This Script Converts**

| WPBakery Shortcode | Converted to Elementor Widget |
|----------------------|--------------------------------|
| `[vc_column_text]Lorem Ipsum[/vc_column_text]` | `<!-- wp:paragraph -->Lorem Ipsum<!-- /wp:paragraph -->` |
| `[vc_single_image image="123"]` | `<!-- wp:image {"url":"IMAGE_URL"} --><img src="IMAGE_URL" /><!-- /wp:image -->` |
| `[vc_btn title="Click Here" link="https://example.com"]` | `<!-- wp:button --><a href="https://example.com">Click Here</a><!-- /wp:button -->` |
| `[vc_custom_heading text="Welcome!" font_size="24px"]` | `<!-- wp:heading --><h2 style="font-size:24px;">Welcome!</h2><!-- /wp:heading -->` |

---

## 📢 Notes
- This script **only converts common WPBakery shortcodes** (text blocks, images, buttons, headings). Custom shortcodes may require additional modifications.
- Ensure your WordPress installation is **updated** to the latest version before running the migration.

🚀 Enjoy a **clean, Elementor-friendly website** without WPBakery shortcodes!

