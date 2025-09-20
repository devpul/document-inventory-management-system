<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ config('app.name') }}</title>
  <!-- Tailwind -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Sweet Alert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

    #divSearch{
        margin-bottom: 1.5rem !important;
    }

    thead{
        background-color: #eee !important;
    }
  </style>
</head>
<body class="bg-gray-100 min-h-screen overflow-x-hidden">
  
    <!-- Wrapper -->
    <div class="flex min-h-screen">
        {{-- SweetAlert untuk flash message --}}
        @if(session('welcome'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Halo, Selamat Datang 👋 ',
                    text: "{{ session('welcome') }}",
                    confirmButtonColor: '#8bc34a',
                    showConfirmButton: true,   // tampilkan tombol OK
                    timer: null                // hilangkan auto close
                })
            </script>
        @endif

        @if(session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: "{{ session('success') }}",
                    iconColor: '#8bc34a',    // hijau cerah untuk icon
                    confirmButtonColor: '#8bc34a',
                    showConfirmButton: true,   // tampilkan tombol OK
                    timer: null                // hilangkan auto close
                })
            </script>
        @endif

        @if(session('success_edit'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil Edit!',
                    text: "{{ session('success_edit') }}",
                    iconColor: '#fbc02d',  // kuning tua untuk icon
                    confirmButtonColor: '#fbc02d',
                    showConfirmButton: true,   // tampilkan tombol OK
                    timer: null                // hilangkan auto close
                })
            </script>
        @endif

        @if(session('failed'))
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: "{{ session('failed') }}",
                    showConfirmButton: true,   // tampilkan tombol OK
                    timer: null                // hilangkan auto close
                })
            </script>
        @endif


        @yield('content')
    </div>
</body>
</html>
