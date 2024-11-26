// Profile data array
const profileData = {
    profilePicture: "assets/img/test.jpg",
    firstName: "John",
    lastName: "Doe",
    studentID: "123456",
    email: "johndoe@email.com",
    phoneNumber: "+1234567890",
    roomNumber: "101A"
};

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
