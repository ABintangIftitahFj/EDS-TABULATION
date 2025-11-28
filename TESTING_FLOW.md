# Testing Flow - Complete Match System

## Prerequisites
1. Run migrations: `php artisan migrate`
2. Make sure you have at least one tournament created
3. Have some teams and adjudicators in the database

## Step-by-Step Testing Flow

### Step 1: Create a Round
**URL**: `/admin/rounds/create`

**Input Data**:
```
Tournament: Select existing tournament
Round Name: "Preliminary Round"
Round Number: 1
Start Date: 2025-11-29 09:00
End Date: 2025-11-29 12:00
Motion: "This House believes that..."
Info Slide: "Additional context..."
```

**Expected Result**: Round created successfully

---

### Step 2: Create a Match
**URL**: `/admin/matches/create`

**Input Data**:
```
Round: Select the round created in Step 1
Room: Select a room
Government Team: Team Alpha (ID: 1)
Opposition Team: Team Bravo (ID: 2)
Adjudicator: Select adjudicator
```

**Expected Result**: Match created with status "not_started"

---

### Step 3: Submit Adjudicator Reviews
**URL**: `/admin/matches/{match_id}/reviews`

#### Review 1:
```
Adjudicator: Adjudicator 1 (ID: 101)
Score for Gov Team: 75
Score for Opp Team: 70
Comment: "Team Alpha had slightly stronger arguments"
```

#### Review 2:
```
Adjudicator: Adjudicator 2 (ID: 102)
Score for Gov Team: 78
Score for Opp Team: 72
Comment: "Team Alpha showed better argument consistency"
```

**Expected Result**: 
- Both reviews submitted successfully
- Reviews displayed on the page

---

### Step 4: Automatic Score Calculation
**What Happens Automatically**:

1. **Final Scores Calculated**:
   - Final Score Gov = (75 + 78) / 2 = **76.5**
   - Final Score Opp = (70 + 72) / 2 = **71.0**

2. **Winner Determined**:
   - Winner: **Team Alpha** (Gov Team)

3. **Match Status Updated**:
   - Status changed to: **"finished"**

4. **Team Records Updated**:
   - Team Alpha: `total_wins` +1
   - Team Bravo: `total_losses` +1

5. **Adjudicator Stats Updated**:
   - Adjudicator 1: `total_matches_judged` +1
   - Adjudicator 2: `total_matches_judged` +1
   - Both: `average_score_given` recalculated

---

### Step 5: Verify Results
**Check Match Details**: `/admin/matches/{match_id}/reviews`

**Expected Display**:
```
Match Status: Finished
Final Score (Gov): 76.50
Final Score (Opp): 71.00
Winner: Team Alpha
```

**Check Team Records**: `/admin/teams`
```
Team Alpha:
- Total Wins: 1
- Total Losses: 0

Team Bravo:
- Total Wins: 0
- Total Losses: 1
```

**Check Adjudicator Stats**: `/admin/adjudicators`
```
Adjudicator 1:
- Total Matches Judged: 1
- Average Score Given: 72.50

Adjudicator 2:
- Total Matches Judged: 1
- Average Score Given: 75.00
```

---

## Database Schema Reference

### Match Table
```
- id
- round_id
- room_id
- gov_team_id (Team A)
- opp_team_id (Team B)
- adjudicator_id
- final_score_team_a (calculated)
- final_score_team_b (calculated)
- winner_team_id (calculated)
- status (not_started|ongoing|finished)
```

### AdjudicatorReview Table
```
- id
- match_id
- adjudicator_id
- score_team_a
- score_team_b
- comment
```

### Team Table
```
- id
- name
- institution
- total_wins (auto-updated)
- total_losses (auto-updated)
- total_draws (auto-updated)
```

### Adjudicator Table
```
- id
- name
- institution
- rating
- total_matches_judged (auto-updated)
- average_score_given (auto-updated)
```

---

## API Endpoints

### Adjudicator Reviews
```
GET  /admin/matches/{match}/reviews  - View/Add reviews
POST /admin/matches/{match}/reviews  - Submit review
DELETE /admin/reviews/{review}        - Delete review
```

---

## Testing Checklist

- [ ] Round creation with dates works
- [ ] Match creation works
- [ ] Multiple adjudicators can review same match
- [ ] Final scores calculated correctly
- [ ] Winner determined correctly
- [ ] Match status updates to "finished"
- [ ] Team win/loss records update
- [ ] Adjudicator stats update
- [ ] Cannot submit duplicate review (same adj, same match)
- [ ] Can delete reviews
- [ ] Reviews display correctly on match page

---

## Common Issues & Solutions

### Issue: Migrations fail
**Solution**: Check if columns already exist, drop and recreate if needed

### Issue: Scores not calculating
**Solution**: Make sure `calculateFinalScores()` is called after review submission

### Issue: Team records not updating
**Solution**: Check `updateTeamRecords()` method in Match model

### Issue: PHP command not found
**Solution**: Use full path: `C:\laragon\bin\php\php-8.3.16-Win32-vs16-x64\php.exe artisan migrate`

---

## Success Criteria

✅ Complete flow from round creation to final results
✅ Automatic score calculation works
✅ Team records update correctly
✅ Adjudicator stats track properly
✅ UI displays all information clearly
✅ Can handle multiple adjudicators per match
