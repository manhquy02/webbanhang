<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Document</title>
</head>

<body>
    <div class="d-flex  justify-content-center align-items-center vh-100">
        <form action="{{route('register')}} " method="post" class="border p-4" style="width: 100%; max-width: 400px;">
            @csrf
            <div class="mb-3 " style="text-align: center;">
                <h1>Đăng ký</h1>
            </div>
            <div class="mb-3">
                <label for="username">Tên đăng ký</label>
                <input type="text" name="username" class="username form-control" value="{{old('username')}}" required>
                @error('username')
                <div>{{$message}}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="email">Email</label>
                <input type="email" name="email" class="email form-control" value="{{old('email')}}" required>
                @error('email')
                <div>{{$message}}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="password">password</label>
                <input type="password" name="password" class="password form-control" required>
                @error('password')
                <div>{{$message}}</div>
                @enderror
            </div>
            <button type="submit" class="register-btn btn btn-primary w-100 mt-3">Đăng ký</button>
            @if(session('success'))
            <div>{{session('success')}}</div>
            @endif
        </form>
    </div>
</body>

</html>