<?php
include 'includes/session.php';
include 'includes/db_connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - PlantPal</title>
    <link rel="stylesheet" href="css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    <script src="js/scripts.js" defer></script>
</head>
<body>

<!-- Top Navigation Bar -->
<header class="topbar">
    <div class="logo">PlantPal</div>
    <div class="nav-links">
        <ul class="topnav">
            <li><a href="#" onclick="showSection('search')">Search</a></li>
            <li><a href="#" onclick="showSection('library')">My Library</a></li>
            <li><a href="#" onclick="showSection('care')">My Care</a></li>
            <li><a href="#" onclick="showSection('home')">Home</a></li>
            <li><a href="logout.php">🚪 Logout</a></li>
        </ul>
    </div>
</header>

<!-- Main Content -->
<main class="main-content">

    <!-- Search Section -->
    <div id="section-search" style="display: none;">
        <h3>Search for New Plant Friends</h3>
        <div class="search-bar">
            <input type="text" id="search" placeholder="Search for a plant...">
            <button type="button" disabled title="Search updates live 🔍">🔍</button>
        </div>
        <div id="plant-results"></div>
    </div>

    <!-- Library Section -->
    <div id="section-library" style="display:none;">
        <h3>My Plant Library</h3>
        <div id="my-library-results"></div>
    </div>

    <!-- My Care Section -->
    <div id="section-care" style="display:none;">
        <h3>My Care</h3>

        <!-- Add New Note -->
        <form id="note-form">
            <label for="note-content"><strong>Add a New Note:</strong></label><br>
            <textarea id="note-content" name="note" rows="4" cols="50" placeholder="E.g., Fertilized aloe today..."></textarea><br>
            <button type="submit">Save Note</button>
        </form>

        <!-- Notes List -->
        <div id="user-notes">
            <h4>My Notes</h4>
            <ul id="notes-list">Loading notes...</ul>
        </div>

        <!-- Interactive Calendar -->
        <div class="care-calendar-section">
            <h4>My Reminders</h4>
            <div id="care-calendar" style="margin-top: 1rem;"></div>
        </div>
    </div>

    <!-- Home Section -->
    <div id="section-home">
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>

        <div class="dashboard-widgets">

            <!-- Plant Stats -->
            <div class="widget">
                <h3>My Plant Library</h3>
                <p>Total Plants: <span id="library-total">Loading...</span></p>
                <p>Newest Addition: <span id="library-latest">Loading...</span></p>
            </div>

            <!-- Notes Preview -->
            <div class="widget">
                <h3>Recent Notes</h3>
                <ul id="recent-notes">Loading...</ul>
            </div>

        </div>
    </div>

</main>

</body>
</html>
