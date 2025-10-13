# Advanced Programming Capstone Project

![Laravel](https://img.shields.io/badge/Laravel-12.x-red)
![PHP](https://img.shields.io/badge/PHP-8.3-blue)

This is a **Laravel 12.x** based **Projects Management System** built for the AP Capstone use case.  
The system manages **Programs, Projects, Facilities, Services, Equipment, Participants, and Outcomes**, implementing all required relationships and CRUD operations. 
This project follows the **Model-View-Controller (MVC)** design pattern. 
The **Models** define the data structure and relationships, ensuring the system can manage entities like Programs, Projects, and Facilities effectively.
The **Views** are implemented using Blade templates, styled with Bootstrap and AdminLTE, providing a responsive and user-friendly interface.
The **Controllers** handle the business logic, acting as the bridge between the models and views to process user requests and deliver the appropriate responses.


---

## Features

### Programs
- Create, view, edit, delete programs.
- Each **Program** has multiple **Projects**.
- View projects under a particular program.

### Facilities
- Manage facilities (create, edit, delete).
- Each **Facility** has **Projects, Services, and Equipment**.
- Facility details page lists all related entities.

### Services
- Scoped under **Facilities**.
- Manage services offered by a facility.

### Equipment
- Scoped under **Facilities**.
- Manage available equipment.
- Search/filter equipment by capability.

### Projects
- Belongs to **Program** and **Facility**.
- Manage CRUD operations for projects.
- Assign participants and outcomes.
- List projects under programs and facilities.

### Participants
- Manage participants.
- Assign/remove participants from projects.

### Outcomes
- Attach outcomes to a project.
- Manage project outcome details.
- Link/upload outcome artifacts.

---

## Tech Stack

- **Backend:** Laravel 12.x (PHP 8.3)
- **Frontend:** Blade Templates + Bootstrap + AdminLTE
- **Data Storage:** JSON (Fake repositories in `app/Data`)
- **Build Tool:** Vite (for assets)

---

## Project Structure

<img src="assets/structure.png" alt="Projcet Structure" width="200"/>

## ⚙️ Setup & Installation

1. **Clone the repository**
   ```bash
   https://github.com/Ggayi-Edward/PROJECTS-MANAGEMENT-SYSTEM.git
   cd projects-management-system

2. **Install dependencies**
   ```bash
   composer install
   npm install

3. **Run development server**
   ```bash
   php artisan serve

4. **Run frontend build**
   ```bash
   npm run dev
   
5. **Open browser at:**
   ```cpp
   http://127.0.0.1:8000
