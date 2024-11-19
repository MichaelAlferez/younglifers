// Get modal and close elements for add ministry
var modal = document.getElementById('modal');
var closeBtns = document.querySelectorAll('.close'); // Select all close buttons
var okBtn = modal.querySelector('.modal-button'); // The OK button within the modal

// PHP variable to trigger modal
var modalStatus = "<?php echo $modal_status ? 'true' : 'false'; ?>";

// Show modal if triggered by PHP
if (modalStatus === 'true') {
    modal.style.display = 'block';
}

// Close modal on click of any close button or OK button
closeBtns.forEach(btn => {
    btn.onclick = function() {
        modal.style.display = 'none';
        deleteModal.style.display = 'none'; // Ensure delete modal also closes
    };
});

okBtn.onclick = function() {
    modal.style.display = 'none';
}

// Close modal if user clicks outside of the modal
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = 'none';
    }
    if (event.target == deleteModal) {
        deleteModal.style.display = 'none';
    }
}

// Delete confirmation modal
var deleteModal = document.getElementById('delete-modal');
var deleteButtons = document.querySelectorAll('.delete-button');
var deleteForm = document.getElementById('delete-form');
var ministryIdInput = document.getElementById('ministry-id');

// Attach click event to all delete buttons
deleteButtons.forEach(button => {
    button.onclick = function() {
        var ministryId = button.getAttribute('data-id');
        ministryIdInput.value = ministryId; // Set the ministry ID in the form
        deleteModal.style.display = 'block'; // Show the modal
    }
});

// Close delete modal when clicking on the close button or outside the modal
closeBtns.forEach(btn => {
    btn.onclick = function() {
        deleteModal.style.display = 'none';
    };
});

// Attach click event to cancel button
var cancelBtn = document.querySelector('.modal-button.cancel');
cancelBtn.onclick = function() {
    deleteModal.style.display = 'none'; // Close delete modal
}

