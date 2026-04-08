    </main>

    <!-- Admin Footer -->
    <footer class="admin-footer">
        <div class="admin-footer-container">
            <p>&copy; 2026 Fixora Admin Panel. All rights reserved.</p>
            <p class="footer-version">v1.0</p>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        // Sidebar Toggle
        const sidebarToggle = document.getElementById('sidebarToggle');
        const adminSidebar = document.getElementById('adminSidebar');
        const profileToggle = document.getElementById('profileToggle');
        const profileMenu = document.getElementById('profileMenu');

        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', () => {
                adminSidebar.classList.toggle('active');
            });
        }

        if (profileToggle) {
            profileToggle.addEventListener('click', () => {
                profileMenu.classList.toggle('active');
            });
        }

        // Close profile menu when clicking outside
        document.addEventListener('click', (e) => {
            if (!e.target.closest('.admin-user-menu')) {
                profileMenu.classList.remove('active');
            }
        });

        // Close sidebar on mobile when a link is clicked
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth < 768) {
                    adminSidebar.classList.remove('active');
                }
            });
        });

        // Show confirmation before deleting
        function confirmAction(message = 'Are you sure?') {
            return confirm(message);
        }

        // Format number as currency
        function formatCurrency(amount) {
            return '₹' + parseFloat(amount).toLocaleString('en-IN', { minimumFractionDigits: 0 });
        }
    </script>
</body>
</html>
