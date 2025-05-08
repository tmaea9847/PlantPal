Unit Testing Overview

This project includes basic functional testing scripts that simulate user interactions and validate that the system components work as expected.

Files included:
- test_user_registration.php
- test_add_note.php
- test_save_reminder.php

How to Run:
1. Make sure your XAMPP server is running.
2. Place these files in the project folder under htdocs (e.g., project_plantpal/2_unit_testing).
3. Access each script via your browser:
   - http://localhost/project_plantpal/2_unit_testing/test_user_registration.php
   - http://localhost/project_plantpal/2_unit_testing/test_add_note.php
   - http://localhost/project_plantpal/2_unit_testing/test_save_reminder.php
4. Each script will print a success or failure message based on database execution.

Note:
These scripts use hardcoded user_id and plant_id values. Update these to match existing records in your database for accurate testing.
