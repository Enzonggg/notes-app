<!DOCTYPE html>
<html lang="en" ng-app="notesApp">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notes App - Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background: #f5f6fa;
        }
        .dashboard-container {
            display: flex;
            height: 100vh;
        }
        /* Sidebar Navigation */
        .sidebar {
            width: 250px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px 0;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            display: flex;
            flex-direction: column;
        }
        .sidebar-header {
            padding: 0 20px 20px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.2);
            margin-bottom: 20px;
        }
        .sidebar-header h2 {
            font-size: 24px;
            margin-bottom: 5px;
        }
        .sidebar-header .username {
            font-size: 14px;
            opacity: 0.8;
        }
        .nav-menu {
            list-style: none;
            display: flex;
            flex-direction: column;
            flex: 1;
        }
        .nav-item {
            padding: 15px 20px;
            cursor: pointer;
            transition: background 0.3s;
            display: flex;
            align-items: center;
        }
        .nav-item:hover {
            background: rgba(255,255,255,0.1);
        }
        .nav-item.active {
            background: rgba(255,255,255,0.2);
            border-left: 4px solid white;
        }
        .nav-item i {
            margin-right: 10px;
            font-size: 18px;
        }
        .logout-item {
            margin-top: auto;
            border-top: 1px solid rgba(255,255,255,0.2);
        }
        .logout-item:hover {
            background: rgba(255,0,0,0.2);
        }
        /* Main Content Area */
        .main-content {
            flex: 1;
            padding: 30px;
            overflow-y: auto;
        }
        .content-header {
            margin-bottom: 30px;
        }
        .content-header h1 {
            font-size: 32px;
            color: #333;
            margin-bottom: 5px;
        }
        .content-header p {
            color: #666;
            font-size: 14px;
        }
        /* Home Page */
        .welcome-card {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        .welcome-card h2 {
            font-size: 28px;
            color: #667eea;
            margin-bottom: 20px;
        }
        .welcome-card p {
            color: #666;
            font-size: 16px;
            line-height: 1.6;
        }
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }
        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        .stat-card h3 {
            font-size: 36px;
            color: #667eea;
            margin-bottom: 10px;
        }
        .stat-card p {
            color: #666;
            font-size: 14px;
        }
        /* Notes List Page */
        .notes-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        .note-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .note-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
        }
        .note-card h3 {
            color: #333;
            margin-bottom: 10px;
            font-size: 18px;
        }
        .note-card p {
            color: #666;
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 15px;
        }
        .note-card .note-date {
            font-size: 12px;
            color: #999;
            margin-bottom: 15px;
        }
        .note-actions {
            display: flex;
            gap: 10px;
        }
        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            transition: background 0.3s;
        }
        .btn-edit {
            background: #667eea;
            color: white;
        }
        .btn-edit:hover {
            background: #5568d3;
        }
        .btn-delete {
            background: #e74c3c;
            color: white;
        }
        .btn-delete:hover {
            background: #c0392b;
        }
        .btn-primary {
            background: #667eea;
            color: white;
            padding: 12px 24px;
            font-size: 16px;
        }
        .btn-primary:hover {
            background: #5568d3;
        }
        /* Add/Edit Note Form */
        .form-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            max-width: 800px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: bold;
        }
        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            font-family: Arial, sans-serif;
        }
        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #667eea;
        }
        .form-group textarea {
            min-height: 200px;
            resize: vertical;
        }
        .form-actions {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }
        .btn-cancel {
            background: #95a5a6;
            color: white;
            padding: 12px 24px;
            font-size: 16px;
        }
        .btn-cancel:hover {
            background: #7f8c8d;
        }
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #999;
        }
        .empty-state h3 {
            font-size: 24px;
            margin-bottom: 10px;
        }
        /* Toast Notification */
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
        }
        .toast {
            background: white;
            min-width: 300px;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.2);
            margin-bottom: 10px;
            position: relative;
            overflow: hidden;
            transform: translateX(400px);
            opacity: 0;
            transition: all 0.3s ease-in-out;
        }
        .toast.show {
            transform: translateX(0);
            opacity: 1;
            animation: slideInRight 0.4s ease-out;
        }
        .toast.hide {
            transform: translateX(400px);
            opacity: 0;
            animation: slideOutRight 0.3s ease-in;
        }
        .toast-header {
            display: flex;
            align-items: center;
            margin-bottom: 8px;
        }
        .toast-icon {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            font-weight: bold;
            font-size: 16px;
        }
        .toast-icon.success {
            background: #28a745;
            color: white;
        }
        .toast-icon.error {
            background: #e74c3c;
            color: white;
        }
        .toast-title {
            font-weight: bold;
            color: #333;
            font-size: 16px;
        }
        .toast-close {
            margin-left: auto;
            background: none;
            border: none;
            font-size: 20px;
            color: #999;
            cursor: pointer;
            padding: 0;
            width: 20px;
            height: 20px;
        }
        .toast-close:hover {
            color: #333;
        }
        .toast-message {
            color: #666;
            font-size: 14px;
            margin-left: 34px;
        }
        .toast-progress {
            position: absolute;
            bottom: 0;
            left: 0;
            height: 4px;
            width: 100%;
            animation: progressBar 3s linear forwards;
        }
        .toast-progress.success {
            background: #28a745;
        }
        .toast-progress.error {
            background: #e74c3c;
        }
        @keyframes slideInRight {
            from {
                transform: translateX(400px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        @keyframes slideOutRight {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(400px);
                opacity: 0;
            }
        }
        @keyframes progressBar {
            from {
                width: 100%;
            }
            to {
                width: 0%;
            }
        }
        /* Responsive Design */
        @media (max-width: 1024px) {
            .stats-container {
                grid-template-columns: repeat(2, 1fr);
            }
            .notes-grid {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            }
        }
        @media (max-width: 768px) {
            .dashboard-container {
                flex-direction: column;
            }
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
                padding: 15px 0;
            }
            .sidebar-header {
                padding: 10px 20px;
                margin-bottom: 10px;
            }
            .sidebar-header h2 {
                font-size: 20px;
            }
            .nav-menu {
                display: flex;
                flex-direction: row;
                flex-wrap: wrap;
                justify-content: space-around;
            }
            .nav-item {
                flex: 1;
                min-width: 120px;
                padding: 10px 15px;
                text-align: center;
                font-size: 14px;
            }
            .nav-item.active {
                border-left: none;
                border-bottom: 3px solid white;
            }
            .logout-item {
                margin-top: 0;
                border-top: none;
                border-left: 1px solid rgba(255,255,255,0.2);
            }
            .main-content {
                padding: 20px 15px;
            }
            .content-header h1 {
                font-size: 24px;
            }
            .stats-container {
                grid-template-columns: 1fr;
            }
            .notes-grid {
                grid-template-columns: 1fr;
            }
            .form-container {
                padding: 20px;
            }
        }
        @media (max-width: 480px) {
            .sidebar-header h2 {
                font-size: 18px;
            }
            .nav-item {
                padding: 8px 10px;
                font-size: 12px;
                min-width: 80px;
            }
            .content-header h1 {
                font-size: 20px;
            }
            .welcome-card {
                padding: 25px;
            }
            .welcome-card h2 {
                font-size: 22px;
            }
            .stat-card h3 {
                font-size: 28px;
            }
            .note-card {
                padding: 15px;
            }
            .form-group input,
            .form-group textarea {
                font-size: 16px; /* Prevents zoom on iOS */
            }
            .btn {
                padding: 10px 14px;
                font-size: 13px;
            }
            .btn-primary,
            .btn-cancel {
                padding: 10px 20px;
                font-size: 14px;
            }
            .toast {
                min-width: 280px;
                right: 10px;
            }
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular.min.js"></script>
</head>
<body ng-controller="DashboardController">
    <!-- Toast Notification Container -->
    <div class="toast-container" id="toastContainer"></div>

    <div class="dashboard-container">
        <!-- Left Sidebar Navigation -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2>📝 Notes App</h2>
                <div class="username">Welcome, <?= session()->get('username') ?? 'User' ?></div>
            </div>
            <ul class="nav-menu">
                <li class="nav-item" ng-class="{active: currentPage === 'home'}" ng-click="changePage('home')">
                    <span>🏠</span> Home
                </li>
                <li class="nav-item" ng-class="{active: currentPage === 'notes'}" ng-click="changePage('notes')">
                    <span>📋</span> Notes List
                </li>
                <li class="nav-item" ng-class="{active: currentPage === 'add'}" ng-click="changePage('add')">
                    <span>➕</span> Add Note
                </li>
                <li class="nav-item logout-item" ng-click="logout()">
                    <span>🚪</span> Logout
                </li>
            </ul>
        </aside>

        <!-- Main Content Area -->
        <main class="main-content">
            <!-- Home Page -->
            <div ng-show="currentPage === 'home'">
                <div class="content-header">
                    <h1>Dashboard</h1>
                    <p>Welcome to your notes dashboard</p>
                </div>
                <div class="welcome-card">
                    <h2>Welcome to Notes App! 📝</h2>
                    <p>Organize your thoughts, ideas, and tasks in one place. Start creating notes and stay productive!</p>
                </div>
                <div class="stats-container">
                    <div class="stat-card">
                        <h3>{{ totalNotes }}</h3>
                        <p>Total Notes</p>
                    </div>
                    <div class="stat-card">
                        <h3>{{ todayNotes }}</h3>
                        <p>Notes Today</p>
                    </div>
                    <div class="stat-card">
                        <h3>{{ recentNotes }}</h3>
                        <p>Recent Notes</p>
                    </div>
                </div>
            </div>

            <!-- Notes List Page -->
            <div ng-show="currentPage === 'notes'">
                <div class="content-header">
                    <h1>My Notes</h1>
                    <p>View and manage all your notes</p>
                </div>
                <div ng-if="notes.length === 0" class="empty-state">
                    <h3>No notes yet</h3>
                    <p>Start by creating your first note!</p>
                    <button class="btn btn-primary" ng-click="changePage('add')">Create Note</button>
                </div>
                <div class="notes-grid" ng-if="notes.length > 0">
                    <div class="note-card" ng-repeat="note in notes">
                        <h3>{{ note.title }}</h3>
                        <p>{{ note.content | limitTo: 100 }}{{ note.content.length > 100 ? '...' : '' }}</p>
                        <div class="note-date">{{ note.created_at }}</div>
                        <div class="note-actions">
                            <button class="btn btn-edit" ng-click="editNote(note)">✏️ Edit</button>
                            <button class="btn btn-delete" ng-click="deleteNote(note.id)">🗑️ Delete</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Add/Edit Note Form -->
            <div ng-show="currentPage === 'add' || currentPage === 'edit'">
                <div class="content-header">
                    <h1>{{ currentPage === 'add' ? 'Create New Note' : 'Edit Note' }}</h1>
                    <p>{{ currentPage === 'add' ? 'Add a new note to your collection' : 'Update your note' }}</p>
                </div>
                <div class="form-container">
                    <form ng-submit="saveNote()">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" id="title" ng-model="currentNote.title" placeholder="Enter note title" required>
                        </div>
                        <div class="form-group">
                            <label for="content">Content</label>
                            <textarea id="content" ng-model="currentNote.content" placeholder="Write your note here..." required></textarea>
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">{{ currentPage === 'add' ? '💾 Save Note' : '💾 Update Note' }}</button>
                            <button type="button" class="btn btn-cancel" ng-click="cancelEdit()">❌ Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <script>
        var app = angular.module('notesApp', []);
        
        app.controller('DashboardController', function($scope, $http, $window) {
            $scope.currentPage = 'home';
            $scope.notes = [];
            $scope.currentNote = {};
            $scope.totalNotes = 0;
            $scope.todayNotes = 0;
            $scope.recentNotes = 0;
            
            // Change page function
            $scope.changePage = function(page) {
                $scope.currentPage = page;
                if (page === 'notes' || page === 'home') {
                    $scope.loadNotes();
                }
                if (page === 'add') {
                    $scope.currentNote = {};
                }
            };
            
            // Load all notes
            $scope.loadNotes = function() {
                $http.get('<?= base_url('notes/list') ?>').then(function(response) {
                    if (response.data.success) {
                        $scope.notes = response.data.notes;
                        $scope.updateStats();
                    }
                });
            };
            
            // Update statistics
            $scope.updateStats = function() {
                $scope.totalNotes = $scope.notes.length;
                var today = new Date().toISOString().split('T')[0];
                $scope.todayNotes = $scope.notes.filter(function(note) {
                    return note.created_at.startsWith(today);
                }).length;
                $scope.recentNotes = $scope.notes.filter(function(note) {
                    var noteDate = new Date(note.created_at);
                    var weekAgo = new Date();
                    weekAgo.setDate(weekAgo.getDate() - 7);
                    return noteDate >= weekAgo;
                }).length;
            };
            
            // Save note (create or update)
            $scope.saveNote = function() {
                var url = $scope.currentPage === 'add' ? '<?= base_url('notes/create') ?>' : '<?= base_url('notes/update') ?>';
                $http.post(url, $scope.currentNote).then(function(response) {
                    if (response.data.success) {
                        $scope.showToast('Success!', response.data.message, 'success');
                        $scope.currentNote = {};
                        $scope.changePage('notes');
                    } else {
                        $scope.showToast('Error!', response.data.message, 'error');
                    }
                }, function(error) {
                    $scope.showToast('Error!', 'An error occurred. Please try again.', 'error');
                });
            };
            
            // Edit note
            $scope.editNote = function(note) {
                $scope.currentNote = angular.copy(note);
                $scope.currentPage = 'edit';
            };
            
            // Delete note
            $scope.deleteNote = function(noteId) {
                if (confirm('Are you sure you want to delete this note?')) {
                    $http.post('<?= base_url('notes/delete') ?>', { id: noteId }).then(function(response) {
                        if (response.data.success) {
                            $scope.showToast('Success!', response.data.message, 'success');
                            $scope.loadNotes();
                        } else {
                            $scope.showToast('Error!', response.data.message, 'error');
                        }
                    });
                }
            };
            
            // Cancel edit
            $scope.cancelEdit = function() {
                $scope.currentNote = {};
                $scope.changePage('notes');
            };
            
            // Logout
            $scope.logout = function() {
                if (confirm('Are you sure you want to logout?')) {
                    $window.location.href = '<?= base_url('auth/logout') ?>';
                }
            };
            
            // Toast notification function
            $scope.showToast = function(title, message, type) {
                var toastContainer = document.getElementById('toastContainer');
                
                var toast = document.createElement('div');
                toast.className = 'toast';
                toast.innerHTML = `
                    <div class="toast-header">
                        <div class="toast-icon ${type}">${type === 'success' ? '✓' : '✕'}</div>
                        <div class="toast-title">${title}</div>
                        <button class="toast-close" onclick="this.parentElement.parentElement.remove()">×</button>
                    </div>
                    <div class="toast-message">${message}</div>
                    <div class="toast-progress ${type}"></div>
                `;
                
                toastContainer.appendChild(toast);
                
                setTimeout(function() {
                    toast.classList.add('show');
                }, 10);
                
                setTimeout(function() {
                    toast.classList.remove('show');
                    toast.classList.add('hide');
                    setTimeout(function() {
                        toast.remove();
                    }, 300);
                }, 3000);
            };
            
            // Load notes on init
            $scope.loadNotes();
        });
    </script>
</body>
</html>
