<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--TELEGRAM API-->
    <link rel="canonical" href="%page_url%">
    <!--FACEBOOK API-->
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/es_ES/sdk.js#xfbml=1&version=v15.0" nonce="xMZVdb5A"></script>
    <!--WHATSAPP SCRIPT-->
    <script>
        const $btnCompartir = document.querySelector("#btnCompartir"),
    	$texto = document.querySelector("#texto");
        $btnCompartir.addEventListener("click", () => {
    	let mensaje = $texto.value;
    	if (!mensaje) return alert("Escribe algo");
    	window.open("https://api.whatsapp.com/send?text=" + encodeURIComponent(mensaje));
        });
    </script>
    <!-- Google Tag Manager -->
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-MB7HJ8K');</script>
	<!-- End Google Tag Manager -->
     
	<link rel="stylesheet" href="aviso-cookies-master/css/estilos.css">
    <link rel="stylesheet" href="./css/bootstrap.min5.css">
    <title>Libreria</title>
</head>

<body>
    <nav class="navbar navbar-expand navbar-dark bg-primary">
        <ul class="nav navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="index"><h5>Inicio</h5></a>
            </li> 
            <li class="nav-item">
                <a class="nav-link" href="libros">Libros</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="cursos">Cursos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="certificaciones">Certificados</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="tutoriales">Tutoriales</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="nosotros">Nosotros</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="foro">Foro</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../proyecto/administrador/index" target="_blank">Login</a>
            </li>
        </ul>
    </nav>

    <div class="aviso-cookies" id="aviso-cookies">
		<img class="galleta" src="aviso-cookies-master/img/cookie.svg" alt="Galleta">
		<h3 class="titulo" style="color: #333;">Cookies</h3>
		<p class="parrafo" style="color: #333;">Utilizamos cookies propias y de terceros para mejorar nuestros servicios.</p>
		<button class="boton" id="btn-aceptar-cookies">De acuerdo</button>
		<a class="enlace" href="aviso-cookies-master/aviso-cookies" style="color: #333;">Aviso de Cookies</a>
	</div>
	<div class="fondo-aviso-cookies" id="fondo-aviso-cookies"></div>

	<script src="aviso-cookies-master/js/aviso-cookies.js"></script>

    <div class="container"><br>
        <div class="row">   