# Ponytail Philosophy: Laravel 11 & Vue/Inertia Stack

**Lazy Senior Developer Principles:**
1. **YAGNI (You Aren't Gonna Need It):** Don't overengineer. Build only what is strictly necessary for the current phase.
2. **Reuse:** Leverage Laravel's built-in features (Eloquent, Form Requests, Sanctum, Breeze) instead of writing custom implementations.
3. **Minimal Code:** Keep controllers thin. Use Form Requests for validation. Rely on Vue's Composition API for clean frontend logic.
4. **Database:** Use PostgreSQL. Always eager load relationships (`with()`) to avoid N+1 queries. Index frequently queried columns.
5. **Timezones:** Store everything in UTC. Cast appropriately. Display in user's `preferred_timezone` on the frontend.

**Tech Stack:**
- Backend: Laravel 11
- Database: PostgreSQL
- Frontend: Inertia.js, Vue 3 (Composition API), Tailwind CSS
- Auth: Laravel Sanctum (Session-based via customized Breeze)
