function updateNotifications() {
    $.ajax({
        url: 'check_notifications.php',
        type: 'GET',
        success: function(data) {
            // Update the notifications count and display new notifications
            $('#notification-count').text(data.unread_count);
            $('#notifications').html(data.notifications_html);
        }
    });
}

// Check for new notifications every 5 seconds
setInterval(updateNotifications, 5000);
