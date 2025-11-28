$(function() {
    function handleImport(formId, url, resultId) {
        $(formId).on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {
                    let html = '<div class="alert alert-success">Imported: ' + (res.created || 0) + '</div>';
                    if (res.errors && res.errors.length) {
                        html += '<div class="alert alert-warning">Errors:<ul>';
                        res.errors.forEach(function(err) { html += '<li>' + err + '</li>'; });
                        html += '</ul></div>';
                    }
                    $(resultId).html(html);
                },
                error: function(xhr) {
                    $(resultId).html('<div class="alert alert-danger">' + (xhr.responseJSON?.error || 'Import failed') + '</div>');
                }
            });
        });
    }
    handleImport('#import-teams-form', '/api/import/teams', '#import-teams-result');
    handleImport('#import-adjudicators-form', '/api/import/adjudicators', '#import-adjudicators-result');
    handleImport('#import-rooms-form', '/api/import/rooms', '#import-rooms-result');
});
