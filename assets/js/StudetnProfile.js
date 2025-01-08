// JavaScript for interactivity or live profile updates
document.addEventListener("DOMContentLoaded", () => {
    // Example: Add a button to dynamically toggle between light and dark themes
    const themeButton = document.getElementById("themeToggle");
    themeButton.addEventListener("click", () => {
        const htmlElement = document.documentElement;
        const currentTheme = htmlElement.getAttribute("data-bs-theme");
        htmlElement.setAttribute("data-bs-theme", currentTheme === "light" ? "dark" : "light");
    });
});

// Populate profile data
document.addEventListener("DOMContentLoaded", () => {
    document.getElementById("profilePicture").src = profileData.profilePicture;
    document.getElementById("inputFirstName").value = profileData.firstName;
    document.getElementById("inputLastName").value = profileData.lastName;
    document.getElementById("inputStudentID").value = profileData.studentID;
    document.getElementById("inputEmail").value = profileData.email;
    document.getElementById("inputPhone").value = profileData.phoneNumber;
    document.getElementById("inputRoomNumber").value = profileData.roomNumber;
});
