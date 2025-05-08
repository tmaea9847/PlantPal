function showSection(name) {
    const sections = ['home', 'search', 'library', 'care'];
    sections.forEach(id => {
        const el = document.getElementById(`section-${id}`);
        if (el) {
            el.style.display = (id === name) ? 'block' : 'none';
        }
    });

    if (name === 'library') loadMyLibrary();
    if (name === 'care') {
        loadCareNotes();
        loadCareCalendar();
        initializeCareCalendar();
    }
}

function loadMyLibrary() {
    fetch("ajax/fetch_library.php")
        .then(res => res.text())
        .then(html => {
            document.getElementById("my-library-results").innerHTML = html;
        })
        .catch(err => console.error("Library fetch error:", err));
}

function loadHomeWidgets() {
    fetch("ajax/home_stats.php")
        .then(res => res.json())
        .then(data => {
            document.getElementById("library-total").textContent = data.total_plants ?? 0;
            document.getElementById("library-latest").textContent = data.last_added ?? "None";

            const notesList = document.getElementById("recent-notes");
            notesList.innerHTML = "";
            (data.notes || []).forEach(note => {
                const li = document.createElement("li");
                li.textContent = note;
                notesList.appendChild(li);
            });
        })
        .catch(err => console.error("Widget load error:", err));
}

function loadCareNotes() {
    fetch("ajax/fetch_notes.php")
        .then(res => res.json())
        .then(notes => {
            const ul = document.getElementById("notes-list");
            ul.innerHTML = "";

            if (!notes || notes.length === 0) {
                ul.innerHTML = "<li>No notes yet.</li>";
            } else {
                notes.forEach(note => {
                    const li = document.createElement("li");
                    li.textContent = `${note.content} (${new Date(note.created_at).toLocaleDateString()})`;
                    ul.appendChild(li);
                });
            }
        })
        .catch(err => console.error("Notes fetch error:", err));
}

function loadCareCalendar() {
    // Will be handled via FullCalendar initialization
}

function initializeCareCalendar() {
    const calendarEl = document.getElementById('care-calendar');
    if (!calendarEl) return;

    calendarEl.innerHTML = ""; // Clear previous calendar if any

    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        selectable: true,
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth'
        },
        events: function (fetchInfo, successCallback, failureCallback) {
            fetch('ajax/get_reminders.php')
                .then(response => response.json())
                .then(data => {
                    const events = data.map(item => ({
                        title: item.task,
                        start: item.date
                    }));
                    successCallback(events);
                })
                .catch(error => {
                    console.error('Error fetching reminders:', error);
                    failureCallback(error);
                });
        },
        dateClick: function (info) {
            const task = prompt("Add a reminder for " + info.dateStr + ":");
            if (task) {
                fetch('ajax/save_reminder.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `date=${encodeURIComponent(info.dateStr)}&task=${encodeURIComponent(task)}`
                })
                .then(res => res.json())
                .then(response => {
                    if (response.success) {
                        calendar.refetchEvents();
                        alert("Reminder saved!");
                    } else {
                        alert("Failed to save reminder.");
                    }
                })
                .catch(err => {
                    console.error("Reminder save error:", err);
                });
            }
        }
    });

    calendar.render();
}

function addToLibrary(event, plantId) {
    event.preventDefault();
    fetch("ajax/add_to_library.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
        },
        body: "plant_id=" + encodeURIComponent(plantId),
    })
    .then(response => response.text())
    .then(data => alert(data))
    .catch(error => console.error("Add error:", error));
}

document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("search");
    const resultsDiv = document.getElementById("plant-results");

    if (searchInput && resultsDiv) {
        fetch("ajax/fetch_plants.php")
            .then(response => response.text())
            .then(data => resultsDiv.innerHTML = data);

        searchInput.addEventListener("keyup", function () {
            const query = searchInput.value;
            fetch("ajax/fetch_plants.php?q=" + encodeURIComponent(query))
                .then(response => response.text())
                .then(data => resultsDiv.innerHTML = data)
                .catch(error => {
                    resultsDiv.innerHTML = "Error fetching results.";
                    console.error("Fetch error:", error);
                });
        });
    }

    loadMyLibrary();
    loadHomeWidgets();

    const noteForm = document.getElementById("note-form");
    if (noteForm) {
        noteForm.addEventListener("submit", function (e) {
            e.preventDefault();
            const noteContent = document.getElementById("note-content").value.trim();
            if (!noteContent) {
                alert("Note cannot be empty.");
                return;
            }

            fetch("ajax/add_note.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                },
                body: "note=" + encodeURIComponent(noteContent),
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    document.getElementById("note-content").value = '';
                    loadCareNotes();
                    loadHomeWidgets();
                } else {
                    alert(data.error || "Something went wrong.");
                }
            });
        });
    }
});
