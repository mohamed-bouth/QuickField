
    document.addEventListener('DOMContentLoaded', function() {

        const profileBtn = document.getElementById('publicProfileBtn');
        const profileMenu = document.getElementById('publicProfileMenu');
        const profileChevron = document.getElementById('publicProfileChevron');

        if(profileBtn && profileMenu) {
            profileBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                profileMenu.classList.toggle('hidden');
                profileChevron.classList.toggle('rotate-180');
            });

            document.addEventListener('click', function(e) {
                if (!profileBtn.contains(e.target) && !profileMenu.contains(e.target)) {
                    profileMenu.classList.add('hidden');
                    profileChevron.classList.remove('rotate-180');
                }
            });
        }

        const mobileToggleBtn = document.getElementById('mobileNavToggle');
        const mobileNavMenu = document.getElementById('mobileNavMenu');
        const hamburgerIcon = document.getElementById('hamburgerIcon');
        const closeIcon = document.getElementById('closeIcon');

        if(mobileToggleBtn && mobileNavMenu) {
            mobileToggleBtn.addEventListener('click', function() {
                mobileNavMenu.classList.toggle('hidden');

                hamburgerIcon.classList.toggle('hidden');
                closeIcon.classList.toggle('hidden');
            });
        }
    });
