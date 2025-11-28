# EDS Tabulation - Advanced Features Implementation Plan

## Overview
This document outlines the implementation plan for advanced features including Match Scoring Dashboard, Ballot Password System, Publish Controls, Ballot Status Tracker, and AJAX Implementation.

---

## Phase 1: Database Migrations

### 1.1 Add Ballot Password to Matches
```bash
php artisan make:migration add_ballot_password_to_matches_table
```

**Migration Content:**
```php
public function up()
{
    Schema::table('matches', function (Blueprint $table) {
        $table->string('ballot_password')->nullable()->after('status');
        $table->boolean('is_ballot_submitted')->default(false)->after('ballot_password');
    });
}
```

### 1.2 Add Publish Controls to Rounds
```bash
php artisan make:migration add_publish_controls_to_rounds_table
```

**Migration Content:**
```php
public function up()
{
    Schema::table('rounds', function (Blueprint $table) {
        $table->boolean('is_draw_published')->default(false)->after('is_published');
        $table->timestamp('draw_published_at')->nullable()->after('is_draw_published');
        $table->timestamp('motion_published_at')->nullable()->after('is_motion_published');
    });
}
```

---

## Phase 2: Controllers

### 2.1 Match Scoring Controller
**File:** `app/Http/Controllers/Admin/MatchScoringController.php`

**Methods:**
- `index()` - List all tournaments
- `show($tournament)` - Show tournament dashboard with rounds
- `dashboard($tournament)` - Detailed scoring dashboard
- `getMatchDetails($match)` - AJAX endpoint for match details

### 2.2 API Match Management Controller
**File:** `app/Http/Controllers/Api/MatchManagementController.php`

**Methods:**
- `getRounds($tournament)` - Get rounds by tournament
- `getMatches($round)` - Get matches by round
- `submitScore($match)` - Submit ballot scores
- `publishDraw($round)` - Publish draw
- `publishMotion($round)` - Publish motion
- `getBallotStatus($tournament, $round)` - Get ballot completion status
- `verifyBallotPassword()` - Verify ballot password

---

## Phase 3: Views

### 3.1 Match Scoring Dashboard
**File:** `resources/views/admin/match-scoring/index.blade.php`

**Features:**
- List all tournaments with stats
- Click to view tournament dashboard
- Visual indicators for completion

### 3.2 Tournament Scoring Dashboard
**File:** `resources/views/admin/match-scoring/show.blade.php`

**Features:**
- Round selector dropdown
- Match list with status badges
- Progress bar for ballot completion
- Quick actions (publish, score)

### 3.3 Ballot Input Modal
**Component:** Reusable modal for ballot input

**Features:**
- Password verification
- Speaker score inputs
- Feedback textarea
- AJAX submission

---

## Phase 4: Frontend (AJAX)

### 4.1 JavaScript Setup
**File:** `resources/js/match-scoring.js`

**Functions:**
- `loadRounds(tournamentId)` - Load rounds via AJAX
- `loadMatches(roundId)` - Load matches via AJAX
- `submitBallot(matchId, data)` - Submit ballot via AJAX
- `publishDraw(roundId)` - Publish draw via AJAX
- `publishMotion(roundId)` - Publish motion via AJAX
- `updateBallotStatus()` - Real-time status update

### 4.2 CSRF Token Setup
Already added in admin layout:
```html
<meta name="csrf-token" content="{{ csrf_token() }}">
```

---

## Phase 5: Features Implementation

### 5.1 Ballot Password System

**Flow:**
1. Admin sets password when creating match
2. Adjudicator enters password before scoring
3. System verifies password via AJAX
4. If correct, show ballot form
5. If wrong, show error message

**Security:**
- Hash passwords in database
- Rate limiting on verification attempts
- Log all verification attempts

### 5.2 Publish Draw/Motion Controls

**Admin Controls:**
- Toggle button for draw publish
- Toggle button for motion publish
- Timestamp tracking

**User Side:**
- Show/hide based on publish status
- Display publish timestamp
- Countdown timer (optional)

### 5.3 Ballot Status Tracker

**Dashboard Display:**
- Progress bar per round
- Percentage completed
- List of pending matches
- List of completed matches

**Real-time Updates:**
- WebSocket (optional)
- AJAX polling every 30s
- Manual refresh button

---

## Phase 6: Testing Checklist

### 6.1 Match Scoring Dashboard
- [ ] Can view all tournaments
- [ ] Can click tournament to view dashboard
- [ ] Dashboard shows all rounds
- [ ] Can select round to view matches
- [ ] Match status displays correctly

### 6.2 Ballot Password
- [ ] Can set password for match
- [ ] Password verification works
- [ ] Wrong password shows error
- [ ] Correct password shows form
- [ ] Password is hashed in database

### 6.3 Publish Controls
- [ ] Can toggle draw publish
- [ ] Can toggle motion publish
- [ ] User side respects publish status
- [ ] Timestamps are recorded
- [ ] Published content is visible

### 6.4 Ballot Status
- [ ] Progress bar shows correct percentage
- [ ] Completed matches are marked
- [ ] Pending matches are listed
- [ ] Status updates in real-time

### 6.5 AJAX Implementation
- [ ] No page reload on submit
- [ ] Loading indicators work
- [ ] Error messages display
- [ ] Success messages display
- [ ] Data updates correctly

---

## Phase 7: Deployment Steps

1. **Run Migrations:**
   ```bash
   php artisan migrate
   ```

2. **Clear Cache:**
   ```bash
   php artisan cache:clear
   php artisan config:clear
   php artisan route:clear
   php artisan view:clear
   ```

3. **Compile Assets:**
   ```bash
   npm run build
   ```

4. **Test All Features:**
   - Follow testing checklist
   - Fix any bugs found
   - Document any issues

---

## Priority Order

1. **HIGH PRIORITY:**
   - Match Scoring Dashboard
   - Ballot Status Tracker
   - Publish Draw/Motion Controls

2. **MEDIUM PRIORITY:**
   - Ballot Password System
   - AJAX Implementation (basic)

3. **LOW PRIORITY:**
   - Real-time updates (WebSocket)
   - Advanced AJAX features

---

## Estimated Timeline

- **Phase 1 (Migrations):** 30 minutes
- **Phase 2 (Controllers):** 2 hours
- **Phase 3 (Views):** 3 hours
- **Phase 4 (AJAX):** 2 hours
- **Phase 5 (Features):** 3 hours
- **Phase 6 (Testing):** 2 hours

**Total:** ~12-14 hours

---

## Notes

- Start with migrations first
- Test each phase before moving to next
- Keep backup of database before migrations
- Document any custom configurations
- Update this plan as needed

---

## Next Steps

1. Review this plan
2. Run Phase 1 migrations
3. Implement controllers (Phase 2)
4. Build views (Phase 3)
5. Add AJAX (Phase 4)
6. Test everything (Phase 6)

**Ready to start? Begin with Phase 1!**
