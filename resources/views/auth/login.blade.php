<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class=" d-flex justify-content-center align-items-center vh-100">
        <form action="{{route('login')}}" method="post" class="border p-4" style="width: 100%; max-width: 400px;">
            @csrf
            <div class="mb-3 " style="text-align: center;">
                <h1>Đăng nhập</h1>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="email form-control" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="password form-control" required>
            </div>
            <button type="submit" class="login-btn btn btn-primary w-100 mt-3">Đăng nhập</button>
            <button type="button" class="btn btn-secondary w-100 mt-3" onclick="window.location.href ='{{route('register')}}'">Đăng ký</button>

        </form>
    </div>
</body>

</html>