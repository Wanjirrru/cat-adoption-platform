# Cat Adoption Platform (with DevOps Practices)

A full-stack web application for managing cat adoptions, featuring role-based access control, cat profiles, adoption requests, and responsive UI.

**Tech Stack**
- **Backend**: Laravel (API-only) + PHP 8.4 + MySQL
- **Frontend**: Next.js (App Router) + TypeScript + Tailwind CSS
- **DevOps**: Docker, Docker Compose, Nginx (reverse proxy), GitHub Actions-ready CI/CD pipeline (coming soon)
- **Databases**: MySQL (primary), optional MongoDB support

## Features (Current & Planned)
- Role-based access (Super admin, admin, user)
- Cat listing with images, breeds, ages
- Adoption request forms
- Secure API authentication (Sanctum)
- Responsive design across devices
- Containerized deployment (local & production-ready)

## Local Development with Docker

### Prerequisites
- Docker & Docker Compose installed
- Git

### Setup & Run
1. Clone the repository:
   ```bash
   git clone https://github.com/Wanjirrru/cat-adoption-platform.git
   cd cat-adoption-platform

2. Start the stack:
    docker compose up -d --build
    (The first run may take a few minutes to build the images.)

3.  Run Laravel migrations & seed:
    # Generate application key (if not already set)
    docker compose exec backend php artisan key:generate --ansi

    # Run migrations and seed the database (if you have seeders)
    docker compose exec backend php artisan migrate --seed

    # Create symbolic link for storage (important for images)
    docker compose exec backend php artisan storage:link

4.  Access the app:
    Frontend (Next.js): http://localhost:3000
    API (via Nginx): http://localhost:8000/api
     (Test endpoints like /api/cats in browser or Postman)

## Useful Commands
Stop everything: 
- docker compose down

Stop and remove volumes (full clean reset — use with caution): 
- docker compose down --volumes

View live logs for a specific service: 
- docker compose logs -f frontend    # or backend, nginx, db

Restart a single service (e.g. after code changes): 
- docker compose restart frontend

Rebuild and force recreate everything: 
- docker compose up -d --build --force-recreate

Enter the backend container shell (for artisan commands, tinker, etc.): 
- docker compose exec backend bash

## Development Notes
The frontend uses NEXT_PUBLIC_API_URL from .env.local (set to http://localhost:8000/api for local testing).

In the Docker environment, the frontend communicates with the backend via the internal network name nginx:80/api.

If developing the frontend outside Docker, run:
- cd frontend && npm run dev
