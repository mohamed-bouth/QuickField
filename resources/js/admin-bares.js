    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const closeSidebarBtn = document.getElementById('closeSidebarBtn');
        if (!sidebar || !overlay || !mobileMenuBtn) {
            console.log("Mochkil: Chi ID na9es f HTML (sidebar, sidebarOverlay wla mobileMenuBtn)");
            return;
        }

        function openSidebar() {
            sidebar.classList.remove('-translate-x-full');
            sidebar.classList.add('translate-x-0');
            overlay.classList.remove('hidden');
            document.body.style.overflow = 'hidden'; 
        }

        function closeSidebar() {
            sidebar.classList.add('-translate-x-full');
            sidebar.classList.remove('translate-x-0');
            overlay.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        mobileMenuBtn.addEventListener('click', openSidebar);
        overlay.addEventListener('click', closeSidebar);
        if(closeSidebarBtn) {
            closeSidebarBtn.addEventListener('click', closeSidebar);
        }

        const dropdownBtn = document.getElementById('profileDropdownBtn');
        const dropdownMenu = document.getElementById('profileDropdownMenu');
        const chevron = document.getElementById('profileChevron');

        if(dropdownBtn && dropdownMenu) {
            dropdownBtn.addEventListener('click', function(event) {
                event.stopPropagation(); 
                dropdownMenu.classList.toggle('hidden');
                if(chevron) chevron.classList.toggle('rotate-180');
            });

            document.addEventListener('click', function(event) {
                if (!dropdownBtn.contains(event.target) && !dropdownMenu.contains(event.target)) {
                    dropdownMenu.classList.add('hidden');
                    if(chevron) chevron.classList.remove('rotate-180');
                }
            });
        }
    });