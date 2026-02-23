# IKA SMANSA 277 Sinjai Portal

Portal Alumni IKA SMANSA / 277 Sinjai migrated to CodeIgniter 4.

## Features
- **Alumni Directory:** Registration and management of alumni profiles.
- **QR Code System:** Dynamic QR generation for alumni referrals and profile links.
- **Dashboard:** Analytics and metrics visualization using ApexCharts.
- **News Management:** Admin panel for publishing community updates.

## Requirements
- PHP 8.2+
- MySQL/MariaDB
- Node.js & NPM (for Tailwind CSS)

## Installation
1. **PHP Dependencies:**
   ```bash
   composer install
   ```
2. **JS Dependencies:**
   ```bash
   npm install
   ```
3. **Environment Setup:**
   Copy `env` to `.env` and configure your `app.baseURL` and database credentials.
4. **Build Assets:**
   ```bash
   npm run build
   ```

## Development
- **Tailwind Watcher:** `npm run dev`
- **Local Server:** `php spark serve`

## License
[MIT](LICENSE)