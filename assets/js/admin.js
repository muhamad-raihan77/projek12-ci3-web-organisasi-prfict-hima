/* =====================================================
   PR FICT Admin JS - Responsive Mobile Navigation
   ===================================================== */
document.addEventListener('DOMContentLoaded', function() {
    // Delete Confirmation
    const deleteBtns = document.querySelectorAll('.btn-delete-confirm');
    deleteBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            if (!confirm('Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.')) {
                e.preventDefault();
            }
        });
    });

    // Mobile Sidebar Toggle
    const mobileToggleBtn = document.querySelector('.mobile-toggle-btn');
    const adminSidebar = document.querySelector('.admin-sidebar');
    
    // Create overlay element if not present
    let sidebarOverlay = document.querySelector('.sidebar-overlay');
    if (!sidebarOverlay) {
        sidebarOverlay = document.createElement('div');
        sidebarOverlay.className = 'sidebar-overlay';
        document.body.appendChild(sidebarOverlay);
    }

    if (mobileToggleBtn && adminSidebar) {
        mobileToggleBtn.addEventListener('click', function() {
            adminSidebar.classList.toggle('open');
            sidebarOverlay.classList.toggle('active');
        });

        sidebarOverlay.addEventListener('click', function() {
            adminSidebar.classList.remove('open');
            sidebarOverlay.classList.remove('active');
        });
    }

    // Admin Edit Member Modal handlers
    const editOrgBtns = document.querySelectorAll('.btn-edit-org');
    const editOrgModal = document.getElementById('editOrgModal');
    const editOrgForm = document.getElementById('editOrgForm');
    
    if (editOrgBtns.length > 0 && editOrgModal && editOrgForm) {
        editOrgBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');
                const position = this.getAttribute('data-position');
                const division = this.getAttribute('data-division');
                const motto = this.getAttribute('data-motto');
                const description = this.getAttribute('data-description');
                const instagram = this.getAttribute('data-instagram');
                const linkedin = this.getAttribute('data-linkedin');
                const order = this.getAttribute('data-order');

                // Populate form fields
                document.getElementById('editOrgName').value = name;
                document.getElementById('editOrgPosition').value = position;
                document.getElementById('editOrgDivision').value = division;
                document.getElementById('editOrgMotto').value = motto;
                document.getElementById('editOrgDescription').value = description;
                document.getElementById('editOrgInstagram').value = instagram;
                document.getElementById('editOrgLinkedin').value = linkedin;
                document.getElementById('editOrgOrder').value = order;

                // Update form action URL dynamically
                editOrgForm.action = `${BASE_URL}admin/organisasi/edit/${id}`;

                // Show modal
                editOrgModal.classList.add('active');
            });
        });
    }

    window.closeEditOrgModal = function() {
        if (editOrgModal) {
            editOrgModal.classList.remove('active');
        }
    };
});

