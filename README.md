# Product Management System (Lab Exercise 6)

A full-stack CRUD application with **React + Vite** frontend and **LavaLust API** backend, using **Aiven MySQL** database and deployed to **Render**.

---

## Quick Start (Local Development)

### 1. Start the API
```bash
cd C:/xampp/htdocs/crudlab6
php lava serve --port=3000
```
API runs at `http://localhost:3000`

### 2. Start the Frontend
```bash
cd C:/xampp/htdocs/crudlab6/frontend
npm install   # if not already done
npm run dev
```
Frontend runs at `http://localhost:5173`

### 3. Login
- **Username:** `admin`
- **Password:** `admin123`

---

## API Endpoints

| Method | Endpoint | Auth | Description |
|--------|----------|------|-------------|
| POST | `/api/auth/login` | ❌ | Login, returns JWT tokens |
| POST | `/api/auth/refresh` | ❌ | Refresh access token |
| POST | `/api/auth/logout` | ❌ | Revoke refresh token |
| GET | `/api/auth/me` | ✅ | Get current user |
| GET | `/api/products` | ✅ | List all products |
| GET | `/api/products/{id}` | ✅ | Get single product |
| POST | `/api/products` | ✅ | Create product |
| PUT | `/api/products/{id}` | ✅ | Update product |
| PATCH | `/api/products/{id}` | ✅ | Update product |
| DELETE | `/api/products/{id}` | ✅ | Delete product |

---

## Deployment to Render

### Backend (API)

1. **Create a GitHub repo** for this project (or push current)

2. **Create a Docker Web Service** on Render:
   - Connect your GitHub repo
   - Set `plan: free`
   - Add these **secret** environment variables in Render dashboard:
     - `DB_HOST` — Aiven connection host
     - `DB_PORT` — Aiven port (e.g., `12561`)
     - `DB_USERNAME` — Aiven username (e.g., `avnadmin`)
     - `DB_PASSWORD` — Aiven password
     - `DB_NAME` — Database name (e.g., `defaultdb`)
     - `JWT_SECRET` — Generate a 32+ character random string
     - `REFRESH_TOKEN_KEY` — Generate another 32+ character random string
     - `ALLOW_ORIGIN` — Your frontend URL (e.g., `https://your-frontend.onrender.com`)
     - `APP_ENV` — `production`

3. Deploy — Render builds the Docker container and runs the API.

### Frontend (React)

1. **Build the frontend:**
   ```bash
   cd frontend
   npm install
   npm run build
   ```

2. **Create a Static Site** on Render:
   - Connect your repo (or a separate frontend repo)
   - Build command: `npm install && npm run build`
   - Publish directory: `dist`

3. Add environment variable:
   - `VITE_API_URL` — Your Render API URL (e.g., `https://crudlab6-api.onrender.com`)

4. Deploy.

---

## Database (Aiven MySQL)

- The app uses Aiven MySQL with SSL/TLS
- Required tables are created via migrations (run locally first or add migration runner to Docker):
  ```bash
  php lava migration run
  ```

---

## Migration CLI Command (Lab Activity)

```bash
php lava migration run          # Run pending migrations
php lava migration status       # Show migration status
php lava migration create-migration <name>  # Create new migration
php lava migration rollback     # Rollback last migration
php lava migration rollback-all # Rollback all
php lava migration refresh      # Refresh (rollback all + run)
```

---

## Files Structure

```
crudlab6/
├── app/
│   ├── controllers/
│   │   ├── ApiController.php    # Base API controller
│   │   ├── AuthApi.php          # Login/refresh/logout
│   │   ├── ProductApi.php       # CRUD operations
│   │   └── MigrationController.php
│   ├── models/
│   │   ├── ProductModel.php
│   │   └── UserModel.php
│   ├── commands/
│   │   └── Migration.php        # CLI migration command
│   ├── migrations/
│   │   ├── 000_initial_setup.php
│   │   ├── 001_create_users_table.php
│   │   ├── 002_create_refresh_tokens_table.php
│   │   └── 003_create_products_table.php
│   └── config/
│       ├── api.php              # JWT + CORS config
│       ├── database.php
│       ├── routes.php
│       └── migration.php
├── frontend/                    # React + Vite app
│   ├── src/
│   │   ├── api/                 # Axios client + products API
│   │   ├── context/             # Auth context
│   │   ├── components/          # Navbar, ProtectedRoute
│   │   └── pages/               # Login, ProductList, ProductForm
│   └── dist/                    # Production build
├── docker/
│   └── entrypoint.sh            # Docker entrypoint
├── .env.example
├── Dockerfile
└── render.yaml                  # Render blueprint
```

---

## Screenshots Required (for submission)

1. **Login page** — with admin/admin123
2. **Product list** — showing all products
3. **Add product** — form to create new product
4. **Edit product** — form to update existing product
5. **Delete product** — confirmation and result
6. **Aiven database** — showing tables (migrations, users, refresh_tokens, products)

---

## Notes

- **Never commit `.env`** — contains secrets. Use `.env.example` as template.
- The API returns JSON only (no server-rendered HTML).
- JWT tokens expire after 15 minutes; the frontend auto-refreshes.
- The existing `users` table uses **plaintext** password for backward compatibility, but new users should use bcrypt.