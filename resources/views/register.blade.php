<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <title>register</title>
</head>
<body>
    <div class="px-10 max-w-lg mx-auto pb-10 overflow-y-auto overflow-x-hidden">
        <h2 class="text-2xl font-bold text-white uppercase text-center my-5">
            Register
        </h2>
        <div class="flex justify-center">
        <img src="/img/logo.png" class="w-80 p-5">
      </div>
        <form method="POST" action="/users/store"
            class="rounded-xl border-2 border-white bg-transparent shadow-lg  p-10 mb-10 h-full"
            id="signup">
        
            @csrf
            <div class="mb-6">
                <label for="name" class="reg-label">
                    Name
                </label>
                <input type="text" class="border border-gray-200 rounded p-2 w-full" name="name"
                    value="{{ old('name') }}" autofocus placeholder="John Doe" />
                @error('name')
                    <p class=" text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>


            <div class="mb-6">
                <label for="email" class="reg-label">Email</label>
                <input type="email" class="border border-gray-200 rounded p-2 w-full" name="email"
                    value="{{ old('email') }}" placeholder="example@example.com" />
                @error('email')
                    <p class=" text-xs mt-1">{{ $message }}</p>
                @enderror

            </div>

            <div class="mb-6">
                <label for="phone" class="reg-label">
                    Phone No
                </label>
                <input type="text" class="border border-gray-200 rounded p-2 w-full" name="phone"
                    value="{{ old('phone') }}" placeholder="9812345678"/>
                @error('phone')
                    <p class=" text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="role" class="reg-label">
                    Role
                </label>
                <select name="role" id="role" class="border border-gray-200 rounded p-2 w-full">
                    @php
                    $roles = [
                        [
                            "name" => "Admin",
                        ],
                        [
                            "name" => "Cashier",
                        ],
                        [
                            "name" => "Delivery",
                        ],
                        [
                            "name" => "Waiter",
                        ],
                        [
                            "name" => "Cook",
                        ],
                    ]
                    @endphp

                    <option value="" disabled selected hidden >Please Choose an option.</option>
                    @foreach($roles as $role)
                    <option value="{{ $role['name'] }}" @if(old('role') === $role['name'] ) selected @else @endif>{{ $role['name'] }}</option>
                    @endforeach
                </select>
                @error('role')
                    <p class="text-white text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="password" class="reg-label">
                    Password
                </label>
                <input type="password" class="border border-gray-200 rounded p-2 w-full" name="password"
                    value="{{ old('password'
                        ) }}" />
                @error('password')
                    <p class=" text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="password2" class="reg-label">
                    Confirm Password
                </label>
                <input type="password" class="border border-gray-200 rounded p-2 w-full" name="password_confirmation"
                    value="{{ old('password_confirmation') }}" />
                @error('password_confirmation')
                    <p class=" text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <button for="signup" type="submit"
                    class=" border border-sky-200 rounded py-2 px-4 ">
                    Create
                </button>
            </div>
        </form>
    </div>
    </body>
</html>
