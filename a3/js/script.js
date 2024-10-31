$(document).ready(function() {
    $('#petType').on('change', function() {
        var selectedType = $(this).val();
        
        $('.gallery-item').each(function() {
            var petType = $(this).data('type');
            
            // Show all pets if 'all' is selected, otherwise filter by type
            if (selectedType === 'all' || petType === selectedType) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });
});

function logout() {
    // Send an AJAX GET request to call the logout function in functions.php
    fetch('logout.php?action=logout')
        .then(response => response.json())
        .then(data => {
            if (data.status === 'logged_out') {
                location.reload(); // Reload page after logging out
            } else {
                console.error('Logout failed');
            }
        })
        .catch(error => console.error('Error:', error));
}

$(document).ready(function() {
    // Handle change event for pet type dropdown
    $('#petType').change(function() {
        var selectedType = $(this).val(); // Get selected value

        // Show all pets if "all" is selected
        if (selectedType === 'all') {
            $('.gallery-item').show();
        } else {
            // Hide all pets and show only the selected type
            $('.gallery-item').hide();
            $('.gallery-item[data-type="' + selectedType.toLowerCase() + '"]').show();
        }
    });
});


