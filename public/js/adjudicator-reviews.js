/**
 * Adjudicator Reviews - Dynamic Panelist Loading
 * Fixes the bug where panelist dropdown doesn't load when round is selected
 */

document.addEventListener('DOMContentLoaded', function() {
    const roundSelect = document.getElementById('round_select');
    const panelistSelect = document.getElementById('panelist_select');
    const loadingIndicator = document.getElementById('loading_panelist');
    
    if (!roundSelect || !panelistSelect) {
        console.warn('Review form elements not found on this page');
        return;
    }
    
    // Event listener for round selection change
    roundSelect.addEventListener('change', function() {
        const roundId = this.value;
        
        if (!roundId) {
            resetPanelistDropdown();
            return;
        }
        
        loadAdjudicatorsByRound(roundId);
    });
    
    /**
     * Load adjudicators allocated to the selected round
     */
    function loadAdjudicatorsByRound(roundId) {
        // Show loading state
        showLoading();
        
        // API endpoint - ensure this matches your routes
        const apiUrl = `/api/rounds/${roundId}/adjudicators`;
        
        fetch(apiUrl, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            credentials: 'same-origin'
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.success && data.adjudicators) {
                populatePanelistDropdown(data.adjudicators);
            } else {
                throw new Error('Invalid response format');
            }
        })
        .catch(error => {
            console.error('Error loading adjudicators:', error);
            showError('Failed to load adjudicators. Please try again.');
        })
        .finally(() => {
            hideLoading();
        });
    }
    
    /**
     * Populate panelist dropdown with adjudicator data
     */
    function populatePanelistDropdown(adjudicators) {
        // Clear existing options
        panelistSelect.innerHTML = '<option value="">Select Panelist</option>';
        
        if (adjudicators.length === 0) {
            panelistSelect.innerHTML += '<option value="" disabled>No adjudicators allocated to this round</option>';
            panelistSelect.disabled = true;
            return;
        }
        
        // Add adjudicator options
        adjudicators.forEach(adj => {
            const option = document.createElement('option');
            option.value = adj.id;
            option.textContent = `${adj.name}${adj.institution ? ' - ' + adj.institution : ''}${adj.rating ? ' (Rating: ' + adj.rating + ')' : ''}`;
            panelistSelect.appendChild(option);
        });
        
        panelistSelect.disabled = false;
    }
    
    /**
     * Reset panelist dropdown to default state
     */
    function resetPanelistDropdown() {
        panelistSelect.innerHTML = '<option value="">Select a round first</option>';
        panelistSelect.disabled = true;
    }
    
    /**
     * Show loading indicator
     */
    function showLoading() {
        if (loadingIndicator) {
            loadingIndicator.classList.remove('hidden');
        }
        panelistSelect.disabled = true;
        panelistSelect.innerHTML = '<option value="">Loading...</option>';
    }
    
    /**
     * Hide loading indicator
     */
    function hideLoading() {
        if (loadingIndicator) {
            loadingIndicator.classList.add('hidden');
        }
    }
    
    /**
     * Show error message to user
     */
    function showError(message) {
        // Create error alert if doesn't exist
        let errorAlert = document.getElementById('review_error_alert');
        
        if (!errorAlert) {
            errorAlert = document.createElement('div');
            errorAlert.id = 'review_error_alert';
            errorAlert.className = 'mb-4 rounded-lg bg-red-50 p-4 text-red-800 border border-red-200';
            roundSelect.parentNode.insertBefore(errorAlert, roundSelect);
        }
        
        errorAlert.innerHTML = `
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>${message}</span>
            </div>
        `;
        
        // Auto-hide after 5 seconds
        setTimeout(() => {
            if (errorAlert) {
                errorAlert.remove();
            }
        }, 5000);
    }
});
