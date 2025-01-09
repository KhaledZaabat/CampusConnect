document.addEventListener("DOMContentLoaded", function() {
    const navItems = document.querySelectorAll("#nav-item");
    const servicesDropdown= document.querySelector("#nav-drop");
    navItems.forEach(nav => nav.classList.remove("active"));

    const activeNavIndex = sessionStorage.getItem("activeNav");
    
    if (activeNavIndex) {
        navItems[activeNavIndex].classList.add("active");
    }
    if(servicesDropdown){
        servicesDropdown.addEventListener('click', () => {
            navItems.forEach(nav => nav.classList.remove("active"));
            sessionStorage.removeItem("activeNav");
        });
    }

    navItems.forEach((item, index) => {
        item.addEventListener("click", function() {
            navItems.forEach(nav => nav.classList.remove("active"));

            item.classList.add("active");

            sessionStorage.setItem("activeNav", index);
        });
    });

});
