<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3a0ca3;
            --success-color: #4cc9f0;
            --warning-color: #f8961e;
            --danger-color: #f72585;
            --light-color: #f8f9fa;
            --dark-color: #212529;
            --gray-color: #6c757d;
            --light-gray: #e9ecef;
            --border-radius: 10px;
            --box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f5f7fb;
            color: var(--dark-color);
            line-height: 1.6;
        }

        .dashboard-container {
            display: grid;
            grid-template-columns: 250px 1fr;
            min-height: 100vh;
        }

        /* Sidebar Styles */
        .sidebar {
            background-color: white;
            box-shadow: var(--box-shadow);
            padding: 20px 0;
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
        }

        .logo {
            display: flex;
            align-items: center;
            padding: 0 20px 30px;
            border-bottom: 1px solid var(--light-gray);
            margin-bottom: 20px;
        }

        .logo i {
            color: var(--primary-color);
            font-size: 28px;
            margin-right: 10px;
        }

        .logo h1 {
            font-size: 22px;
            color: var(--primary-color);
        }

        .nav-links {
            list-style: none;
            padding: 0 15px;
        }

        .nav-links li {
            margin-bottom: 5px;
        }

        .nav-links a {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            color: var(--gray-color);
            text-decoration: none;
            border-radius: var(--border-radius);
            transition: var(--transition);
        }

        .nav-links a:hover {
            background-color: var(--light-gray);
            color: var(--primary-color);
        }

        .nav-links a.active {
            background-color: rgba(67, 97, 238, 0.1);
            color: var(--primary-color);
            font-weight: 600;
        }

        .nav-links i {
            margin-right: 12px;
            width: 20px;
            text-align: center;
        }

        /* Main Content Styles */
        .main-content {
            padding: 30px;
            overflow-y: auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .header h2 {
            color: var(--dark-color);
            font-size: 28px;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background-color: var(--primary-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }

        .stat-card {
            background-color: white;
            border-radius: var(--border-radius);
            padding: 25px;
            box-shadow: var(--box-shadow);
            display: flex;
            align-items: center;
            transition: var(--transition);
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 20px;
            font-size: 24px;
            color: white;
        }

        .users-icon {
            background: linear-gradient(135deg, #4361ee, #3a0ca3);
        }

        .courses-icon {
            background: linear-gradient(135deg, #4cc9f0, #4895ef);
        }

        .enrolled-icon {
            background: linear-gradient(135deg, #f8961e, #f3722c);
        }

        .reviews-icon {
            background: linear-gradient(135deg, #f72585, #b5179e);
        }

        .stat-info h3 {
            font-size: 32px;
            margin-bottom: 5px;
            color: var(--dark-color);
        }

        .stat-info p {
            color: var(--gray-color);
            font-size: 15px;
        }

        /* Reviews Section */
        .reviews-section {
            background-color: white;
            border-radius: var(--border-radius);
            padding: 30px;
            box-shadow: var(--box-shadow);
            margin-bottom: 40px;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .section-header h3 {
            font-size: 22px;
            color: var(--dark-color);
        }

        .reviews-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .review-card {
            background-color: var(--light-gray);
            border-radius: var(--border-radius);
            padding: 20px;
            text-align: center;
            transition: var(--transition);
        }

        .review-card:hover {
            background-color: #e2e6ea;
        }

        .stars {
            color: #ffc107;
            font-size: 20px;
            margin-bottom: 15px;
        }

        .stars i {
            margin: 0 2px;
        }

        .review-count {
            font-size: 32px;
            font-weight: bold;
            margin-bottom: 8px;
        }

        .review-label {
            color: var(--gray-color);
            font-size: 15px;
        }

        /* Recent Activity */
        .activity-section {
            background-color: white;
            border-radius: var(--border-radius);
            padding: 30px;
            box-shadow: var(--box-shadow);
        }

        .activity-list {
            list-style: none;
        }

        .activity-item {
            display: flex;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid var(--light-gray);
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            color: white;
            font-size: 16px;
        }

        .icon-user {
            background-color: var(--primary-color);
        }

        .icon-course {
            background-color: var(--success-color);
        }

        .icon-review {
            background-color: var(--danger-color);
        }

        .activity-info h4 {
            font-size: 16px;
            margin-bottom: 5px;
        }

        .activity-info p {
            color: var(--gray-color);
            font-size: 14px;
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .dashboard-container {
                grid-template-columns: 1fr;
            }
            
            .sidebar {
                height: auto;
                position: relative;
            }
            
            .nav-links {
                display: flex;
                overflow-x: auto;
                padding-bottom: 10px;
            }
            
            .nav-links li {
                flex-shrink: 0;
                margin-right: 10px;
                margin-bottom: 0;
            }
            
            .nav-links a {
                padding: 10px 15px;
                white-space: nowrap;
            }
        }

        @media (max-width: 768px) {
            .main-content {
                padding: 20px;
            }
            
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 15px;
            }
            
            .stat-card {
                padding: 20px;
            }
            
            .reviews-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 576px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .reviews-grid {
                grid-template-columns: 1fr;
            }
            
            .header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
            
            .section-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="logo">
                <i class="fas fa-graduation-cap"></i>
                <h1>EduAdmin</h1>
            </div>
            <ul class="nav-links">
                <li><a href="#" class="active"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="#"><i class="fas fa-users"></i> Users</a></li>
                <li><a href="#"><i class="fas fa-book"></i> Courses</a></li>
                <li><a href="#"><i class="fas fa-chart-bar"></i> Analytics</a></li>
                <li><a href="#"><i class="fas fa-cog"></i> Settings</a></li>
                <li><a href="#"><i class="fas fa-question-circle"></i> Help</a></li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Header -->
            <header class="header">
                <h2>Dashboard Overview</h2>
                <div class="user-profile">
                    <div class="user-avatar">AD</div>
                    <div>
                        <h4>Admin User</h4>
                        <p>Administrator</p>
                    </div>
                </div>
            </header>

            <!-- Stats Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon users-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-info">
                        <h3>1,842</h3>
                        <p>Total Users</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon courses-icon">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <div class="stat-info">
                        <h3>47</h3>
                        <p>Total Courses</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon enrolled-icon">
                        <i class="fas fa-user-check"></i>
                    </div>
                    <div class="stat-info">
                        <h3>3,251</h3>
                        <p>Total Enrolled</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon reviews-icon">
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="stat-info">
                        <h3>892</h3>
                        <p>Total Reviews</p>
                    </div>
                </div>
            </div>

            <!-- Reviews Section -->
            <section class="reviews-section">
                <div class="section-header">
                    <h3>Reviews by Rating</h3>
                    <p>Distribution of course reviews</p>
                </div>
                
                <div class="reviews-grid">
                    <div class="review-card">
                        <div class="stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <div class="review-count">412</div>
                        <div class="review-label">5 Star Reviews</div>
                    </div>
                    
                    <div class="review-card">
                        <div class="stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="far fa-star"></i>
                        </div>
                        <div class="review-count">203</div>
                        <div class="review-label">4 Star Reviews</div>
                    </div>
                    
                    <div class="review-card">
                        <div class="stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="far fa-star"></i>
                            <i class="far fa-star"></i>
                        </div>
                        <div class="review-count">118</div>
                        <div class="review-label">3 Star Reviews</div>
                    </div>
                    
                    <div class="review-card">
                        <div class="stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="far fa-star"></i>
                            <i class="far fa-star"></i>
                            <i class="far fa-star"></i>
                        </div>
                        <div class="review-count">97</div>
                        <div class="review-label">2 Star Reviews</div>
                    </div>
                    
                    <div class="review-card">
                        <div class="stars">
                            <i class="fas fa-star"></i>
                            <i class="far fa-star"></i>
                            <i class="far fa-star"></i>
                            <i class="far fa-star"></i>
                            <i class="far fa-star"></i>
                        </div>
                        <div class="review-count">62</div>
                        <div class="review-label">1 Star Reviews</div>
                    </div>
                </div>
            </section>

            <!-- Recent Activity -->
            <section class="activity-section">
                <div class="section-header">
                    <h3>Recent Activity</h3>
                    <p>Latest actions in the system</p>
                </div>
                
                <ul class="activity-list">
                    <li class="activity-item">
                        <div class="activity-icon icon-user">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <div class="activity-info">
                            <h4>New user registered</h4>
                            <p>John Doe joined the platform - 2 hours ago</p>
                        </div>
                    </li>
                    
                    <li class="activity-item">
                        <div class="activity-icon icon-course">
                            <i class="fas fa-book"></i>
                        </div>
                        <div class="activity-info">
                            <h4>New course published</h4>
                            <p>"Advanced Web Development" added - 5 hours ago</p>
                        </div>
                    </li>
                    
                    <li class="activity-item">
                        <div class="activity-icon icon-review">
                            <i class="fas fa-star"></i>
                        </div>
                        <div class="activity-info">
                            <h4>New review submitted</h4>
                            <p>5-star review for "Python Basics" - 1 day ago</p>
                        </div>
                    </li>
                    
                    <li class="activity-item">
                        <div class="activity-icon icon-user">
                            <i class="fas fa-user-check"></i>
                        </div>
                        <div class="activity-info">
                            <h4>User enrolled in course</h4>
                            <p>Sarah enrolled in "Data Science 101" - 1 day ago</p>
                        </div>
                    </li>
                </ul>
            </section>
        </main>
    </div>
</body>
</html>