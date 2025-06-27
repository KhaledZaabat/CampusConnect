
#### Project Name: CampusConnect
<img src="https://github.com/KhaledZaabat/CampusConnect/blob/main/assets/img/logo.png" alt="logo" width="300"/>

- ---
note: |
  ### Note :
  Before reading remember that to enter as admin use this :

  USERNAME : 7 

  Passwrod :  Khaled Zaabat

  as Student : 
  USERNAME : 777 
  Passwrod :  Khaled Zaabat

- ---
#### Description:
CampusConnect is a web-based system developed to help students living in university accommodations to interact with various services. The system provides access and a view of the most valued services, which include accommodation management, maintenance reporting, enrollment in activities, and access to documents. Admin will be able to operate and manage the system by viewing student data, news, and the status of services. The system will be in both English and Arabic to serve a diverse number of students.

#### Services Provided:
1. **Logging-in and Profile (Authentication)**: Login to accounts; the profile tells one the room number, name, and personal details. (Student / Admin / Super Admin)

2. **Canteen Schedule**: meal plans and schedule.

3. **Lost and Found**: Page of reporting or searching for items lost within the university residence (as posts + comments)

4. **Maintenance Service (مصلحة الصيانة)**: Students can report problems or issues related to maintenance in their rooms or residence. The report has many categories for proper cause identification + State of the report

5. **Accommodation Service (مصلحة الايواء)**: Using this service, students will be able to reserve rooms, perform room changes and know available rooms 

#### Admin Panel Features:
1. **Manage Admins**: Super Admins have the ability to create, read, update, and delete Admins on the platform.

2. **Manage Students**: Admins have the ability to create, read, update, and delete students on the platform. An admin can add new students, edit a profile, or remove students.

3. **Update canteen schedule**: An admin is able to update the schedule of the canteen.

4. **Manage News**: An admin can create news updates and delete them for display on the homepage so that students will be updated about the latest events and updates.

5. **Service Management**: The administrator can enable or edit the services offered, such as room reservation, activities, and maintenance categories.

#### Target Audience:
The platform is first and foremost designed for students who lived in university residences and their residence administrators.

* **Age Range**: From 18 to 30 years.
* **Gender**: Both male and female are targeted.
* **Geographical Location**: Mainly students.
* **Occupation**: Full-time university students.
- **Level of Education**: University undergraduate and postgraduate levels.
- **Income**: /.
- **Device Usage**: Desktop and mobile since the students will use both desktops and mobile phones as they multitask while on the move.

#### Project Goals:
- To provide students with an efficient, easy-to-use system to manage university accommodation needs.
- To enable students to report problems easily, sign up for extracurricular activities, and download important documents.
Ensure the administrator can handle all data of the students, university documents, and service availability.
Provide a user-friendly interface in Arabic and English.
 
---
 ### Sitemap:
 
1. **Home Page**
   - Navbar: Services | Profile | Logout
   - Available Services (links to specific services)
   - News section
   
2. **Login Page**

3. **Student Profile Page**
   - Room number, name etc.

4. **Lost Stuff Page**
   - Report lost items + found items

5. **canteen schedule**
   - Showcase the meal plans and updates.

6. **Services Section**
   - **مصلحة الصيانة**: 
     - Report issues (e.g., broken fixtures, heating problems)
     - Categories for types of problems
     - state of the report (pending / Done / declined)
   - **مصلحة الايواء**:
     - Book rooms for students
     - Change rooms with a filter option

7. **admin Panel**
- CRUD Students
- CRUD Users (Canteen user, صيانة user ...)
- Upload/Update Canteen Schedule
- CRUD News
- Accept/Decline Service

---

## Work Distribution

1. ### Frontend Development
#### Elhadi:
- **Login Page**
- **CRUD Student Page**: Create, Read, Update, Delete functionality for student records.
- **CRUD USERS Page**: Create, Read, Update, Delete functionality for admin users. (+ CRUD Users)
- **Canteen Schedule (Student)**: Display the canteen schedule for students.
- **Canteen Management (Admin)**: Admin page for managing canteen schedules and operations.


#### Kadouci:
- **Layout**: Design and implement the layout (Nav bar + About Us section).
- **Receiving Room Request**: Handle requests for room changes and bookings.
- **Lost & Found Page**: Manage lost and found items, including comments functionality.
- **news details page**

#### Cherif:
- **Student Home Page**: Display news and available services for students.
- **Admin Home Page**: Manage admin-related tasks.
- **About Dorms Page**: Information page about dormitories.
- **Report Issues Form**: Form for students to report issues.
- **Room Form**: Form for room-related requests.

### Khaled:
- **Student Profile Page**: Profile management for students.
- **News Page (Student)**: Display news relevant to students.
- **Managing News Page (Admin)**: Admin interface for managing news content.
- **Receiving Issues Page**: Handle issue states (Pending, Declined, Done).


---
