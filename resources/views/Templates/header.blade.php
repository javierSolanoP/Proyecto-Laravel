<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Page style-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="@yield('style')">
    <!--Font style-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@1,300&display=swap&family=Pinyon+Script&display=swap&family=STIX+Two+Math&display=swap" rel="stylesheet">
    <title>Shoes Shop</title>
</head>
<body>
    <header id="header" class="sticky-top">
        <nav>
            <div class="Container-Logo" class="navbar btn-warning">
                <img src="./img/logo.png" class="Logo" alt="Logotipo">
                <p class="Name-Shop" id="nameShop">The Dandi's Shop</p>
            </div>
            <ul>
                <li class="nav-item dropdown">
                    <button class="nav-link dropdown-toggle">Home</button>
                </li>
                <li>
                    <a href="" class="item">Tienda</a>
                </li>
                <li>
                    <a href="" class="item">Sobre nosotros</a>
                </li>
                <li>
                    <a href="" class="item">Blog</a>
                </li>
                <li>
                    <a href="" class="item">Portafolio</a>
                </li>
                <li>
                    <a href="" class="item">Galería</a>
                </li>
                <li>
                    <a href="" class="item">Contacto</a>
                </li>
                <li>
                    <button class="Search">
                        <img src="./img/search.png" alt="Buscador">
                    </button>
                </li>
                <li>
                    <p class="item-p">♥</p>
                </li>
                <li>
                    <p class="item-p money">COP$0</p>
                </li>
                <li>
                    <button class="buy">
                        <img src="./img/buy.png" alt="Compra">
                    </button>
                    <p class="number">3</p>
                </li>
                <li>
                    <button class="menu">
                        <img src="./img/menu.png" alt="menu">
                    </button>
                </li>
            </ul>
        </nav>
    </header>
    <article class="@yield('articleClass')">@yield('article')</article>
    <footer>@yield('footer')</footer>
</body>
</html>