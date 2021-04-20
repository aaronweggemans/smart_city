<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Returns Title and removes the spaces, and makes the first letter capital --}}
    <title>SDI | {{ ucwords(strtolower(str_replace('_', ' ', Route::currentRouteName())), '\',. ') }} | Dashboard</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    {{-- BOOTSTAP --}}
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

    {{--FONT AWESOME--}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>

    {{-- Favicon --}}
    <link rel="shortcut icon" href="{{ asset('img/favicon/android-chrome-192x192.png') }}">
</head>
<body>
<aside class="sidebar position-fixed top-0 left-0 overflow-auto h-100 float-left" id="show-side-navigation1">
    <i class="uil-bars close-aside d-md-none d-lg-none" data-close="show-side-navigation1"></i>
    <div class="text-center sidebar-header d-flex justify-content-center align-items-center px-3 py-4 mb-3">
        <div class="ms-2">
            <img src="{{ Auth::user()->getAvatarImage() }}" class="rounded-circle mb-2"
                 style="width: 140px;height: 125px;">
            <h5 class="fs-6 mb-0">
                <h6 class="text-decoration-none text-white">{{ Auth::user()->name }}</h6>
            </h5>
            <p class="mt-1 mb-0">
                {{ Auth::user()->getRoleName() }}
            </p>
            <small class="mb-0 text-white">{{ Auth::user()->getStreetName() }} {{ Auth::user()->getCityName() }}</small>
        </div>
    </div>

    <ul class="categories list-unstyled">
        <li class="{{ Request::is('dashboard') ? 'active' : '' }}">
            <a href="{{ route('dashboard') }}">
                <i class="fas fa-chart-line fa-sm center-sidebar-item"></i> Dashboard
            </a>
        </li>
        @if (auth::user()->role_id == 1)
        <li class="{{ Request::is('dashboard/users') ? 'active' : '' }}">
            <a href="{{ route('dashboard_all_users') }}">
                <i class="fas fa-users fa-sm center-sidebar-item"></i> Users
            </a>
        </li>
        <li class="{{ Request::is('dashboard/locations') ? 'active' : '' }}">
            <a href="{{ route('dashboard_all_locations') }}">
                <i class="fas fa-location-arrow fa-sm center-sidebar-item"></i> Locations
            </a>
        </li>
        <li class="{{ Request::is('dashboard/reports') ? 'active' : '' }}">
            <a href="{{ route('dashboard_all_reports') }}">
                <i class="fas fa-file-pdf fa-sm center-sidebar-item"></i> Reports
            </a>
        </li>
        @endif
        <li class="{{ Request::is('dashboard/settings') ? 'active' : '' }}">
            <a href="{{ route('dashboard_settings') }}">
                <i class="fas fa-cogs fa-sm center-sidebar-item"></i> Settings
            </a>
        </li>
    </ul>
</aside>

<section id="wrapper">
    <nav class="navbar navbar-expand-md">
        <div class="container-fluid mx-2">
            <div class="collapse navbar-collapse" id="toggle-navbar">
                <ul class="navbar-nav ms-auto float-md-left">
                    <li class="nav-item">
                        <a href="{{ route('landing_page') }}">
                            <svg viewBox="0 0 250 90" width="189" height="50">
                                <line x1="77.642" y1="35.4" x2="110.542" y2="35.4" stroke="#5e24c3"
                                      stroke-linecap="round"></line>
                                <path fill="#5e24c3" fill-rule="nonzero"
                                      d="M1.25 11.69Q1.99 11.69 2.40 12.14Q2.81 12.60 2.81 13.26Q2.81 13.92 2.59 14.33L2.59 14.33Q3.65 15.19 5.03 15.19Q6.41 15.19 7.10 14.56Q7.80 13.92 7.80 12.82Q7.80 11.71 7.03 10.92Q6.26 10.13 5.17 9.60Q4.08 9.07 3 8.48Q1.92 7.90 1.15 6.91Q0.38 5.93 0.38 4.58L0.38 4.58Q0.38 2.74 1.61 1.69Q2.83 0.65 4.75 0.65Q6.67 0.65 8.08 1.56Q9.48 2.47 9.48 4.02Q9.48 5.57 8.23 5.57L8.23 5.57Q7.49 5.57 7.08 5.11Q6.67 4.66 6.67 3.94Q6.67 3.22 6.96 2.83L6.96 2.83Q6.12 2.06 4.90 2.06Q3.67 2.06 3.06 2.69Q2.45 3.31 2.45 4.25Q2.45 5.18 3 5.84Q3.55 6.50 4.37 6.92Q5.18 7.34 6.14 7.88Q7.10 8.42 7.92 8.95Q8.74 9.48 9.29 10.38Q9.84 11.28 9.84 12.43L9.84 12.43Q9.84 14.33 8.53 15.53Q7.22 16.73 5.18 16.73Q3.14 16.73 1.57 15.78Q0 14.83 0 13.13L0 13.13Q0 11.69 1.25 11.69L1.25 11.69ZM26.88 8.33L26.88 8.33L26.86 10.30Q26.86 12.82 27.14 14.98L27.14 14.98L28.01 15.05Q28.06 15.26 28.06 15.62Q28.06 15.98 27.98 16.39L27.98 16.39Q27.31 16.37 25.97 16.37Q24.62 16.37 24.05 16.39L24.05 16.39Q23.98 16.03 23.98 15.71Q23.98 15.38 24.02 15.05L24.02 15.05L24.84 14.98Q25.03 12.17 25.03 10.16Q25.03 8.16 24.67 7.30Q24.31 6.43 23.47 6.43L23.47 6.43Q22.27 6.43 20.90 8.02L20.90 8.02L20.88 10.30Q20.88 12.82 21.17 14.98L21.17 14.98L22.01 15.05Q22.06 15.43 22.06 15.71Q22.06 15.98 21.98 16.39L21.98 16.39Q21.31 16.37 19.97 16.37Q18.62 16.37 18.05 16.39L18.05 16.39Q17.98 16.03 17.98 15.71Q17.98 15.38 18.02 15.05L18.02 15.05L18.86 14.98Q19.06 12.17 19.06 10.16Q19.06 8.16 18.70 7.30Q18.34 6.43 17.50 6.43L17.50 6.43Q16.27 6.43 14.93 7.99L14.93 7.99Q14.90 8.62 14.90 10.91Q14.90 13.20 15.12 14.98L15.12 14.98L16.01 15.05Q16.06 15.58 16.06 15.78Q16.06 15.98 15.98 16.39L15.98 16.39Q15.31 16.37 14.02 16.37Q12.72 16.37 12.12 16.39L12.12 16.39Q12.05 16.03 12.05 15.71Q12.05 15.38 12.10 15.05L12.10 15.05L12.94 14.98Q13.15 12.58 13.15 10.57Q13.15 8.57 12.96 6.60L12.96 6.60L12.07 6.53Q12.00 6.12 12.00 5.72Q12.00 5.33 12.02 5.18L12.02 5.18Q13.25 5.16 15 4.97L15 4.97L15.12 5.09Q15.05 5.59 14.98 6.50L14.98 6.50Q15.67 5.78 16.58 5.34Q17.50 4.90 18.29 4.90L18.29 4.90Q20.26 4.90 20.76 6.74L20.76 6.74Q21.46 5.93 22.43 5.41Q23.40 4.90 24.26 4.90L24.26 4.90Q25.61 4.90 26.24 5.72Q26.88 6.55 26.88 8.33ZM38.38 8.09L38.38 8.09L38.28 11.54Q38.28 13.18 38.47 14.74L38.47 14.74L39.36 14.81Q39.41 15.19 39.41 15.52Q39.41 15.84 39.34 16.20L39.34 16.20Q38.64 16.22 36.62 16.44L36.62 16.44Q36.46 15.98 36.36 15.31L36.36 15.31Q34.49 16.73 33.13 16.73Q31.78 16.73 31.02 15.85Q30.26 14.98 30.26 13.36Q30.26 11.74 31.28 10.80Q32.30 9.86 33.85 9.86Q35.40 9.86 36.50 10.44L36.50 10.44Q36.53 10.18 36.53 9.58L36.53 9.58Q36.53 7.80 36.04 7.02Q35.54 6.24 34.54 6.24Q33.53 6.24 33.07 6.62L33.07 6.62Q33.26 7.01 33.26 7.58Q33.26 8.16 32.89 8.58Q32.52 9.00 31.85 9.00L31.85 9.00Q30.72 9.00 30.72 7.67Q30.72 6.34 31.73 5.62Q32.74 4.90 34.56 4.90Q36.38 4.90 37.38 5.75Q38.38 6.60 38.38 8.09ZM36.41 11.95L36.41 11.95Q35.42 11.11 34.30 11.11L34.30 11.11Q32.14 11.11 32.14 13.03L32.14 13.03Q32.14 15.00 33.84 15.00L33.84 15.00Q34.46 15.00 35.17 14.68Q35.88 14.35 36.29 13.87L36.29 13.87Q36.41 12.43 36.41 11.95ZM41.28 15.05L42.12 14.98Q42.34 12.58 42.34 10.57Q42.34 8.57 42.14 6.60L42.14 6.60L41.26 6.53Q41.18 6.14 41.18 5.74Q41.18 5.33 41.21 5.18L41.21 5.18Q42.43 5.16 44.18 4.97L44.18 4.97L44.30 5.09Q44.28 5.23 44.16 6.50L44.16 6.50Q44.71 5.81 45.44 5.35Q46.18 4.90 46.88 4.90Q47.59 4.90 48.12 5.40Q48.65 5.90 48.65 6.72L48.65 6.72Q48.65 8.06 47.52 8.06L47.52 8.06Q46.87 8.06 46.49 7.64Q46.10 7.22 46.10 6.53L46.10 6.53Q46.06 6.50 45.94 6.50L45.94 6.50Q45.05 6.50 44.11 7.85L44.11 7.85Q44.09 8.52 44.09 10.86Q44.09 13.20 44.30 14.98L44.30 14.98L45.19 15.05Q45.24 15.58 45.24 15.78Q45.24 15.98 45.17 16.39L45.17 16.39Q44.50 16.37 43.20 16.37Q41.90 16.37 41.30 16.39L41.30 16.39Q41.23 16.03 41.23 15.71Q41.23 15.38 41.28 15.05L41.28 15.05ZM50.54 12.48L50.54 12.48Q50.54 12.48 50.59 7.13L50.59 7.13Q50.59 6.77 50.57 6.58L50.57 6.58Q49.56 6.58 49.13 6.60L49.13 6.60Q48.98 6.22 48.98 5.84Q48.98 5.47 49.03 5.28L49.03 5.28L50.50 5.28L50.38 3.50Q50.98 3.31 51.64 3.31Q52.30 3.31 52.73 3.41L52.73 3.41L52.51 5.26Q53.83 5.23 55.18 5.11L55.18 5.11Q55.32 5.42 55.32 5.80Q55.32 6.17 55.22 6.70L55.22 6.70Q54.34 6.65 52.42 6.60L52.42 6.60Q52.37 7.08 52.37 8.02L52.37 8.02L52.37 12.89Q52.37 13.51 52.43 13.91Q52.49 14.30 52.74 14.63Q52.99 14.95 53.47 14.95L53.47 14.95Q54.53 14.95 55.49 14.21L55.49 14.21Q55.99 14.93 55.99 16.15L55.99 16.15Q54.67 16.73 53.70 16.73Q52.73 16.73 52.15 16.48Q51.58 16.22 51.26 15.88Q50.95 15.53 50.78 14.90L50.78 14.90Q50.54 14.02 50.54 12.48ZM68.81 16.73L68.81 16.73Q67.30 16.73 65.99 16.56Q64.68 16.39 63.22 16.32L63.22 16.32Q63.19 16.18 63.19 15.74Q63.19 15.31 63.26 14.98L63.26 14.98L64.22 14.90Q64.44 12.46 64.44 8.41Q64.44 4.37 64.20 2.47L64.20 2.47L63.26 2.40Q63.19 2.11 63.19 1.66Q63.19 1.20 63.22 1.06L63.22 1.06Q64.80 1.03 66.07 0.84Q67.34 0.65 68.81 0.65L68.81 0.65Q71.86 0.65 73.49 2.70Q75.12 4.75 75.12 8.57L75.12 8.57Q75.12 16.73 68.81 16.73ZM68.81 15.02L68.81 15.02Q70.87 15.02 71.96 13.37Q73.06 11.71 73.06 8.58Q73.06 5.45 71.95 3.76Q70.85 2.06 68.78 2.06L68.78 2.06Q67.58 2.06 66.41 2.52L66.41 2.52Q66.24 4.56 66.24 8.45Q66.24 12.34 66.43 14.52L66.43 14.52Q67.56 15.02 68.81 15.02ZM85.51 8.09L85.51 8.09L85.42 11.54Q85.42 13.18 85.61 14.74L85.61 14.74L86.50 14.81Q86.54 15.19 86.54 15.52Q86.54 15.84 86.47 16.20L86.47 16.20Q85.78 16.22 83.76 16.44L83.76 16.44Q83.59 15.98 83.50 15.31L83.50 15.31Q81.62 16.73 80.27 16.73Q78.91 16.73 78.16 15.85Q77.40 14.98 77.40 13.36Q77.40 11.74 78.42 10.80Q79.44 9.86 80.99 9.86Q82.54 9.86 83.64 10.44L83.64 10.44Q83.66 10.18 83.66 9.58L83.66 9.58Q83.66 7.80 83.17 7.02Q82.68 6.24 81.67 6.24Q80.66 6.24 80.21 6.62L80.21 6.62Q80.40 7.01 80.40 7.58Q80.40 8.16 80.03 8.58Q79.66 9.00 78.98 9.00L78.98 9.00Q77.86 9.00 77.86 7.67Q77.86 6.34 78.86 5.62Q79.87 4.90 81.70 4.90Q83.52 4.90 84.52 5.75Q85.51 6.60 85.51 8.09ZM83.54 11.95L83.54 11.95Q82.56 11.11 81.43 11.11L81.43 11.11Q79.27 11.11 79.27 13.03L79.27 13.03Q79.27 15.00 80.98 15.00L80.98 15.00Q81.60 15.00 82.31 14.68Q83.02 14.35 83.42 13.87L83.42 13.87Q83.54 12.43 83.54 11.95ZM89.35 12.48L89.35 12.48Q89.35 12.48 89.40 7.13L89.40 7.13Q89.40 6.77 89.38 6.58L89.38 6.58Q88.37 6.58 87.94 6.60L87.94 6.60Q87.79 6.22 87.79 5.84Q87.79 5.47 87.84 5.28L87.84 5.28L89.30 5.28L89.18 3.50Q89.78 3.31 90.44 3.31Q91.10 3.31 91.54 3.41L91.54 3.41L91.32 5.26Q92.64 5.23 93.98 5.11L93.98 5.11Q94.13 5.42 94.13 5.80Q94.13 6.17 94.03 6.70L94.03 6.70Q93.14 6.65 91.22 6.60L91.22 6.60Q91.18 7.08 91.18 8.02L91.18 8.02L91.18 12.89Q91.18 13.51 91.24 13.91Q91.30 14.30 91.55 14.63Q91.80 14.95 92.28 14.95L92.28 14.95Q93.34 14.95 94.30 14.21L94.30 14.21Q94.80 14.93 94.80 16.15L94.80 16.15Q93.48 16.73 92.51 16.73Q91.54 16.73 90.96 16.48Q90.38 16.22 90.07 15.88Q89.76 15.53 89.59 14.90L89.59 14.90Q89.35 14.02 89.35 12.48ZM104.23 8.09L104.23 8.09L104.14 11.54Q104.14 13.18 104.33 14.74L104.33 14.74L105.22 14.81Q105.26 15.19 105.26 15.52Q105.26 15.84 105.19 16.20L105.19 16.20Q104.50 16.22 102.48 16.44L102.48 16.44Q102.31 15.98 102.22 15.31L102.22 15.31Q100.34 16.73 98.99 16.73Q97.63 16.73 96.88 15.85Q96.12 14.98 96.12 13.36Q96.12 11.74 97.14 10.80Q98.16 9.86 99.71 9.86Q101.26 9.86 102.36 10.44L102.36 10.44Q102.38 10.18 102.38 9.58L102.38 9.58Q102.38 7.80 101.89 7.02Q101.40 6.24 100.39 6.24Q99.38 6.24 98.93 6.62L98.93 6.62Q99.12 7.01 99.12 7.58Q99.12 8.16 98.75 8.58Q98.38 9.00 97.70 9.00L97.70 9.00Q96.58 9.00 96.58 7.67Q96.58 6.34 97.58 5.62Q98.59 4.90 100.42 4.90Q102.24 4.90 103.24 5.75Q104.23 6.60 104.23 8.09ZM102.26 11.95L102.26 11.95Q101.28 11.11 100.15 11.11L100.15 11.11Q97.99 11.11 97.99 13.03L97.99 13.03Q97.99 15.00 99.70 15.00L99.70 15.00Q100.32 15.00 101.03 14.68Q101.74 14.35 102.14 13.87L102.14 13.87Q102.26 12.43 102.26 11.95ZM117.55 2.28L116.64 2.35Q116.47 4.30 116.47 8.38Q116.47 12.46 116.69 14.98L116.69 14.98L117.55 15.05Q117.60 15.43 117.60 15.71Q117.60 15.98 117.53 16.39L117.53 16.39Q116.69 16.37 115.58 16.37Q114.48 16.37 113.66 16.39L113.66 16.39Q113.59 16.03 113.59 15.76Q113.59 15.48 113.64 15.05L113.64 15.05L114.48 14.98Q114.67 12.38 114.67 8.36Q114.67 4.34 114.46 2.35L114.46 2.35L113.64 2.28Q113.59 1.90 113.59 1.62Q113.59 1.34 113.66 0.94L113.66 0.94Q114.50 0.96 115.61 0.96Q116.71 0.96 117.53 0.94L117.53 0.94Q117.60 1.30 117.60 1.57Q117.60 1.85 117.55 2.28L117.55 2.28ZM130.03 7.97L130.03 7.97L130.01 10.30Q130.01 12.82 130.30 14.98L130.30 14.98L131.14 15.05Q131.18 15.58 131.18 15.78Q131.18 15.98 131.11 16.39L131.11 16.39Q130.44 16.37 129.10 16.37Q127.75 16.37 127.18 16.39L127.18 16.39Q127.10 16.03 127.10 15.71Q127.10 15.38 127.15 15.05L127.15 15.05L127.99 14.98Q128.18 12.17 128.18 10.16Q128.18 8.16 127.79 7.30Q127.39 6.43 126.43 6.43L126.43 6.43Q125.14 6.43 123.58 7.99L123.58 7.99Q123.55 8.62 123.55 10.91Q123.55 13.20 123.77 14.98L123.77 14.98L124.66 15.05Q124.70 15.58 124.70 15.78Q124.70 15.98 124.63 16.39L124.63 16.39Q123.96 16.37 122.66 16.37Q121.37 16.37 120.77 16.39L120.77 16.39Q120.70 16.03 120.70 15.71Q120.70 15.38 120.74 15.05L120.74 15.05L121.58 14.98Q121.80 12.58 121.80 10.57Q121.80 8.57 121.61 6.60L121.61 6.60L120.72 6.53Q120.65 6.12 120.65 5.72Q120.65 5.33 120.67 5.18L120.67 5.18Q121.90 5.16 123.65 4.97L123.65 4.97L123.77 5.09Q123.72 5.38 123.62 6.53L123.62 6.53Q124.37 5.78 125.35 5.34Q126.34 4.90 127.20 4.90L127.20 4.90Q130.03 4.90 130.03 7.97ZM137.02 4.90Q138.70 4.90 139.69 5.69Q140.69 6.48 140.69 7.74Q140.69 9.00 139.56 9.00L139.56 9.00Q138.89 9.00 138.52 8.58Q138.14 8.16 138.14 7.58Q138.14 7.01 138.34 6.62L138.34 6.62Q137.76 6.17 136.97 6.17Q136.18 6.17 135.66 6.55Q135.14 6.94 135.14 7.68Q135.14 8.42 135.73 8.98Q136.32 9.53 137.16 9.88Q138 10.22 138.84 10.60Q139.68 10.97 140.27 11.65Q140.86 12.34 140.86 13.34L140.86 13.34Q140.86 14.90 139.81 15.82Q138.77 16.73 136.97 16.73Q135.17 16.73 134.03 15.96Q132.89 15.19 132.89 13.94L132.89 13.94L132.89 13.85Q132.89 12.55 134.02 12.55L134.02 12.55Q134.69 12.55 135.06 12.97Q135.43 13.39 135.43 13.94Q135.43 14.50 135.31 14.81L135.31 14.81Q135.79 15.12 136.84 15.12Q137.88 15.12 138.42 14.76Q138.96 14.40 138.96 13.76Q138.96 13.13 138.37 12.62Q137.78 12.12 136.94 11.77Q136.10 11.42 135.26 11.03Q134.42 10.63 133.84 9.89Q133.25 9.14 133.25 8.11L133.25 8.11Q133.25 6.62 134.29 5.76Q135.34 4.90 137.02 4.90ZM143.21 15.05L144.05 14.98Q144.26 12.62 144.26 10.67Q144.26 8.71 144.07 6.60L144.07 6.60L143.18 6.53Q143.11 6.12 143.11 5.75Q143.11 5.38 143.14 5.18L143.14 5.18Q144.53 5.14 146.11 4.97L146.11 4.97L146.23 5.09Q146.02 6.50 146.02 9.84Q146.02 13.18 146.23 14.98L146.23 14.98L147.12 15.05Q147.17 15.43 147.17 15.71Q147.17 15.98 147.10 16.39L147.10 16.39Q146.26 16.37 145.15 16.37Q144.05 16.37 143.23 16.39L143.23 16.39Q143.16 16.03 143.16 15.65Q143.16 15.26 143.21 15.05L143.21 15.05ZM146.47 1.66L146.47 1.66Q146.47 3.14 144.94 3.14L144.94 3.14Q143.74 3.14 143.74 1.92L143.74 1.92Q143.74 0.41 145.27 0.41L145.27 0.41Q146.47 0.41 146.47 1.66ZM153.46 4.90L153.46 4.90Q153.74 4.90 153.89 4.92L153.89 4.92Q155.40 2.62 157.18 2.62L157.18 2.62Q158.74 2.62 158.74 4.13L158.74 4.13Q158.74 5.18 157.69 5.18Q156.65 5.18 156.48 4.10L156.48 4.10Q155.78 4.10 155.18 5.14L155.18 5.14Q157.51 5.90 157.51 8.98L157.51 8.98Q157.51 10.85 156.77 12.10L156.77 12.10Q155.93 13.49 153.46 13.49L153.46 13.49Q152.42 13.49 151.78 13.25L151.78 13.25Q151.27 14.14 151.03 15.19L151.03 15.19Q151.44 15.26 151.90 15.26Q152.35 15.26 153.72 15.10Q155.09 14.93 155.69 14.93L155.69 14.93Q156.94 14.93 157.70 15.55Q158.47 16.18 158.47 17.47Q158.47 18.77 157.63 19.73L157.63 19.73Q156.17 21.41 153.07 21.41L153.07 21.41Q150.98 21.41 149.88 20.88Q148.78 20.35 148.78 18.91L148.78 18.91Q148.78 17.86 149.90 16.73L149.90 16.73Q149.45 16.39 149.45 15.79L149.45 15.79Q149.45 14.52 150.67 12.67L150.67 12.67Q149.40 11.64 149.40 8.98L149.40 8.98Q149.40 4.90 153.46 4.90ZM151.34 9.00Q151.34 11.83 153.46 11.83Q155.57 11.83 155.57 9.00Q155.57 6.17 153.46 6.17Q151.34 6.17 151.34 9.00ZM150.72 18.55L150.72 18.55Q150.72 20.09 153.53 20.09L153.53 20.09Q154.73 20.09 155.68 19.56Q156.62 19.03 156.62 17.98L156.62 17.98Q156.62 16.80 155.35 16.80L155.35 16.80Q154.73 16.80 153.38 16.96Q152.04 17.11 151.22 17.11L151.22 17.11L151.03 17.11Q150.72 17.78 150.72 18.55ZM169.99 7.97L169.99 7.97L169.97 10.30Q169.97 12.84 170.26 14.98L170.26 14.98L171.10 15.05Q171.14 15.43 171.14 15.71Q171.14 15.98 171.07 16.39L171.07 16.39Q170.23 16.37 169.09 16.37Q167.95 16.37 167.14 16.39L167.14 16.39Q167.06 16.03 167.06 15.76Q167.06 15.48 167.11 15.05L167.11 15.05L167.95 14.98Q168.14 12.38 168.14 10.37Q168.14 8.35 167.80 7.39Q167.45 6.43 166.39 6.43L166.39 6.43Q165.05 6.43 163.51 7.97L163.51 7.97L163.51 10.22Q163.51 13.18 163.73 14.98L163.73 14.98L164.62 15.05Q164.66 15.43 164.66 15.71Q164.66 15.98 164.59 16.39L164.59 16.39Q163.75 16.37 162.65 16.37Q161.54 16.37 160.73 16.39L160.73 16.39Q160.66 16.03 160.66 15.76Q160.66 15.48 160.70 15.05L160.70 15.05L161.54 14.98Q161.76 12.72 161.76 10.80L161.76 10.80L161.76 7.51Q161.76 3.19 161.64 1.63L161.64 1.63L160.68 1.56Q160.61 1.25 160.61 0.83Q160.61 0.41 160.63 0.22L160.63 0.22Q162.82 0.10 163.75 0L163.75 0L163.85 0.12Q163.51 2.98 163.51 6.55L163.51 6.55Q164.23 5.83 165.24 5.36Q166.25 4.90 167.16 4.90L167.16 4.90Q169.99 4.90 169.99 7.97ZM173.95 12.48L173.95 12.48Q173.95 12.48 174.00 7.13L174.00 7.13Q174.00 6.77 173.98 6.58L173.98 6.58Q172.97 6.58 172.54 6.60L172.54 6.60Q172.39 6.22 172.39 5.84Q172.39 5.47 172.44 5.28L172.44 5.28L173.90 5.28L173.78 3.50Q174.38 3.31 175.04 3.31Q175.70 3.31 176.14 3.41L176.14 3.41L175.92 5.26Q177.24 5.23 178.58 5.11L178.58 5.11Q178.73 5.42 178.73 5.80Q178.73 6.17 178.63 6.70L178.63 6.70Q177.74 6.65 175.82 6.60L175.82 6.60Q175.78 7.08 175.78 8.02L175.78 8.02L175.78 12.89Q175.78 13.51 175.84 13.91Q175.90 14.30 176.15 14.63Q176.40 14.95 176.88 14.95L176.88 14.95Q177.94 14.95 178.90 14.21L178.90 14.21Q179.40 14.93 179.40 16.15L179.40 16.15Q178.08 16.73 177.11 16.73Q176.14 16.73 175.56 16.48Q174.98 16.22 174.67 15.88Q174.36 15.53 174.19 14.90L174.19 14.90Q173.95 14.02 173.95 12.48ZM184.34 4.90Q186.02 4.90 187.02 5.69Q188.02 6.48 188.02 7.74Q188.02 9.00 186.89 9.00L186.89 9.00Q186.22 9.00 185.84 8.58Q185.47 8.16 185.47 7.58Q185.47 7.01 185.66 6.62L185.66 6.62Q185.09 6.17 184.30 6.17Q183.50 6.17 182.99 6.55Q182.47 6.94 182.47 7.68Q182.47 8.42 183.06 8.98Q183.65 9.53 184.49 9.88Q185.33 10.22 186.17 10.60Q187.01 10.97 187.60 11.65Q188.18 12.34 188.18 13.34L188.18 13.34Q188.18 14.90 187.14 15.82Q186.10 16.73 184.30 16.73Q182.50 16.73 181.36 15.96Q180.22 15.19 180.22 13.94L180.22 13.94L180.22 13.85Q180.22 12.55 181.34 12.55L181.34 12.55Q182.02 12.55 182.39 12.97Q182.76 13.39 182.76 13.94Q182.76 14.50 182.64 14.81L182.64 14.81Q183.12 15.12 184.16 15.12Q185.21 15.12 185.75 14.76Q186.29 14.40 186.29 13.76Q186.29 13.13 185.70 12.62Q185.11 12.12 184.27 11.77Q183.43 11.42 182.59 11.03Q181.75 10.63 181.16 9.89Q180.58 9.14 180.58 8.11L180.58 8.11Q180.58 6.62 181.62 5.76Q182.66 4.90 184.34 4.90Z"
                                      transform="translate(0, 41.4)"></path>
                            </svg>
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto float-md-left ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#" role="button">
                            Account
                        </a>
                    </li>

                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Settings
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('landing_page') }}">
                                Landing
                            </a>

                            <a class="dropdown-item" href="{{ route('dashboard_settings') }}">
                                Settings
                            </a>

                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="p-4">
        @yield('content')
    </div>
</section>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA1s66kXMm6obk6K67NcL1zvTNwgAC7KTU"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

<script src="{{ asset('js/image-placeholder.js') }}" defer></script>
<script src="{{ asset('js/get_street_names.js') }}" defer></script>
</body>
</html>
