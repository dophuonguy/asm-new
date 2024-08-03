<!DOCTYPE html>
<html lang="en-us">

<head>
  <meta charset="utf-8">
  <title>Reader </title>

  <!-- mobile responsive meta -->
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <meta name="description" content="This is meta description">
  <meta name="author" content="Themefisher">
  <meta name="generator" content="Hugo 0.74.3" />

  <!-- theme meta -->
  <meta name="theme-name" content="reader" />
  @include('clients.layouts.partials.link.css')
  <!-- plugins -->
  

  <meta property="og:title" content="Reader | Hugo Personal Blog Template" />
  <meta property="og:description" content="This is meta description" />
  <meta property="og:type" content="website" />
  <meta property="og:url" content="" />
  <meta property="og:updated_time" content="2020-03-15T15:40:24+06:00" />
  <style>
    .modal-backdrop {
        display: none;
    }
</style>
</head>

<body>
  <!-- navigation -->
  <header class="navigation fixed-top">
    <div class="container">
        @include('clients.layouts.partials.header')
    </div>
  </header>
  <!-- /navigation -->

  <!-- start of banner -->
        @yield('main')

  <footer class="footer">
        @include('clients.layouts.partials.footer')
  </footer>


  <!-- JS Plugins -->
        @include('clients.layouts.partials.link.js')
</body>

</html>