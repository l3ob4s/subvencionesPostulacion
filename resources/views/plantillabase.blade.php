<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>Postulaci&oacute;n Subvenciones-Gobierno Regional del Bío Bío</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Google Tag Manager -->
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-KDXMC89');
    </script>
    <!-- End Google Tag Manager -->


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,300;0,400;0,500;1,100;1,200;1,300;1,500&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
   

    <link href="{{ asset('css/wizard.css') }}" rel="stylesheet" id="bootstrap-css">
    @livewireStyles
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Begin Tippy Optional -->
    <!-- <link rel="stylesheet" href="https://unpkg.com/tippy.js@6/animations/scale.css" /> -->
    <link rel="stylesheet" href="https://unpkg.com/tippy.js@6/animations/scale-extreme.css" />
    <script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.min.js"></script>
    <script src="https://unpkg.com/tippy.js@6/dist/tippy-bundle.umd.js"></script>
    <!-- End Tippy Optional -->

    <!-- Autor: Mario Villalobos P.
             Correo: mvillalobos@gorebiobio.cl           
             Fecha de creación: 10-06-2022
             Ultima Modificación: 24-07-2022 MVillalobos
             Objetivo: Postulación Subvenciones
             Unidad: Informática-->

    <style>
        /* Customizing Sweet Alert */
        .swal2-popup {
            font-size: 1rem;
            font-family: 'Poppins', sans-serif;
            font-weight: 200;
        }

        .swal2-title {
            font-weight: normal;
        }

        /* Ocultar Flechas input number */
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }

        /* Type date onlick event hidden calendar icon  */
        input[type="date"]::-webkit-calendar-picker-indicator {
            background: transparent;
            bottom: 0;
            color: transparent;
            cursor: pointer;
            height: auto;
            left: 0;
            position: absolute;
            right: 0;
            top: 0;
            width: auto;
        }
    </style>

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-180449242-3"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-180449242-3');
    </script>

</head>

<body style="font-family: 'Poppins', sans-serif;">
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KDXMC89" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->


    <div class="container-md px-3">
        <div id="banner01" class="row mt-0 ms-0 me-0 mb-4 ms-sm-0 me-sm-0 mb-sm-4 ms-md-0 me-md-0 mb-md-5 shadow" style="background-image: url('images/panoramica.jpg');background-size:cover;">
            <div class="col-3 ps-3 py-3 align-self-center col-sm-2 py-sm-4 ps-sm-5">
                <a title="Volver a www.gorebiobio.cl" href="https://sitio.gorebiobio.cl">
                    <img src="{{ asset('images/logo-header-200x300.png') }}" width="110" height="170">
                </a>
            </div>
        </div>
        <div class="card shadow" id="cabecera">
            <div class="card-header text-center h4 py-3">
                Postulaci&oacute;n de iniciativas Fondos concursables FNDR 
            </div>
            <div class="card-body">
                 <livewire:postulacionsubvenciones /> 
            </div>
        </div>
    </div>
    <br>
  <div class="text-center mx-5 mb-4 mt-5 mb-5 text-secondary">
    <hr>
    <span class="d-block">© {{ \Carbon\Carbon::parse(Carbon\Carbon::now())->format('Y')}} Postulación Subvenciones - Desarrollo Interno Unidad de Informática.</span>
    <span class="d-block py-2">Gobierno Regional del Biobío - Avenida Prat 525 - Mesa Central 56-41-2405700 - Concepción, Región del Biobío, Chile.</span>
    <hr>
  </div>
  <br><br><br><br>

    @livewireScripts

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

    <!-- Atomic tippyjs -->
    <!-- <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="https://unpkg.com/tippy.js@6"></script> -->
    <script>
        // function toolTipDisplay(id, mensaje) {
        //     tippy(id, {
        //         //theme: 'light',
        //         touch: true, //Habilita Toolstips para moviles
        //         animation: 'scale-extreme',
        //         placement: 'bottom',
        //         //followCursor: true,
        //         allowHTML: true,
        //         content: decodeHTML(mensaje),
        //         duration: 450, //Tiempo que se demora el despliegue
        //         delay: 500, //Tiempo que se demora en aparecer
        //     });
        // }

        //InputStr =  &amp;lt;i class=&amp;#039;bi bi-calendar&amp;#039;&amp;gt;&amp;lt;/i&amp;gt;
        // function decodeHTML(inputStr) {
        //     var textarea = document.createElement("textarea");
        //     textarea.innerHTML = inputStr;
        //     return textarea.value;
        // }

        // tippy('#fecVencDirectiva', {
        //     touch: false, //Deshabilita Toolstips para moviles
        //     animation: 'scale-extreme',
        //     placement: 'bottom',
        //     allowHTML: true,
        //     content: 'Haga Click sobre el icono <i class="bi bi-calendar"></i> de la derecha para desplegar calendario.',
        //     duration: 450, //Tiempo que se demora el despliegue
        //     delay: 500, //Tiempo que se demora en aparecer
        // });


        // tippy('[data-tippy-content]', {
        //     touch: true, //Habilita Toolstips para moviles
        //     animation: 'scale-extreme',
        //     placement: 'bottom',
        //     duration: 450, //Tiempo que se demora el despliegue
        //     delay: 500, //Tiempo que se demora en aparecer
        // });
    </script>
</body>

</html>