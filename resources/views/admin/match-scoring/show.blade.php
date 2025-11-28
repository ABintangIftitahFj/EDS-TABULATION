@extends('layouts.admin')

@section('title', 'Match Scoring - ' . $tournament->name)

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6 mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <a href="{{ route('admin.match-scoring.index') }}" 
                           class="text-blue-600 hover:text-blue-800 transition-colors">
                            ← Back to Tournaments
                        </a>
                    </div>
                    <h1 class="text-3xl font-bold text-black flex items-center gap-3">
                        🏆 {{ $tournament->name }}
                    </h1>
                    <p class="text-black mt-1">Match scoring and tournament management</p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('admin.tournament-dashboard', $tournament) }}" 
                       class="bg-blue-600 hover:bg-blue-700 text-black px-4 py-2 rounded-lg transition-colors flex items-center gap-2">
                        📊 Dashboard
                    </a>
                </div>
            </div>
        </div>

        <!-- Navigation Tabs -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 mb-8">
            <div class="border-b border-gray-200">
                <nav class="flex space-x-8 px-6" aria-label="Tabs">
                    <button onclick="showTab('scoring')" 
                            class="tab-button border-b-2 border-blue-500 text-blue-600 py-4 px-1 text-sm font-medium" 
                            data-tab="scoring">
                        ⚔️ Match Scoring
                    </button>
                    <button onclick="showTab('management')" 
                            class="tab-button border-b-2 border-transparent text-black hover:text-black hover:border-gray-300 py-4 px-1 text-sm font-medium" 
                            data-tab="management">
                        ⚙️ Draw Management
                    </button>
                    <button onclick="showTab('status')" 
                            class="tab-button border-b-2 border-transparent text-black hover:text-black hover:border-gray-300 py-4 px-1 text-sm font-medium" 
                            data-tab="status">
                        📋 Ballot Status
                    </button>
                </nav>
            </div>
        </div>

        <!-- Match Scoring Tab -->
        <div id="scoring-tab" class="tab-content">
            <!-- Dropdown Flow Selection -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6 mb-8">
                <h2 class="text-xl font-semibold text-black mb-6 flex items-center gap-2">
                    🎯 Select Match to Score
                </h2>
                
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Round Selection -->
                    <div>
                        <label class="block text-sm font-medium text-black mb-2">Round</label>
                        <select id="roundSelect" 
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Select Round...</option>
                            @foreach($rounds as $round)
                            <option value="{{ $round->id }}" data-published="{{ $round->is_published ? 1 : 0 }}">
                                {{ $round->name }}
                                @if($round->is_published) ✅ @else 🔒 @endif
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Match Selection -->
                    <div>
                        <label class="block text-sm font-medium text-black mb-2">Match</label>
                        <select id="matchSelect" 
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                disabled>
                            <option value="">Select Match...</option>
                        </select>
                    </div>

                    <!-- Action Button -->
                    <div class="flex items-end">
                        <button id="loadMatchBtn" 
                                onclick="loadMatchDetails()" 
                                class="w-full bg-blue-600 hover:bg-blue-700 disabled:bg-gray-400 text-black px-4 py-2 rounded-lg transition-colors font-medium" 
                                disabled>
                            🔍 Load Match Details
                        </button>
                    </div>
                </div>
            </div>

            <!-- Match Details & Scoring Interface -->
            <div id="matchScoringInterface" class="hidden">
                <!-- Will be populated by JavaScript -->
            </div>
        </div>

        <!-- Draw Management Tab -->
        <div id="management-tab" class="tab-content hidden">
            <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6">
                <h2 class="text-xl font-semibold text-black mb-6 flex items-center gap-2">
                    ⚙️ Draw & Motion Management
                </h2>
                
                <div class="space-y-6">
                    @foreach($rounds as $round)
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h3 class="text-lg font-semibold text-black">{{ $round->name }}</h3>
                                <p class="text-sm text-black">{{ $round->matches_count ?? 0 }} matches</p>
                            </div>
                            <div class="flex gap-2">
                                <!-- Draw Publication Toggle -->
                                <button onclick="toggleDrawPublication({{ $round->id }}, {{ $round->is_published ? 'false' : 'true' }})" 
                                        class="flex items-center gap-2 px-3 py-1 rounded-lg text-sm font-medium transition-colors
                                               {{ $round->is_published ? 'bg-green-100 text-green-700 hover:bg-green-200' : 'bg-gray-100 text-black hover:bg-gray-200' }}">
                                    @if($round->is_published)
                                        ✅ Published
                                    @else
                                        🔒 Unpublished
                                    @endif
                                </button>
                                
                                <!-- Motion Publication Toggle -->
                                <button onclick="toggleMotionPublication({{ $round->id }}, {{ $round->is_motion_published ? 'false' : 'true' }})" 
                                        class="flex items-center gap-2 px-3 py-1 rounded-lg text-sm font-medium transition-colors
                                               {{ $round->is_motion_published ? 'bg-blue-100 text-blue-700 hover:bg-blue-200' : 'bg-gray-100 text-black hover:bg-gray-200' }}">
                                    @if($round->is_motion_published)
                                        💡 Motion Live
                                    @else
                                        🔒 Motion Hidden
                                    @endif
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Ballot Status Tab -->
        <div id="status-tab" class="tab-content hidden">
            <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6">
                <h2 class="text-xl font-semibold text-black mb-6 flex items-center gap-2">
                    📋 Ballot Status Overview
                </h2>
                
                <div id="ballotStatusContainer">
                    <!-- Will be loaded via AJAX -->
                    <div class="text-center py-8">
                        <div class="text-4xl mb-4">📊</div>
                        <p class="text-black">Loading ballot status...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Password Verification Modal -->
<div id="passwordModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-black text-center mb-4">🔐 Verify Admin Password</h3>
            <p class="text-sm text-black text-center mb-6">Enter admin password to edit ballot:</p>
            <input type="password" 
                   id="adminPassword" 
                   placeholder="Enter password"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent mb-4">
            <div class="flex justify-center gap-3">
                <button onclick="closePasswordModal()" 
                        class="bg-gray-300 hover:bg-gray-400 text-black px-4 py-2 rounded-lg transition-colors">
                    Cancel
                </button>
                <button onclick="verifyPassword()" 
                        class="bg-blue-600 hover:bg-blue-700 text-black px-4 py-2 rounded-lg transition-colors">
                    Verify
                </button>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script>
const tournamentId = {{ $tournament->id }};
let currentMatchId = null;

// Tab Management
function showTab(tabName) {
    // Hide all tabs
    document.querySelectorAll('.tab-content').forEach(tab => tab.classList.add('hidden'));
    
    // Show selected tab
    document.getElementById(tabName + '-tab').classList.remove('hidden');
    
    // Update tab buttons
    document.querySelectorAll('.tab-button').forEach(button => {
        button.classList.remove('border-blue-500', 'text-blue-600');
        button.classList.add('border-transparent', 'text-black');
    });
    
    document.querySelector(`[data-tab="${tabName}"]`).classList.remove('border-transparent', 'text-black');
    document.querySelector(`[data-tab="${tabName}"]`).classList.add('border-blue-500', 'text-blue-600');
    
    // Load tab-specific content
    if (tabName === 'status') {
        loadBallotStatus();
    }
}

// Round Selection Handler
document.getElementById('roundSelect').addEventListener('change', function() {
    const roundId = this.value;
    const matchSelect = document.getElementById('matchSelect');
    const loadBtn = document.getElementById('loadMatchBtn');
    
    // Reset match selection
    matchSelect.innerHTML = '<option value="">Select Match...</option>';
    matchSelect.disabled = !roundId;
    loadBtn.disabled = true;
    
    if (roundId) {
        // Load matches for selected round
        fetch(`/api/rounds/${roundId}/matches`)
            .then(response => response.json())
            .then(matches => {
                matches.forEach(match => {
                    const option = document.createElement('option');
                    option.value = match.id;
                    option.textContent = `${match.room?.name || 'TBA'} - ${match.gov_team?.name || 'TBA'} vs ${match.opp_team?.name || 'TBA'}`;
                    matchSelect.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error loading matches:', error);
                alert('Error loading matches. Please try again.');
            });
    }
});

// Match Selection Handler
document.getElementById('matchSelect').addEventListener('change', function() {
    document.getElementById('loadMatchBtn').disabled = !this.value;
});

// Load Match Details
function loadMatchDetails() {
    const matchId = document.getElementById('matchSelect').value;
    if (!matchId) return;
    
    currentMatchId = matchId;
    
    fetch(`/api/matches/${matchId}/details`)
        .then(response => response.json())
        .then(data => {
            renderScoringInterface(data);
        })
        .catch(error => {
            console.error('Error loading match details:', error);
            alert('Error loading match details. Please try again.');
        });
}

// Render Scoring Interface
function renderScoringInterface(data) {
    const container = document.getElementById('matchScoringInterface');
    const match = data.match;
    const govSpeakers = data.gov_speakers;
    const oppSpeakers = data.opp_speakers;
    const existingBallots = data.existing_ballots;
    
    const html = `
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-black">
                    🏛️ ${match.room?.name || 'TBA'} - Match Scoring
                </h2>
                <div class="flex items-center gap-2">
                    ${match.is_completed ? '<span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">✅ Completed</span>' : '<span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-medium">⏳ In Progress</span>'}
                </div>
            </div>
            
            <!-- Team Cards -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Government Team -->
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl border-2 border-blue-200 p-6">
                    <h3 class="text-xl font-bold text-blue-900 mb-4 flex items-center gap-2">
                        🏛️ Government: ${match.gov_team?.name || 'TBA'}
                    </h3>
                    <div class="space-y-4" id="govSpeakers">
                        ${govSpeakers.map((speaker, index) => `
                            <div class="bg-white rounded-lg p-4 border border-blue-200">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="font-medium text-black">${speaker.name}</span>
                                    <span class="text-sm text-black">Speaker ${index + 1}</span>
                                </div>
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-sm text-black mb-1">Score</label>
                                        <input type="number" 
                                               id="gov_score_${speaker.id}"
                                               min="50" max="100" 
                                               value="${existingBallots.gov?.find(b => b.speaker_id === speaker.id)?.score || ''}"
                                               class="w-full border border-gray-300 rounded px-2 py-1 text-center">
                                    </div>
                                    <div>
                                        <label class="block text-sm text-black mb-1">Position</label>
                                        <select class="w-full border border-gray-300 rounded px-2 py-1 text-sm">
                                            <option value="${index + 1}" selected>Position ${index + 1}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <label class="block text-sm text-black mb-1">Feedback</label>
                                    <textarea id="gov_feedback_${speaker.id}" 
                                              rows="2" 
                                              placeholder="Optional feedback..."
                                              class="w-full border border-gray-300 rounded px-2 py-1 text-sm resize-none">${existingBallots.gov?.find(b => b.speaker_id === speaker.id)?.feedback || ''}</textarea>
                                </div>
                            </div>
                        `).join('')}
                    </div>
                </div>
                
                <!-- Opposition Team -->
                <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-xl border-2 border-red-200 p-6">
                    <h3 class="text-xl font-bold text-red-900 mb-4 flex items-center gap-2">
                        ⚔️ Opposition: ${match.opp_team?.name || 'TBA'}
                    </h3>
                    <div class="space-y-4" id="oppSpeakers">
                        ${oppSpeakers.map((speaker, index) => `
                            <div class="bg-white rounded-lg p-4 border border-red-200">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="font-medium text-black">${speaker.name}</span>
                                    <span class="text-sm text-black">Speaker ${index + 1}</span>
                                </div>
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-sm text-black mb-1">Score</label>
                                        <input type="number" 
                                               id="opp_score_${speaker.id}"
                                               min="50" max="100" 
                                               value="${existingBallots.opp?.find(b => b.speaker_id === speaker.id)?.score || ''}"
                                               class="w-full border border-gray-300 rounded px-2 py-1 text-center">
                                    </div>
                                    <div>
                                        <label class="block text-sm text-black mb-1">Position</label>
                                        <select class="w-full border border-gray-300 rounded px-2 py-1 text-sm">
                                            <option value="${index + 1}" selected>Position ${index + 1}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <label class="block text-sm text-black mb-1">Feedback</label>
                                    <textarea id="opp_feedback_${speaker.id}" 
                                              rows="2" 
                                              placeholder="Optional feedback..."
                                              class="w-full border border-gray-300 rounded px-2 py-1 text-sm resize-none">${existingBallots.opp?.find(b => b.speaker_id === speaker.id)?.feedback || ''}</textarea>
                                </div>
                            </div>
                        `).join('')}
                    </div>
                </div>
            </div>
            
            <!-- Winner Selection & Submit -->
            <div class="bg-gray-50 rounded-xl border border-gray-200 p-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-end">
                    <div>
                        <label class="block text-sm font-medium text-black mb-2">Match Winner</label>
                        <select id="winnerSelect" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
                            <option value="">Select Winner...</option>
                            <option value="government" ${match.winner_id === match.gov_team_id ? 'selected' : ''}>
                                🏛️ Government (${match.gov_team?.name || 'TBA'})
                            </option>
                            <option value="opposition" ${match.winner_id === match.opp_team_id ? 'selected' : ''}>
                                ⚔️ Opposition (${match.opp_team?.name || 'TBA'})
                            </option>
                        </select>
                    </div>
                    
                    <div class="flex gap-3">
                        ${match.is_completed ? `
                            <button onclick="showPasswordModal()" 
                                    class="bg-orange-600 hover:bg-orange-700 text-black px-6 py-3 rounded-lg transition-colors font-medium flex items-center gap-2">
                                🔐 Edit Ballot
                            </button>
                        ` : ''}
                        <button onclick="submitScores()" 
                                class="bg-green-600 hover:bg-green-700 text-black px-6 py-3 rounded-lg transition-colors font-medium flex items-center gap-2">
                                ${match.is_completed ? '💾 Update Scores' : '✅ Submit Scores'}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    container.innerHTML = html;
    container.classList.remove('hidden');
}

// Submit Scores
function submitScores() {
    if (!currentMatchId) return;
    
    // Collect form data
    const govSpeakers = document.querySelectorAll('#govSpeakers [id^="gov_score_"]');
    const oppSpeakers = document.querySelectorAll('#oppSpeakers [id^="opp_score_"]');
    const winner = document.getElementById('winnerSelect').value;
    
    if (!winner) {
        alert('Please select a match winner.');
        return;
    }
    
    const govScores = [];
    const oppScores = [];
    
    // Collect government scores
    govSpeakers.forEach(input => {
        const speakerId = input.id.replace('gov_score_', '');
        const score = parseFloat(input.value);
        const feedback = document.getElementById(`gov_feedback_${speakerId}`).value;
        
        if (score < 50 || score > 100 || isNaN(score)) {
            alert(`Invalid score for government speaker. Must be between 50-100.`);
            return;
        }
        
        govScores.push({
            speaker_id: parseInt(speakerId),
            score: score,
            feedback: feedback
        });
    });
    
    // Collect opposition scores
    oppSpeakers.forEach(input => {
        const speakerId = input.id.replace('opp_score_', '');
        const score = parseFloat(input.value);
        const feedback = document.getElementById(`opp_feedback_${speakerId}`).value;
        
        if (score < 50 || score > 100 || isNaN(score)) {
            alert(`Invalid score for opposition speaker. Must be between 50-100.`);
            return;
        }
        
        oppScores.push({
            speaker_id: parseInt(speakerId),
            score: score,
            feedback: feedback
        });
    });
    
    // Submit via API
    const payload = {
        winner: winner,
        gov_scores: govScores,
        opp_scores: oppScores,
        adjudicator_id: 1 // Default adjudicator, should be dynamic
    };
    
    fetch(`/api/matches/${currentMatchId}/score`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(payload)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('✅ Scores submitted successfully!');
            loadMatchDetails(); // Reload to show updated status
        } else {
            alert('❌ Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error submitting scores:', error);
        alert('❌ Error submitting scores. Please try again.');
    });
}

// Password Modal Functions
function showPasswordModal() {
    document.getElementById('passwordModal').classList.remove('hidden');
}

function closePasswordModal() {
    document.getElementById('passwordModal').classList.add('hidden');
    document.getElementById('adminPassword').value = '';
}

function verifyPassword() {
    const password = document.getElementById('adminPassword').value;
    
    fetch('/api/verify-ballot-password', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ password: password })
    })
    .then(response => response.json())
    .then(data => {
        if (data.valid) {
            closePasswordModal();
            // Enable editing by removing disabled attributes or changing UI
            alert('✅ Password verified! You can now edit the ballot.');
        } else {
            alert('❌ Invalid password. Please try again.');
        }
    })
    .catch(error => {
        console.error('Error verifying password:', error);
        alert('❌ Error verifying password.');
    });
}

// Draw Management Functions
function toggleDrawPublication(roundId, publish) {
    fetch(`/api/rounds/${roundId}/publish-draw`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ is_published: publish === 'true' })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload(); // Reload to update buttons
        } else {
            alert('Error updating draw publication status.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error updating draw publication status.');
    });
}

function toggleMotionPublication(roundId, publish) {
    fetch(`/api/rounds/${roundId}/publish-motion`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ is_motion_published: publish === 'true' })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload(); // Reload to update buttons
        } else {
            alert('Error updating motion publication status.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error updating motion publication status.');
    });
}

// Load Ballot Status
function loadBallotStatus() {
    fetch(`/api/tournaments/${tournamentId}/ballot-status`)
        .then(response => response.json())
        .then(data => {
            renderBallotStatus(data);
        })
        .catch(error => {
            console.error('Error loading ballot status:', error);
            document.getElementById('ballotStatusContainer').innerHTML = `
                <div class="text-center py-8">
                    <div class="text-4xl mb-4">❌</div>
                    <p class="text-red-600">Error loading ballot status</p>
                </div>
            `;
        });
}

// Render Ballot Status
function renderBallotStatus(matches) {
    const container = document.getElementById('ballotStatusContainer');
    
    if (matches.length === 0) {
        container.innerHTML = `
            <div class="text-center py-8">
                <div class="text-4xl mb-4">📋</div>
                <p class="text-black">No matches found</p>
            </div>
        `;
        return;
    }
    
    const html = `
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">Round</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">Room</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">Government</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">Opposition</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">Result</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">Ballot</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    ${matches.map(match => `
                        <tr class="${match.is_completed ? 'bg-green-50' : 'bg-yellow-50'}">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-black">${match.round}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-black">${match.room}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-black">${match.gov_team}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-black">${match.opp_team}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                ${match.winner ? `<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">${match.winner}</span>` : '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Pending</span>'}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                ${match.ballot_filled === 'Yes' ? '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">✅ Complete</span>' : '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">❌ Incomplete</span>'}
                            </td>
                        </tr>
                    `).join('')}
                </tbody>
            </table>
        </div>
    `;
    
    container.innerHTML = html;
}

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    // Load ballot status for the status tab by default
    loadBallotStatus();
});
</script>
@endsection
