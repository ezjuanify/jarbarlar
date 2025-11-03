document.addEventListener('DOMContentLoaded', function() {
    // Function to fetch the connection status from the server
    function updateStatus() {
        fetch(ajax_object.ajax_url, {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({
                action: 'get_connected_status'
            })
        })
        .then(response => response.json())
        .then(data => {
            const statusIndicator = document.getElementById('speedy-status-indicator');
            if (data.success && data.data.connected) {
                statusIndicator.innerHTML = '<span style="color: green;">●</span> Connected';
            } else {
                statusIndicator.innerHTML = '<span style="color: red;">●</span> Disconnected';
            }
        })
        .catch(error => console.error('Error fetching status:', error));
    }

    // Call the updateStatus function immediately
    // updateStatus();

    // Optionally, you can set an interval to periodically update the status
   
});
