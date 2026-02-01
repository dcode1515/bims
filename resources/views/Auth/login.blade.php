<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Barangay Ubaldo Laya</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts: Plus Jakarta Sans for a modern geometric look -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: #2563eb; /* Modern Royal Blue */
            --primary-hover: #1d4ed8;
            --accent-color: #0ea5e9; /* Sky Blue */
            --text-dark: #1e293b;
            --text-muted: #64748b;
            --bg-light: #f8fafc;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-light);
            margin: 0;
            padding: 0;
            height: 100vh;
            overflow: hidden; /* Prevent scroll on full screen */
        }

        /* Split Screen Layout */
        .login-wrapper {
            display: flex;
            height: 100vh;
            width: 100%;
        }

        /* Left Side: Visual/Hero */
        .hero-section {
            flex: 1;
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.9), rgba(14, 165, 233, 0.8)), 
                        url('https://picsum.photos/seed/barangayHall/1200/1600.jpg') center/cover no-repeat;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 4rem;
            color: white;
            position: relative;
        }

        .hero-content h1 {
            font-weight: 800;
            font-size: 3.5rem;
            line-height: 1.1;
            margin-bottom: 1.5rem;
            text-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .hero-content p {
            font-size: 1.25rem;
            font-weight: 300;
            opacity: 0.9;
            max-width: 500px;
            margin-bottom: 2rem;
        }

        .badge-pill-custom {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(5px);
            padding: 8px 16px;
            border-radius: 50px;
            border: 1px solid rgba(255,255,255,0.3);
            font-size: 0.9rem;
            font-weight: 500;
            width: fit-content;
        }

        /* Right Side: Form */
        .form-section {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 2rem;
            background: white;
            position: relative;
            overflow-y: auto;
        }

        .form-container {
            width: 100%;
            max-width: 450px;
        }

        .logo-area {
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo-icon {
            width: 45px;
            height: 45px;
            background: var(--primary-color);
            color: white;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

        .logo-text h2 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0;
        }

        .logo-text span {
            font-size: 0.9rem;
            color: var(--text-muted);
        }

        /* Modern Inputs */
        .input-group-custom {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .input-field {
            width: 100%;
            padding: 16px 16px 16px 50px; /* Left padding for icon */
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 1rem;
            background: #fdfdfd;
            transition: all 0.3s ease;
            outline: none;
            font-family: inherit;
        }

        .input-field:focus {
            border-color: var(--primary-color);
            background: white;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
        }

        .input-icon {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            transition: color 0.3s;
        }

        .input-field:focus + .input-icon {
            color: var(--primary-color);
        }

        /* Custom Checkbox */
        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        /* Modern Button */
        .btn-modern {
            background: var(--primary-color);
            color: white;
            padding: 14px;
            border-radius: 12px;
            font-weight: 600;
            border: none;
            width: 100%;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.2);
        }

        .btn-modern:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.3);
        }

        .btn-modern:active {
            transform: translateY(0);
        }

        /* Utility Links */
        .forgot-link {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            transition: opacity 0.2s;
        }
        
        .forgot-link:hover {
            opacity: 0.8;
            text-decoration: underline;
        }

        /* Background Decorative Blobs */
        .bg-blob {
            position: absolute;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(37, 99, 235, 0.05) 0%, rgba(255,255,255,0) 70%);
            border-radius: 50%;
            z-index: 0;
        }
        .blob-1 { top: -100px; right: -100px; }
        .blob-2 { bottom: -100px; left: -100px; }

        /* Responsive */
        @media (max-width: 992px) {
            .hero-section {
                display: none; /* Hide hero on tablet/mobile */
            }
            .form-section {
                width: 100%;
                flex: none;
            }
            body {
                overflow: auto;
                height: auto;
            }
            .login-wrapper {
                height: auto;
                flex-direction: column;
            }
            .form-section {
                min-height: 100vh;
            }
        }
    </style>
</head>
<body>

    <div class="login-wrapper">
        
        <!-- Left Side: Branding & Visual -->
        <div class="hero-section">
            <div class="hero-content">
                <div class="badge-pill-custom mb-4">
                    <i class="fas fa-check-circle me-2"></i> Official Government Portal
                </div>
                <h1>Barangay Ubaldo Laya</h1>
                <h3 class="mb-4 fw-light">Lanao del Norte</h3>
                <p>
                    Empowering our community through digital transparency. 
                    Access documents, request permits, and stay updated with barangay announcements securely.
                </p>
                
                <div class="mt-5 d-flex gap-4">
                    <div>
                        <h4 class="fw-bold mb-0">24/7</h4>
                        <small class="opacity-75">Service Access</small>
                    </div>
                    <div style="width: 1px; height: 40px; background: rgba(255,255,255,0.3);"></div>
                    <div>
                        <h4 class="fw-bold mb-0">Secure</h4>
                        <small class="opacity-75">Data Protection</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side: Login Form -->
        <div class="form-section">
            <!-- Decorative Background Blobs -->
            <div class="bg-blob blob-1"></div>
            <div class="bg-blob blob-2"></div>

            <div class="form-container position-relative z-1">
                <div class="logo-area">
                    <div class="logo-icon">
                        <i class="fas fa-building-columns"></i>
                    </div>
                    <div class="logo-text">
                        <h2>Portal Login</h2>
                        <span>Barangay Management System</span>
                    </div>
                </div>

                <p class="text-muted mb-4">Welcome back! Please enter your User Account.</p>

               <div id = "app">
                  <Login></Login>
                </div>
            </div>
        </div>

    </div>

    <!-- Bootstrap JS -->
       <script src="{{ asset('public/js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  
</body>
</html>