<!DOCTYPE html>
<html lang="en" ng-app="authApp">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Notes App</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 400px;
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
            font-weight: bold;
        }
        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }
        input:focus {
            outline: none;
            border-color: #667eea;
        }
        button {
            width: 100%;
            padding: 12px;
            background: #667eea;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
        }
        button:hover {
            background: #5568d3;
        }
        .message {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            text-align: center;
        }
        .success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .link {
            text-align: center;
            margin-top: 20px;
        }
        .link a {
            color: #667eea;
            text-decoration: none;
        }
        .link a:hover {
            text-decoration: underline;
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
            background: #28a745;
            width: 100%;
            animation: progressBar 2s linear forwards;
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
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular.min.js"></script>
</head>
<body ng-controller="LoginController">
    <!-- Toast Notification Container -->
    <div class="toast-container" id="toastContainer"></div>

    <div class="container">
        <h2>Login</h2>
        
        <div class="message success" ng-show="successMessage">
            {{ successMessage }}
        </div>
        <div class="message error" ng-show="errorMessage">
            {{ errorMessage }}
        </div>

        <form ng-submit="login()">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" ng-model="user.username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" ng-model="user.password" required>
            </div>
            <button type="submit">Login</button>
        </form>

        <div class="link">
            Don't have an account? <a href="<?= base_url('auth/register') ?>">Register here</a>
        </div>
    </div>

    <script>
        var app = angular.module('authApp', []);
        
        app.controller('LoginController', function($scope, $http, $window) {
            $scope.user = {};
            $scope.successMessage = '';
            $scope.errorMessage = '';
            
            // Toast notification function
            $scope.showToast = function(title, message, type) {
                var toastContainer = document.getElementById('toastContainer');
                
                var toast = document.createElement('div');
                toast.className = 'toast';
                toast.innerHTML = `
                    <div class="toast-header">
                        <div class="toast-icon ${type}">✓</div>
                        <div class="toast-title">${title}</div>
                        <button class="toast-close" onclick="this.parentElement.parentElement.remove()">×</button>
                    </div>
                    <div class="toast-message">${message}</div>
                    <div class="toast-progress"></div>
                `;
                
                toastContainer.appendChild(toast);
                
                // Trigger animation
                setTimeout(function() {
                    toast.classList.add('show');
                }, 10);
                
                // Auto remove after 2 seconds
                setTimeout(function() {
                    toast.classList.remove('show');
                    toast.classList.add('hide');
                    setTimeout(function() {
                        toast.remove();
                    }, 300);
                }, 2000);
            };
            
            $scope.login = function() {
                $scope.successMessage = '';
                $scope.errorMessage = '';
                
                // Send login request
                $http.post('<?= base_url('auth/loginSubmit') ?>', {
                    username: $scope.user.username,
                    password: $scope.user.password
                }).then(function(response) {
                    if (response.data.success) {
                        // Show toast notification
                        $scope.showToast('Success!', 'Login successful! Redirecting...', 'success');
                        
                        // Redirect after 2 seconds
                        setTimeout(function() {
                            $window.location.href = '<?= base_url('dashboard') ?>';
                        }, 2000);
                    } else {
                        $scope.errorMessage = response.data.message;
                    }
                }, function(error) {
                    $scope.errorMessage = 'An error occurred. Please try again.';
                });
            };
        });
    </script>
</body>
</html>
