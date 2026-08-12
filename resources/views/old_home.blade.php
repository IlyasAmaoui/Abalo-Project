<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title . ' - Abalo' : 'Abalo' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    @vite(['resources/css/app.css'])
    @vite('resources/js/app.js')
</head>


<body>
<!-- Navigation -->
<nav id="main-navigation"></nav>



<!-- Searchbar -->
<div class="container my-5">
    <div id="search-app" class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <!-- Search Input -->
            <div class="input-group mb-3 shadow-sm">
                <input
                    type="text"
                    v-model="searchQuery"
                    @input="onSearchInput"
                    placeholder="Suche Artikel..."
                    class="form-control form-control-lg border-primary"
                >
                <span class="input-group-text bg-primary text-white">
                    <i class="bi bi-search"></i>
                </span>
            </div>

            <!-- Search Results -->
            <div v-if="results.length > 0" class="card shadow-sm">
                <div class="card-body">
                    <h3 class="h5 card-title">Suchergebnisse (Top 5):</h3>
                    <ul class="list-group list-group-flush">
                        @verbatim
                            <li v-for="article in results" v-bind:key="article.id"
                                class="list-group-item list-group-item-action">
                                {{ article.ab_name }}
                            </li>
                        @endverbatim
                    </ul>
                </div>
            </div>

            <!-- No Results -->
            <div v-else-if="searchQuery.length >= 3 && !isLoading"
                 class="alert alert-info mt-3 shadow-sm">
                Keine Ergebnisse gefunden
            </div>
        </div>
    </div>
</div>



<!-- warencorb -->
<button class="btn btn-primary position-fixed end-0 top-50 translate-middle-y me-3"
        type="button"
        data-bs-toggle="offcanvas"
        data-bs-target="#cartOffcanvas"
        style="z-index: 1000">
    🛒 Warenkorb
    <span id="cartBadge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
        0
    </span>
</button>

<!-- Offcanvas Cart -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="cartOffcanvas">
    <div class="offcanvas-header">
        <h2 class="offcanvas-title">Warenkorb</h2>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
        <div id="warenkorb" class="list-group">
            <p class="text-muted">Keine Artikel im Warenkorb.</p>
        </div>
        <div class="d-grid gap-2 mt-3">
            <button class="btn btn-success">Zur Kasse gehen</button>
        </div>
    </div>
</div>

<!-- Articles -->
<h2>Artikelliste</h2>
<div class="d-flex flex-wrap justify-content-start gap-4 ml-4">
    @foreach ($articles as $article)
        <div class="card" style="width: 16rem;">
            @php
                $imagePathJpg = public_path("articelimages/{$article->id}.jpg");
                $imagePathPng = public_path("articelimages/{$article->id}.png");
                $imgSrc = null;

                if (file_exists($imagePathJpg)) {
                    $imgSrc = asset("articelimages/{$article->id}.jpg");
                } elseif (file_exists($imagePathPng)) {
                    $imgSrc = asset("articelimages/{$article->id}.png");
                }
            @endphp
            @if ($imgSrc)
                <img class="card-img-top img-fluid" style="height: 180px; object-fit: contain;" src="{{ $imgSrc }}" alt="Card image cap">
            @else
                <div class="card-img-top d-flex align-items-center justify-content-center bg-light" style="height: 180px;">
                    Kein Bild
                </div>
            @endif

            <div class="card-body">
                <h5 class="card-title text-truncate">{{ $article->ab_name }}</h5>
                <p class="card-text text-truncate">{{ $article->ab_description }}</p>
                <h6 class="card-title">{{ $article->ab_price }} €</h6>
                <button class="btn btn-primary w-100" onclick="cartload({{$article->id}})">add 🛒</button>
            </div>
        </div>
    @endforeach
</div>




<script>
    function cartload(articleId) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '/api/shoppingcart', true);
        xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
        xhr.setRequestHeader('Content-Type', 'application/json');

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                if (xhr.status === 201) {
                    loadCart();
                    // Show the cart when item is added
                    const offcanvas = new bootstrap.Offcanvas(document.getElementById('cartOffcanvas'));
                    offcanvas.show();
                } else {
                    alert(' Fehler beim Hinzufügen: ' + xhr.responseText);
                }
            }
        };

        xhr.send(JSON.stringify({ article_id: articleId }));
    }

    function removeFromCart(cartId, articleId) {
        const xhr = new XMLHttpRequest();
        xhr.open("DELETE", `/api/shoppingcart/${cartId}/articles/${articleId}`, true);
        xhr.setRequestHeader("Content-Type", "application/json");
        xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

        xhr.onload = function () {
            if (xhr.status === 200) {
                loadCart();
            } else {
                alert(" Fehler beim Entfernen: " + xhr.responseText);
            }
        };
        xhr.send(JSON.stringify({}));
    }

    function loadCart() {
        const xhr = new XMLHttpRequest();
        xhr.open("GET", "/api/shoppingcarte", true);

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                const cartItems = JSON.parse(xhr.responseText);
                const cartContainer = document.getElementById("warenkorb");
                const cartBadge = document.getElementById("cartBadge");
                cartContainer.innerHTML = "";

                if (cartItems.length === 0) {
                    cartContainer.innerHTML = '<p class="text-muted">Keine Artikel im Warenkorb.</p>';
                    cartBadge.textContent = '0';
                    cartBadge.classList.add('d-none');
                    return;
                }

                cartBadge.textContent = cartItems.length;
                cartBadge.classList.remove('d-none');

                cartItems.forEach(item => {
                    const cartItem = document.createElement("div");
                    cartItem.className = "list-group-item d-flex justify-content-between align-items-center";
                    cartItem.innerHTML = `
                        <div>
                            <h6 class="my-0">${item.ab_name}</h6>
                            <small class="text-muted">${item.ab_price} €</small>
                        </div>
                        <button class="btn btn-outline-danger btn-sm"
                                onclick="removeFromCart(${item.ab_shoppingcart_id}, ${item.id})">
                            🗑️
                        </button>
                    `;
                    cartContainer.appendChild(cartItem);
                });
            }
        };

        xhr.send();
    }

    window.addEventListener("load", loadCart);
</script>

<footer class="footer footer-center p-5 bg-base-300 text-base-content text-xs">
    <div>
        <p>© 2026 Abalo - Built with Laravel and ❤️</p>
    </div>
</footer>
</body>
</html>
