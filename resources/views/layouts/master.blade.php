
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="author" content="">
  <!-- <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }} "/> -->
  <title>{{ env('APP_NAME') }} </title>

  <!--<link rel="stylesheet" href="{{ asset('css/pace-theme-loading-bar.css') }}"> !-->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.2/css/bootstrapValidator.min.css"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<body class="fixed-nav bg-light mt-5" id="page-top">
     
    <div class="content-wrapper">
        <div class="container-fluid">
          
            @yield('content')

        </div>
    </div>
 
  <!-- Footer -->
  <footer class="page-footer font-small indigo">
     <!-- <div class="footer-copyright text-center py-3">© {{ Carbon\Carbon::now()->year }} Dev Prox Test (Pty) </div> -->
  </footer>
  <!-- Footer -->
</body>
</html>
