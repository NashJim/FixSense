# FixSense

[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)

FixSense is a PHP web application (designed for XAMPP) that provides automotive diagnostics, simulations, and student/lecturer dashboards for learning vehicle systems. The project contains simulation pages, student performance tracking, and scenario management.

## Features
- Multiple simulation pages for different vehicle systems (engine, brakes, transmission, suspension, etc.).
- Student dashboard and lecturer views with performance and scenario management.
- CRUD for scenarios and extra notes; CSV export of reports.

## Quick start (Windows + XAMPP)
1. Install XAMPP and start Apache + MySQL.
2. Place the project in your XAMPP `htdocs` directory (e.g., `C:\xampp\htdocs\FixSense`).
3. Import the database (if provided) via phpMyAdmin or MySQL CLI. Example SQL file is in `db/`.
4. Configure database credentials in your project configuration (adjust `config` or DB connection file as needed).
5. Open `http://localhost/FixSense/` in your browser.

## Project structure
- PHP entry points and pages at project root (e.g., `index.php`, `studentDashboard.php`).
- `css/` for styles, `js/` for scripts, `uploads/` for user uploads.
- `db/` contains SQL dumps and migration files.

## Notes and recommendations
- Do not commit sensitive files or credentials. Use `.env` or another secrets mechanism.
- Remove or secure any test/demo accounts before deploying to production.
- Consider adding Composer and a `composer.json` if you later add PHP dependencies.

## License
This repository does not include a license file. Add one if you plan to open-source the project.

---
For any questions or help pushing this repository to GitHub, run the commands in the project root or let me know to continue.
