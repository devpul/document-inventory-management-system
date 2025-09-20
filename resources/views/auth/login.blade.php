<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ config('app.name') }}</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    input, select, textarea{
      background-color: #eee;
      border-radius: 5px;
      transition: all 0.3s ease;
      padding: 10px 15px !important;
      outline:none;
    }

    input:focus, textarea:focus{
       padding-left:20px !important;
    }
  </style>
</head>
 <body class="bg-gray-100 flex items-center justify-center min-h-screen">
        <div class="w-full max-w-sm bg-white rounded-2xl shadow-lg p-8">
            <!-- Judul -->
            <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">LOGIN</h2>

            <!-- Form -->
            
            <form class="space-y-5" action="{{ route('auth.login_store') }}" method="POST">
                @csrf

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="email" name="email" 
                    class="mt-1 w-full px-4 py-2 border rounded-xl focus:ring-2 focus:ring-blue-500 focus:outline-none border-gray-300"
                    placeholder="you@example.com">
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" id="password" name="password" 
                    class="mt-1 w-full px-4 py-2 border rounded-xl focus:ring-2 focus:ring-blue-500 focus:outline-none border-gray-300"
                    placeholder="••••••••">
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between text-sm">
                    <label class="flex items-center gap-2">
                    <input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    <span>Remember me</span>
                    </label>
                </div>

                <!-- Tombol Login -->
                <button type="submit" class="w-full bg-blue-600 text-white py-2 mt-2 rounded-xl hover:bg-blue-700 transition">
                    Login
                </button>
            </form>

            <!-- Register -->
            <p class="text-sm text-center text-gray-600 mt-6">
            Belum punya akun? 
            <a href="{{ route('auth.register') }}" class="text-blue-600 hover:underline">Daftar</a>
            </p>
        </div>
    </body>
</html>
     