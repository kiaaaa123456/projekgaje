let documents_url = $('#documents_url').val();
function updateTypesBySearch() {
    $("#page").val(1);
    updateUserDocument();
}

function updateUserDocument() {
    let params = "";
    let current_url = "";
    let from = __date_range['from'];
    let to = __date_range['to'];
    let page = $("#page").val();

    // Append parameters conditionally
    if ($('#entries').val()) {
        params += 'entries=' + $('#entries').val() + '&';
    }
    if ($('#search').val()) {
        params += 'search=' + $('#search').val() + '&';
    }
    if (from) {
        params += 'from=' + from + '&';
    }
    if (to) {
        params += 'to=' + to + '&';
    }
    params += 'page=' + page + '&';

    // Remove the trailing '&' if it exists
    params = params.slice(0, -1);

    // Append the query string to the base URL
    current_url = `${documents_url}?${params}`;

    updateTbody(current_url);
}

function updateTbody(current_url) {
    $.ajax({
        url: current_url,
        method: 'GET',
        success: function(data) {
            $('._ajaxData').empty().html(data.view);
        },
        error: function(error) {
            console.error(error);
        }
    });
}

updateUserDocument();

function ModulePagination(page) {
    $('#page').val(page);
    updateUserDocument();
}