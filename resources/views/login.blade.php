<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <title>Login</title>
</head>
<body>
    <div class="px-10 max-w-lg mx-auto">
    <div class="flex justify-center">
        <img src="/img/logo.png" class="w-80 p-5">
      </div>
    <form method="POST" action="/users/authenticate" class="p3" >
        @csrf
        <h2 class="text-2xl font-bold text-red-600 uppercase text-center">
            Login
        </h2>
        <div class="mb-6 mt-10">
            <label class="text-amber-500" for="phone">
                Phone No
            </label>
            <input type="text" class="border border-gray-200 rounded p-2 w-full" name="phone"
            value="{{ old('phone') }}" autofocus placeholder="985624852" />
            @error('phone')
            <p class="text-white text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="password" class="inline-block text-amber-500 text-lg mb-2">
                Password
            </label>
            <input type="password" class="border border-gray-200 rounded p-2 w-full" name="password"
                value="{{ old('password') }}" />
            @error('password')
                <p class="text-white text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <button type="submit"
                class="bg-laravel text-red-500 border border-gra-200 rounded py-2 px-4 hover:bg-amber-200">
                Sign In
            </button>
        </div>
        <a href="/users/register" class="btn-primary"> Create user </a>
        
    </form>
    </div>
</body>
</html>
