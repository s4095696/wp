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

$(document).ready(function() {
    // Save selected pet to session storage on click
    $('.pet-link').on('click', function() {
        var petId = $(this).data('petid');
        var selectedPets = JSON.parse(sessionStorage.getItem('selectedPets')) || [];

        // Prevent duplicates
        if (!selectedPets.includes(petId)) {
            selectedPets.push(petId);
            sessionStorage.setItem('selectedPets', JSON.stringify(selectedPets));
        }
    });

    // Existing pet type filtering code
    $('#petType').on('change', function() {
        var selectedType = $(this).val();
        
        $('.gallery-item').each(function() {
            var petType = $(this).data('type');
            if (selectedType === 'all' || petType === selectedType) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });
});

