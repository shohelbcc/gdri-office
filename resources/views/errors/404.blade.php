<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/bootstrap.min.css') }}">
    <title>404 Not Found</title>
    <style>
        .custom-bg {
            background: linear-gradient(to right, #e2e8f0, #e5e7eb);
        }

        @media (prefers-color-scheme: dark) {
            .custom-bg {
                background: linear-gradient(to right, #1f2937, #111827);
                color: white !important;
            }

            .custom-btn {
                background-color: #374151 !important;
                color: white !important;
            }

            .custom-btn:hover {
                background-color: #4b5563 !important;
            }
        }
    </style>
</head>
<body>

    <div class="custom-bg text-dark">
        <div class="d-flex align-items-center justify-content-center min-vh-100 px-2">
            <div class="text-center">
                <h1 class="display-1 fw-bold text-primary">404</h1>
                <p class="fs-2 fw-medium mt-4 text-danger">Oops! Page not found</p>
                <p class="mt-4 mb-5">The page you're looking for doesn't exist or has been moved.</p>
                <a href="/" class="btn btn-success fw-semibold rounded-pill px-4 py-2 custom-btn">
                    Go Home
                </a>
            </div>
        </div>
    </div>
    
</body>
</html>