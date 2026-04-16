<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Loan 5C System</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f5f6fa;
        }
    </style>

</head>
<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-dark bg-dark mb-4">
        <div class="container">
            <span class="navbar-brand">Loan 5C System</span>
        </div>
    </nav>

    <!-- CONTENT -->
    <div class="container">
        @yield('content')
    </div>
    <div>
            <a href="{{ url('/loan/apps') }}" class="text-white me-3">
                Senarai Permohonan
            </a>
        </div>


    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @yield('scripts')

</body>
</html>
