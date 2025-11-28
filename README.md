# EDS UPI - Web & Tabulation System Documentation

This document outlines the complete flow, database structure, and technical implementation of the EDS UPI Website and Tabulation System.

## 1. System Overview
The system is a hybrid web application serving two main purposes:
1.  **Company Profile**: Showcasing EDS UPI's profile, news, members, and achievements.
2.  **Tabulation System**: A full-featured debate tournament management system supporting Asian Parliamentary (AP) and British Parliamentary (BP) formats.

### Technology Stack
-   **Framework**: Laravel 11 (PHP).
-   **Frontend**: Blade Templates, Tailwind CSS (v4), Alpine.js (optional).
-   **Database**: MySQL (managed via Eloquent ORM).
-   **Storage**: Local file system (`storage/app/public`) for image uploads.

---

## 2. Database Schema (Data Structure)

The database is designed using Eloquent models. Below is the schema breakdown:

### A. Core & Authentication
| Table | Description | Key Fields |
| :--- | :--- | :--- |
| `users` | Admin & Tabulator accounts | `name`, `email`, `password` (hashed), `role` |

### B. Company Profile (Public Content)
| Table | Description | Key Fields |
| :--- | :--- | :--- |
| `articles` | News & Blog posts | `title`, `slug`, `content`, `image_path`, `category` |
| `members` | Organization members | `name`, `role`, `batch`, `photo_path`, `is_star` |
| `competition_histories` | External competition results | `name`, `result`, `year`, `team_members` |
| `achievements` | Specific awards | `title`, `date`, `photo_path` |

### C. Tabulation System (Tournament Core)
This is the most complex part of the system, handling the logic for debate tournaments.

#### 1. Tournament Setup
-   **`tournaments`**: The main event entity.
    -   Fields: `name`, `format` (asian/british), `status` (upcoming/ongoing/completed).
-   **`institutions`**: Participating universities/schools.
-   **`rooms`**: Venues for matches.
    -   Fields: `name`, `location`, `capacity`.

#### 2. Participants
-   **`teams`**: Debate teams.
    -   Fields: `name`, `institution_id`, `total_vp`, `total_speaker_score`, `rank`.
-   **`speakers`**: Individual debaters within teams.
    -   Fields: `name`, `team_id`, `total_score`, `speaker_rank`.
-   **`adjudicators`**: Judges.
    -   Fields: `name`, `institution_id`, `level` (trainee/chair/accredited).

#### 3. Matchmaking & Scoring
-   **`rounds`**: A specific round in the tournament.
    -   Fields: `motion`, `info_slide`, `is_draw_published`, `is_motion_published`.
-   **`matches`**: A single debate match in a room.
    -   **AP Format**: Links `gov_team_id` vs `opp_team_id`.
    -   **BP Format**: Links `og_team_id`, `oo_team_id`, `cg_team_id`, `co_team_id`.
    -   **Judges**: Links `Adjudicator` (Chair) and Panelists.
    -   **Result**: Stores `winner_id` (AP) or Rankings (BP).
-   **`ballots`**: Individual score sheets.
    -   Fields: `match_id`, `adjudicator_id`, `speaker_id`, `score`.
-   **`adjudicator_feedbacks`**: Feedback from teams to judges.
    -   Fields: `rating` (1-5), `comment`.

---

## 3. Business Process Flows

### A. Public User Flow
1.  **Landing Page**: Users view "Hero" section, "About Us", and "Latest News" (Route: `/`).
2.  **Tournament List**: Users navigate to `/tournaments`.
    -   Controller fetches list via `Tournament::all()`.
3.  **Tournament Detail**:
    -   Users view Standings (`/tournaments/{id}/standings`).
    -   Users view Match Pairings/Draw (`/tournaments/{id}/matches`).
    -   Users view Motions (if published).

### B. Admin / Tabulator Flow (Tournament Management)
1.  **Initialization**:
    -   Admin creates a Tournament via Dashboard.
    -   Admin imports/creates Teams, Adjudicators, and Rooms.
2.  **Running a Round**:
    -   **Create Round**: Admin creates "Round 1".
    -   **Pairing**: Admin generates matches (Manual or Auto-pairing logic).
    -   **Publish Draw**: Admin toggles "Show Draw".
    -   **Launch Motion**: Admin toggles "Show Motion".
3.  **Scoring (Ballot Entry)**:
    -   Adjudicators/Admins submit scores via Ballot Form.
    -   System validates scores (e.g., 68-82 range for AP).
    -   System updates Match Result.
4.  **Tabulation**:
    -   Admin triggers "Recalculate Standings".
    -   System aggregates VP and Speaker Scores.
    -   Teams and Speakers are re-ranked.

---

## 4. Technical Implementation Flows

### A. Frontend Architecture (Blade Templates)
The frontend uses Laravel Blade templates with Tailwind CSS.

-   **`resources/views/welcome.blade.php`**: Landing page.
-   **`resources/views/tournaments/index.blade.php`**: List of tournaments.
-   **`resources/views/tournaments/show.blade.php`**: Tournament dashboard.
    -   `standings.blade.php`: Displays Team & Speaker standings.
    -   `matches.blade.php`: Displays the Draw.
-   **`resources/views/admin/`**: Protected views for CMS and Tabulation.
    -   `matches/index.blade.php`: The "Tabbycat" interface for pairing.

### B. Backend Architecture (Laravel)
The backend follows the standard MVC pattern.

**1. Routes (`routes/web.php`)**:
-   Defines all web routes.
-   Middleware groups for `auth` and `admin`.

**2. Controllers (`app/Http/Controllers`)**:
-   **`BallotController`**: Handles complex logic for submitting scores.
    -   *Flow*: Validate Request -> Check Match Status -> Save Ballot -> Update Match Winner -> Update Team Stats.
-   **`StandingsController`**: Aggregates data.
    -   *Flow*: Query Teams -> Join with Ballots/Matches -> Calculate Sums -> Sort -> Return View.
-   **`SetupController`**: Handles CSV imports and CRUD.

**3. Models (`app/Models/`)**:
-   Defines Eloquent relationships (`hasMany`, `belongsTo`).
-   Scopes for filtering (e.g., `scopePublished`).

### C. Key Algorithms
-   **Standings Calculation**:
    -   Iterate through all *completed* matches.
    -   For AP: Winner gets +1 VP.
    -   For BP: Rank 1=+3, Rank 2=+2, Rank 3=+1, Rank 4=+0 VP.
    -   Sum total speaker scores from `ballots` table.
    -   Update `teams` table with new totals.

---

## 5. Routes Summary

### Public
-   `GET /` (Home)
-   `GET /tournaments`
-   `GET /tournaments/{id}/standings`
-   `GET /tournaments/{id}/matches`

### Protected (Admin)
-   `GET/POST /login`
-   `POST /admin/rounds`
-   `POST /admin/ballots` (Submit Score)
-   `PUT /admin/matches/{id}/result`
-   `POST /admin/standings/recalculate`

---

## 6. Setup & Installation

1.  **Database**: Create a MySQL database named `eds_upi`.
2.  **Installation**:
    ```bash
    composer install
    npm install
    cp .env.example .env
    php artisan key:generate
    php artisan migrate
    ```
3.  **Run**:
    ```bash
    npm run dev
    php artisan serve
    ```
