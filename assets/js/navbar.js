document.addEventListener("DOMContentLoaded", function() {
    // Get all the nav items
    const navItems = document.querySelectorAll(".nav-item","dropdown-toggle");
    navItems.forEach(nav => nav.classList.remove("active"));

    // load the active nav item from LocalStorage
    const activeNavIndex = localStorage.getItem("activeNav");
    if (activeNavIndex !== null) {
        navItems[activeNavIndex].classList.add("active");
    }

    navItems.forEach((item, index) => {
        item.addEventListener("click", function() {
            navItems.forEach(nav => nav.classList.remove("active"));
            item.classList.add("active");

            // save the index of the clicked nav item to LocalStorage
            localStorage.setItem("activeNav", index);
        });
    });
});
