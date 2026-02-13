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
    ## Generate application key (if not already set)
    docker compose exec backend php artisan key:generate --ansi

    ## Run migrations and seed the database (if you have seeders)
    docker compose exec backend php artisan migrate --seed

    ## Create symbolic link for storage (important for images)
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

## Authentication Modes

The project supports **two authentication modes** so it can adapt to different deployment scenarios and preferences:

Mode
- Bearer Token (default) : Stateless authentication using JWT-like tokens stored in localStorage. | `NEXT_PUBLIC_STATEFUL_AUTH=false` (default)
- Cookie-based (stateful) : Uses Laravel Sanctum cookies + sessions. Automatic credential sending. | `NEXT_PUBLIC_STATEFUL_AUTH=true` + Laravel `STATEFUL_AUTH=true`

### 1. Bearer Token Mode (Recommended for most API + SPA setups)

This is the default mode — no extra configuration needed.

**Frontend behavior:**
- Token stored in `localStorage`
- Automatically attached via Axios interceptor (`Authorization: Bearer ...`)
- Works perfectly with different ports/domains via Next.js proxy

**Backend behavior:**
- Sanctum issues personal access tokens
- CSRF protection disabled for `/api/*` (safe for token auth)

**When to use:**
- Frontend & backend on different domains/ports (e.g. Vercel + Laravel Forge)
- Planning mobile apps or third-party integrations
- Want stateless, explicit control

### 2. Cookie-based Sanctum Mode (Stateful / Session-like)

Enable this for a more traditional web-app feel (recommended when selling to non-technical buyers or same-domain deployments).

**How to enable:**

1. In **Next.js** `.env.local` (or production env):
   NEXT_PUBLIC_STATEFUL_AUTH=true

2. In **Laravel** `.env`:
   STATEFUL_AUTH=true
   SANCTUM_STATEFUL_DOMAINS=localhost:3000,127.0.0.0.1:3000,yourdomain.com
   SESSION_DOMAIN=.yourdomain.com #leading dot for subdomains

3. Clear caches:
   ```bash
   php artisan optimize:clear
