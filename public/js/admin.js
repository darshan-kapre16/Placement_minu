/**
 * Admin Panel JavaScript
 * placement_m/public/js/admin.js
 */

document.addEventListener('DOMContentLoaded', function () {

    // --- Sidebar Toggle (Mobile) ---
    const toggle  = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('adminSidebar');

    if (toggle && sidebar) {
        // Create overlay
        let overlay = document.getElementById('sidebarOverlay');
        if (!overlay) {
            overlay = document.createElement('div');
            overlay.id = 'sidebarOverlay';
            overlay.className = 'sidebar-overlay';
            document.body.appendChild(overlay);
        }

        toggle.addEventListener('click', function () {
            sidebar.classList.toggle('show');
            overlay.classList.toggle('show');
        });

        overlay.addEventListener('click', function () {
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
        });
    }

    // --- Auto-dismiss alerts after 4 seconds ---
    document.querySelectorAll('.alert-dismissible').forEach(function (alert) {
        setTimeout(function () {
            const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
            if (bsAlert) bsAlert.close();
        }, 4000);
    });

    // --- Confirm on dangerous buttons ---
    document.querySelectorAll('[data-confirm]').forEach(function (el) {
        el.addEventListener('click', function (e) {
            if (!confirm(el.dataset.confirm)) {
                e.preventDefault();
            }
        });
    });

    // --- Active sidebar link highlight based on URL ---
    const currentUrl = window.location.href;
    document.querySelectorAll('.sidebar-menu a').forEach(function (link) {
        if (link.href === currentUrl) {
            link.closest('li').classList.add('active');
        }
    });
});
