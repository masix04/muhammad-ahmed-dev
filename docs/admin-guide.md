# Admin guide

How to run the site from the admin panel at **`/admin`**, with no code changes.

## Getting in

1. Create your login once, from the project folder:
   ```bash
   php artisan make:filament-user
   ```
2. Open `/admin` and sign in. There is no sign-up page, so nobody else can create an account.

The sidebar has three groups: **Portfolio**, **Content**, **Settings**.

## What an admin can do

| Area | Can do | Cannot do |
| --- | --- | --- |
| Projects, Work Experience, Skills, Certifications, Blog Posts | Create, edit, delete, hide, reorder | |
| Contact Messages | Read, mark as read | Create or edit messages |
| Site Settings | Edit values | Add, rename or delete keys |
| Everything else (code, layout, colours, fixed section titles) | | Needs a developer |

Changes show on the public site immediately. There is no "publish" step except the **Published** / **Visible** switches below.

## How data gets into the site

There are three ways, and the admin panel is the one you normally use:

1. **Admin panel**: everything below. This is the everyday way.
2. **Sample content from the seeders** (`database/seeders`): loaded automatically the very first time a database is created. After that, seeding never overwrites what you edited. See [deployment.md](deployment.md).
3. **Files placed in the project**: a few settings point at a file (CV, profile photo, share image). You put the file in the `public/` folder and write its path in Site Settings.

## Portfolio

### Projects

Used for the project cards, the popup, and (when featured) the floating cards in the hero.

| Field | What to enter | Shown as |
| --- | --- | --- |
| Title, Slug | Name of the project. The slug fills itself from the title | Card and popup title |
| Category | LMS, E-commerce, Sports, Fitness, Fintech, Other | Small label in the popup |
| Short description | 1–2 sentences | Card text, and the popup if there is no long description |
| Full description | Rich text: paragraphs, lists, headings | Popup body |
| **Case study** (collapsible) | **My role**, **The problem**, **What I built**, **The result**. Plain text, all optional | Labelled blocks at the top of the popup; each block is hidden while empty |
| Thumbnail | Image upload | Card image and popup image |
| Demo video URL | A YouTube link | Popup video (replaces the image) |
| GitHub URL, Live URL | Links | "Code" and "Live site" buttons |
| Tech tags | Type and press Enter, e.g. `Laravel` | Tags on the card and the filter bar |
| **Featured** | On or off | Shows the project as a floating card in the hero (latest 7 featured), placed automatically |
| **Published** | On or off | Off hides the project everywhere |
| Sort order | Number, lower comes first | Order in the grid |

Tips:
- Write the **result** only when you have a real outcome. Leaving it empty is better than guessing.
- The filter bar is built automatically from every tag used by published projects, so keep tag spelling consistent (`Laravel`, not `laravel`).

### Work Experience

The career timeline. The newest **start date** is shown first, and the most recent entry opens by default.

| Field | What to enter |
| --- | --- |
| Role, Company, Location | As on a CV |
| Period | Typed text shown to visitors, e.g. `Jun 2026 – Present` |
| Start date, End date, Is current | Used for ordering; leave End date empty for a current job |
| Key responsibilities | One bullet per line (use "Add" for more) |
| Sub-projects | Name, short description and tags for each project done in that role |
| Company URL | Optional. Adds a "Visit … ↗" link inside the opened timeline entry |
| Sort order | Saved, but the timeline orders by start date, newest first |

### Skills

Shown in the Skills section, with a filter by category.

| Field | What to enter |
| --- | --- |
| Name | e.g. `Livewire` |
| Category | Pick from the list (Backend, Frontend, Database, Tools & AI, Cloud & DevOps…). The list comes from `config/skill-categories.php` |
| Sort order | Number. Skills are listed by category, then by this number |
| Is visible | Off hides it from the public site without deleting |

### Certifications

| Field | What to enter | Shown as |
| --- | --- | --- |
| Title, Issuer | e.g. `Python for Everybody`, `Coursera` | Card heading and issuer |
| Issued date | Free text, e.g. `2023` or `Mar 2023` | Date label |
| Description | Optional note | Card text |
| Verification URL | Link to the certificate | A "Verify Certificate" link, shown only when set |
| Sort order, Is visible | Order and hide switch | |
| Certificate image | Optional upload | Replaces the card's icon with the picture of the certificate |

## Content

### Blog Posts

1. Choose **New blog post**.
2. Type the **title**; the slug fills in when you click out of the field.
3. Add an **excerpt** (shown on cards), the **body** (rich editor), **tags**, a **cover image**, and a **read time** in minutes.
4. Turn on **Published**. Set **Published at** to control ordering and the displayed date.

A post is public when **Published** is on **and** its date is not in the future. Set a future **Published at** to schedule it: the post stays hidden (its address gives a 404) and appears by itself once that moment passes, with no extra step. A post with no date is public straight away. Published posts appear at `/blog`, the latest three on the home page, and in `/sitemap.xml`. Posts left unpublished stay private (opening their address gives a 404).

### Contact Messages

Everything sent through the contact form, newest first. Each message is also emailed to you, so this is the safety copy.

- **View** opens the full message.
- **Mark read** records that you have dealt with it (the list shows a read/unread icon).
- You cannot create or edit messages, by design.

Spam is filtered before it reaches here: bots that fill the hidden field are dropped, and each visitor is limited to 3 messages per 10 minutes.

## Settings

### Site Settings

A list of named values that feed text and links across the whole site. Click one to edit its value. An **empty** value normally *hides* whatever uses it.

| Key | What it controls |
| --- | --- |
| `hero_name` | Your name in the hero (first word on line one, the rest on line two), the footer and page titles |
| `hero_title` | The small line above your name |
| `hero_tagline` | The paragraph under your name |
| `hero_stats` | The stats row. One `number \| label` per line, e.g. `5+ \| Years`. Empty hides the row |
| `open_to_work` | On shows the green "Open to opportunities" badge |
| `currently_building` | Shows a purple badge with this text. Empty hides it |
| `about_text` | The About section. Separate paragraphs with a blank line. Empty hides the section and its nav link |
| `profile_photo` | Photo beside the About text (see "Files" below) |
| `cv_url` | Turns on every **Download CV** button (nav, mobile menu, hero, About) |
| `og_image` | The picture shown when someone shares your link |
| `github_url`, `linkedin_url`, `email`, `phone`, `location` | Contact details used in the hero, contact section, footer and structured data. **`email` is also where contact-form messages are delivered** |

**Files for `cv_url`, `profile_photo` and `og_image`.** Each accepts either a full link (`https://…`) or a path inside the project's `public/` folder. For example, save your CV as `public/cv/my-cv.pdf` and enter `cv/my-cv.pdf`. Use a PNG or JPG for the share image (about 1200×630); LinkedIn and Slack ignore SVG.

## Typical jobs

**Add a new project**
Projects → New → fill the title, short description, tags and thumbnail → fill the **Case study** box → turn on **Published** → Save.

**Add a new job**
Work Experience → New → role, company, period, dates, bullets, sub-projects → Save. If it is your current job, switch **Is current** on and leave End date empty.

**Turn on "Open to work"**
Site Settings → `open_to_work` → switch on → Save.

**Add your CV**
Copy the PDF to `public/cv/`, then Site Settings → `cv_url` → `cv/your-file.pdf` → Save.

**Take something down without deleting it**
Projects: turn **Published** off. Skills and Certifications: turn **Is visible** off. Blog: turn **Published** off.

## Good to know

- **Uploaded images** (thumbnails, blog covers) are stored in the app's `storage` folder and shown through a link at `/storage`. If you run it with Docker, make sure that storage survives redeploys (see [deployment.md](deployment.md)), or the uploads disappear.
- **Section titles and layout** (for example "Featured Projects", "Dev Notes") are fixed in the code, not editable here.
- **Hero cards:** a featured project without a saved position is placed automatically, so new featured projects from the admin panel show up in the hero without any extra step. The seeded projects keep their hand-picked positions.
