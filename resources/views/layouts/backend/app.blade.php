<!DOCTYPE html>

<html
    lang="en"
    class="light-style layout-menu-fixed"
    dir="ltr"
    data-theme="theme-default"
    data-template="vertical-menu-template-free"
>
<head>
    <meta charset="utf-8"/>
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />
    <title>Inventory || @yield('title')</title>
    <meta name="description" content=""/>
    @include('layouts.backend.css')
    @routes
    @vite(['resources/js/app.js'])

</head>
<body>
<div class="layout-wrapper layout-content-navbar">
    @include('sweetalert::alert', ['cdn' => "https://cdn.jsdelivr.net/npm/sweetalert2@9"])
    <div class="layout-container">
        @include('layouts.backend.sidebar')
        <div class="layout-page">
            @include('layouts.backend.header')
            <div class="content-wrapper">
                <!-- Content -->
                <div class="container-xxl flex-grow-1 container-p-y">
                    @yield('content')
                </div>
                @include('layouts.backend.footer')
                <div class="content-backdrop fade"></div>
            </div>
        </div>
    </div>
    <div class="layout-overlay layout-menu-toggle"></div>
</div>
@include('layouts.backend.js')
</body>
</html>
