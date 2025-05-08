
# PlantPal

PlantPal is a PHP/MySQL-powered web application designed to help users manage their houseplants. Users can browse plant data, add plants to their personal library, take notes, and manage reminders using a calendar interface.

## Features

- User authentication and session management
- Browse a curated list of houseplants with search functionality
- Add plants to a personal library
- View care tips (light, watering, soil, propagation)
- Save personal plant care notes
- Display total plants and recent additions on dashboard
- View and manage upcoming care reminders
- FullCalendar integration to visualize reminders

## Installation

1. Clone or download this repository
2. Place the files inside your `htdocs` folder in XAMPP or your web root
3. Create a MySQL database (e.g., `plantpal`)
4. Import the provided `plantpal.sql` schema file (if available)
5. Edit the `includes/db_connect.php` file with your database credentials

## Folder Structure

```
project_plantpal/
│
├── ajax/
│   ├── add_note.php
│   ├── add_to_library.php
│   ├── fetch_library.php
│   ├── fetch_notes.php
│   ├── fetch_plants.php
│   └── home_stats.php
│
├── css/
│   └── styles.css
│
├── images/
│   └── (plant images here)
│
├── includes/
│   ├── db_connect.php
│   └── session.php
│
├── js/
│   └── scripts.js
│
├── dashboard.php
├── login.php
├── register.php
├── logout.php
├── save_reminder.php
└── README.md
```

## Future Improvements

- Allow user-uploaded plant images
- Associate notes with specific plants
- Advanced reminder scheduling options (repeating, tagging, etc.)
- Friend sharing or community features
- Better visual UI/UX and mobile responsiveness
- Allow filtering and sorting in library
- Support for plant customization (nickname, acquired date, etc.)
- Dark/light theme toggle

## Technologies Used

- PHP 8
- MySQL
- HTML5, CSS3, JavaScript
- FullCalendar JS (calendar interface)
- XAMPP (development server)

## License

This project is intended for educational use only.
