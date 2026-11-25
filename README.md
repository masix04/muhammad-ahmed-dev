# Career Portfolio

My personal portfolio site: a one-page showcase of projects, work experience, skills and writing, with a contact form and an admin panel so I can update everything without touching code.

Built with **Laravel 13**, **Livewire 4**, **Filament 5**, **Tailwind CSS 4** and **Alpine.js**, on **SQLite**.

## What's on the site

| Section | Notes |
| --- | --- |
| Hero | Name, title, tagline, stats row, "open to work" and "currently building" badges, and an interactive 3D-style card stack of featured projects |
| About | Short bio with an optional photo. Hidden until text is set |
| Projects | Filter by technology; each card opens a detail modal (video or screenshot, description, tech tags, code and live links) |
| Experience | Career timeline with the projects built at each role |
| Skills, Certifications | Grouped and managed from the admin panel |
| Dev Notes | A blog at `/blog` and `/blog/{slug}` |
| Contact | Saves the message, emails it to me, and is protected by a honeypot and a rate limit |

Also included: share previews (Open Graph / Twitter tags), structured data for search engines, `/sitemap.xml`, `/robots.txt`, a mobile menu, and an optional "Download CV" button.

## Running it locally

You need PHP 8.3+, Composer, and Node 22+.

```bash
composer install
npm install

cp .env.example .env
php artisan key:generate

# SQLite database file (Laravel's default location)
touch database/database.sqlite

php artisan migrate
php artisan db:seed

php artisan storage:link        # makes uploaded images reachable
php artisan make:filament-user  # creates your admin login

npm run dev                     # in one terminal
php artisan serve               # in another
```

The site is at `http://localhost:8000` and the admin panel at `/admin`.

Contact messages are emailed using the `MAIL_*` settings in `.env`. With the default `MAIL_MAILER=log`, emails are written to `storage/logs/laravel.log` instead of being sent.

## Editing content

Everything is edited in the admin panel (`/admin`): projects, work experience, skills, certifications, blog posts, and incoming contact messages.

**Site Settings** controls the text and links that appear all over the site. Values can be edited, keys can't be changed or added.

| Key | What it does |
| --- | --- |
| `hero_name`, `hero_title`, `hero_tagline` | The hero heading and intro; the name is also used in the footer and page titles |
| `hero_stats` | One `number \| label` per line (for example `5+ \| Years`). Empty hides the row |
| `open_to_work` | Shows the "Open to opportunities" badge |
| `currently_building` | Shows a badge with this text. Empty hides it |
| `about_text` | The About section. Separate paragraphs with a blank line. Empty hides the section |
| `profile_photo` | Photo beside the About text. A full URL, or a path inside `public/` |
| `cv_url` | Turns on every "Download CV" button. A full URL, or a path inside `public/` (for example `cv/my-cv.pdf`) |
| `og_image` | Image shown when the site is shared. PNG or JPG, about 1200×630 |
| `github_url`, `linkedin_url`, `email`, `phone`, `location` | Contact details used across the site. `email` is also where contact-form messages are sent |

## Seeding

| Command | What it does |
| --- | --- |
| `php artisan db:seed` | Safe to run any time. On a brand-new database it loads all the sample content. On an existing one it only adds any missing settings and leaves everything else alone |
| `php artisan db:seed --class=SiteSettingsSeeder` | Adds missing settings only |
| `php artisan db:seed --class=PortfolioSeeder` | **Deletes** all projects, experience, skills and certifications and reloads the sample data |

## Deploying with Docker

The `Dockerfile` builds the frontend, installs PHP dependencies, and starts the site through `docker-entrypoint.sh`, which on every start:

1. creates the SQLite file if it doesn't exist,
2. links `public/storage`,
3. runs the migrations,
4. runs `db:seed` (which is safe to repeat, see above),
5. serves the site on `$PORT` (default `10000`).

Environment variables to set on your host:

- `APP_ENV=production`, `APP_DEBUG=false`, `APP_KEY` (from `php artisan key:generate --show`), `APP_URL`
- `DB_CONNECTION=sqlite` and `DB_DATABASE`
- `MAIL_*` so contact-form emails are really sent

**Keeping your data between deploys.** A container's disk is wiped on every redeploy, and that includes the SQLite file and any images uploaded in the admin panel. To keep them, attach a persistent disk and point `DB_DATABASE` at it (for example `/var/data/portfolio.sqlite`). Uploaded images live in `storage/app/public`, so that folder needs a persistent disk too, or you can store uploads in S3.

The site trusts the hosting platform's proxy headers so the contact form's rate limit sees each visitor's real IP address. Only deploy it behind a proxy or load balancer that sets `X-Forwarded-For`.

## Tests

```bash
php artisan test
```

They cover the home page and its share tags, the blog, the contact form (saving, emailing, spam protection, rate limit), project filtering and the modal, settings, the sitemap and robots.txt, and that re-seeding never overwrites edited content.

## Project layout

```
app/Livewire/            Page sections (projects grid, timeline, skills, blog, contact form)
app/Filament/Resources/  Admin panel screens
app/Models/SiteSetting   Reads all settings once per request; helpers for links and stat lines
database/seeders/        PortfolioSeeder (sample content) and SiteSettingsSeeder (defaults)
resources/views/         Blade views: home, blog, sitemap, Livewire components, mail
resources/js/            workspace-hero.js (the hero card stack)
```
