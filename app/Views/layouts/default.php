<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link
            href="https://fonts.googleapis.com/css?family=Playfair+Display:700,900&display=swap"
            rel="stylesheet"
    />
    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        .b-example-divider {
            width: 100%;
            height: 3rem;
            background-color: #0000001a;
            border: solid rgba(0, 0, 0, 0.15);
            border-width: 1px 0;
            box-shadow: inset 0 0.5em 1.5em #0000001a,
            inset 0 0.125em 0.5em #00000026;
        }

        .b-example-vr {
            flex-shrink: 0;
            width: 1.5rem;
            height: 100vh;
        }

        .bi {
            vertical-align: -0.125em;
            fill: currentColor;
        }

        .nav-scroller {
            position: relative;
            z-index: 2;
            height: 2.75rem;
            overflow-y: hidden;
        }

        .nav-scroller .nav {
            display: flex;
            flex-wrap: nowrap;
            padding-bottom: 1rem;
            margin-top: -1px;
            overflow-x: auto;
            text-align: center;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
        }

        .btn-bd-primary {
            --bd-violet-bg: #712cf9;
            --bd-violet-rgb: 112.520718, 44.062154, 249.437846;
            --bs-btn-font-weight: 600;
            --bs-btn-color: var(--bs-white);
            --bs-btn-bg: var(--bd-violet-bg);
            --bs-btn-border-color: var(--bd-violet-bg);
            --bs-btn-hover-color: var(--bs-white);
            --bs-btn-hover-bg: #6528e0;
            --bs-btn-hover-border-color: #6528e0;
            --bs-btn-focus-shadow-rgb: var(--bd-violet-rgb);
            --bs-btn-active-color: var(--bs-btn-hover-color);
            --bs-btn-active-bg: #5a23c8;
            --bs-btn-active-border-color: #5a23c8;
        }

        .bd-mode-toggle {
            z-index: 1500;
        }

        .bd-mode-toggle .bi {
            width: 1em;
            height: 1em;
        }

        .bd-mode-toggle .dropdown-menu .active .bi {
            display: block !important;
        }
    </style>
    <style>
        /* stylelint-disable @stylistic/selector-list-comma-newline-after */

        .blog-header-logo {
            font-family: "Playfair Display", Georgia, "Times New Roman", serif /*rtl:Amiri, Georgia, "Times New Roman", serif*/;
            font-size: 2.25rem;
        }

        .blog-header-logo:hover {
            text-decoration: none;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: "Playfair Display", Georgia, "Times New Roman", serif /*rtl:Amiri, Georgia, "Times New Roman", serif*/;
        }

        .flex-auto {
            flex: 0 0 auto;
        }

        .h-250 {
            height: 250px;
        }

        @media (min-width: 768px) {
            .h-md-250 {
                height: 250px;
            }
        }

        /* Pagination */
        .blog-pagination {
            margin-bottom: 4rem;
        }

        /*
         * Blog posts
         */
        .blog-post {
            margin-bottom: 4rem;
        }

        .blog-post-meta {
            margin-bottom: 1.25rem;
            color: #727272;
        }

    </style>
</head>
<body>

<div class="container">
    <header class="border-bottom lh-1 py-3">
        <div class="row flex-nowrap justify-content-between align-items-center">
            <div class="col-6">
                <a class="blog-header-logo text-body-emphasis text-decoration-none"
                   href="#">Large</a>
            </div>
            <div class="col-6 d-flex gap-3 justify-content-end align-items-center">
                <a class="btn btn-sm btn-outline-secondary" href="<?= baseUrl('/register') ?>">Sign up</a>
                <a class="btn btn-sm btn-outline-secondary" href="<?= baseUrl('/login') ?>">Login</a>
            </div>
        </div>
    </header>
    <div class="nav-scroller py-1 mb-3 border-bottom">
        <nav class="nav nav-underline justify-content-between">
            <a class="nav-item nav-link link-body-emphasis active" href="#">World</a>
            <a class="nav-item nav-link link-body-emphasis" href="#">U.S.</a>
            <a class="nav-item nav-link link-body-emphasis" href="#">Technology</a>
            <a class="nav-item nav-link link-body-emphasis" href="#">Design</a>
            <a class="nav-item nav-link link-body-emphasis" href="#">Culture</a>
            <a class="nav-item nav-link link-body-emphasis" href="#">Business</a>
            <a class="nav-item nav-link link-body-emphasis" href="#">Politics</a>
            <a class="nav-item nav-link link-body-emphasis" href="#">Opinion</a>
            <a class="nav-item nav-link link-body-emphasis" href="#">Science</a>
            <a class="nav-item nav-link link-body-emphasis" href="#">Health</a>
            <a class="nav-item nav-link link-body-emphasis" href="#">Style</a>
            <a class="nav-item nav-link link-body-emphasis" href="#">Travel</a>
        </nav>
    </div>
</div>

<?php getAlerts(); ?>

<?= $this->content ?>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>

</body>
</html>