$(document).ready(function() {
    $('#logout').click(function() {
        $.ajax({
            url: '../../server/auth/logout.php',
            type: 'GET',
            success: function(response) {
                window.location.href = '/';
            },
            error: function() {
                alert('There was an error logging out');
            }
        });
    });
});