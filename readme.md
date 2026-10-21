# School CEP (Campus Education Platform)

A complete Laravel 8 School Management System with three role-based portals.

## 🌐 Live Demo

**Hosted on Render:** [https://school-cep.onrender.com](https://school-cep.onrender.com)

## 🔐 Login Credentials

| Portal | Username | Password |
|--------|----------|----------|
| **Admin** | `admin` | `password` |
| **Teacher** | `mathematics_teacher` | `password` |
| **Parent** | `parent1` | `password` |

## ✨ Features

### Admin Portal
- Dashboard with school statistics
- Student management (25 demo students)
- Attendance marking with AJAX + monthly reports
- Student Resources (issue/return workflow)
- Calendar with Hindu & Gregorian holidays (20 events)
- Exam Marks management (3 terms: First/Mid/Final)
- Fee/Payment structures & records

### Teacher Portal
- Attendance marking for assigned classes
- Attendance reports with summary stats (Present/Absent/Late %)
- Marks entry & management

### Parent Portal
- My Children view - track student details

## 🛠 Tech Stack

- **Framework:** Laravel 8
- **Language:** PHP 8+
- **Database:** SQLite (production-ready with persistent disk)
- **Frontend:** Bootstrap 4, jQuery, Limitless Admin Theme
- **Authentication:** Laravel Auth + Spatie Permissions
- **Deployment:** Render.com (auto-deploy from GitHub)

## 🚀 Quick Start (Local)

```bash
git clone https://github.com/kasbe0006/School-Management-School.git
cd School-Management-School
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

## 📦 Deployment (Render.com)

1. Fork this repo
2. Go to [Render Dashboard](https://dashboard.render.com)
3. New → Blueprint → Connect GitHub repo
4. Auto-detects `render.yaml` - click Apply

The `render.yaml` includes:
- Persistent disk for SQLite database
- Auto-migrations + MasterDemoSeeder on deploy
- Config/route/view caching

## 📁 Project Structure

```
app/
├── Http/Controllers/
│   ├── SupportTeam/     # Admin/Teacher controllers
│   ├── MyParent/        # Parent portal
│   └── SuperAdmin/      # Settings
├── Models/              # Eloquent models
└── Helpers/             # Qs, Mk, Pay helpers

resources/views/
├── pages/
│   ├── support_team/    # Admin/Teacher views
│   └── my_parent/       # Parent views
```

## 📊 Seeded Demo Data

- 30 Users (1 admin, 10 teachers, 15 parents, 25 students, 2 accountants, 1 librarian)
- 10 Classes × 3 sections each
- 20 Calendar events (Diwali, Holi, Gandhi Jayanti, Christmas, etc.)
- 30 days attendance records
- 3 Exams with marks
- Fee structures per class
- 104 Student resources issued

## 📝 License

MIT License - Feel free to use for educational purposes.