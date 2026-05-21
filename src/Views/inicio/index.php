<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda Online - Inicio</title>
    <link rel="icon" href="img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.7.0/remixicon.css">
    <link rel="stylesheet" href="<?=BASE_URL?>public/css/inicio.css">
    <link rel="stylesheet" href="<?=BASE_URL?>public/css/footer.css">
</head>
<body>

<section>
    <h1 class="highlighted-title">Productos Destacados</h1>
    <div class="product-carousel">
        <div class="carousel-tracks">
            <?php foreach ($productos as $producto): ?>
                <div class="carousel-item" id="item-<?= $producto['id'] ?>">
                    <a href="<?=BASE_URL?>producto/verDetalles/?id=<?=$producto['id']?>">
                        <img src="<?=BASE_URL?>public/img/<?=$producto['imagen']?>" alt="<?=$producto['nombre']?>" class="product-image">
                        <h3 class="product-name"><?=$producto['nombre']?></h3>
                        <h2 class="product-price"><?=$producto['precio']?>€</h2>
                    </a>
                </div>
            <?php endforeach;?>
        </div>
        <button class="carousel-prev" onclick="changeSlide(-1)" aria-label="Anterior">&#10094;</button>
        <button class="carousel-next" onclick="changeSlide(1)" aria-label="Siguiente">&#10095;</button>
        <div class="carousel-indicators">
            <?php foreach ($productos as $index => $producto): ?>
                <div class="carousel-dot <?= $index === 0 ? 'active' : '' ?>" onclick="goToSlide(<?=$index?>)"></div>
            <?php endforeach;?>
        </div>
    </div>
</section>

<!-- Sección de Bienvenida e Información -->
<section class="welcome-section">
    <div class="welcome-content">
        <h1 class="welcome-title">Bienvenido a Tienda Online</h1>
        <p class="welcome-subtitle">Tu destino de compras favorito</p>
        <div class="welcome-text">
            <p>
                En <strong>Tienda Online</strong>, nos complace ofrecerte una experiencia de compra excepcional. 
                Nuestro catálogo completo incluye una amplia variedad de productos de calidad, desde los más populares 
                hasta las últimas tendencias del mercado.
            </p>
            <p>
                Nos caracterizamos por:
            </p>
            <ul class="features-list">
                <li><i class="ri-check-line"></i> <strong>Calidad Garantizada:</strong> Todos nuestros productos son seleccionados cuidadosamente</li>
                <li><i class="ri-check-line"></i> <strong>Precios Competitivos:</strong> Ofertas especiales y descuentos exclusivos</li>
                <li><i class="ri-check-line"></i> <strong>Envíos Rápidos:</strong> Entrega segura y puntual a tu domicilio</li>
                <li><i class="ri-check-line"></i> <strong>Atención al Cliente:</strong> Equipo disponible para resolver tus dudas</li>
                <li><i class="ri-check-line"></i> <strong>Compra Segura:</strong> Sistemas de pago encriptados y confiables</li>
            </ul>
            <p>
                Explora nuestras categorías, descubre productos increíbles y disfruta de una experiencia de compra 
                sin complicaciones. ¡Gracias por confiar en nosotros!
            </p>
        </div>
    </div>
</section>

<!-- Sección de Call to Action -->
<section class="cta-section">
    <div class="cta-content">
        <h2>¿Listo para comprar?</h2>
        <p>Únete a miles de clientes satisfechos y disfruta de la mejor experiencia de compra</p>
        <div class="cta-buttons">
            <?php if (!isset($_SESSION['login'])): ?>
                <a href="<?=BASE_URL?>usuario/registro/" class="btn-primary">
                    <i class="ri-user-add-line"></i> Crear Cuenta Gratis
                </a>
            <?php endif; ?>
            <a href="<?=BASE_URL?>categoria/ver/?id=1" class="btn-secondary">
                <i class="ri-shopping-cart-line"></i> Explorar Tienda
            </a>
        </div>
    </div>
</section>

<!-- Sección de Beneficios -->
<section class="benefits-section">
    <h2 class="section-title">¿Por qué comprar con nosotros?</h2>
    <div class="benefits-grid">
        <div class="benefit-card">
            <div class="benefit-icon">
                <i class="ri-truck-line"></i>
            </div>
            <h3>Envío Gratis</h3>
            <p>Compras mayores a 50€ con envío directo a tu puerta</p>
        </div>
        <div class="benefit-card">
            <div class="benefit-icon">
                <i class="ri-shield-check-line"></i>
            </div>
            <h3>100% Seguro</h3>
            <p>Pago encriptado y garantía de protección de datos</p>
        </div>
        <div class="benefit-card">
            <div class="benefit-icon">
                <i class="ri-customer-service-2-line"></i>
            </div>
            <h3>Soporte 24/7</h3>
            <p>Equipo disponible para ayudarte en cualquier momento</p>
        </div>
        <div class="benefit-card">
            <div class="benefit-icon">
                <i class="ri-loop-left-line"></i>
            </div>
            <h3>Devoluciones Fáciles</h3>
            <p>Devuelve tu compra en 30 días sin complicaciones</p>
        </div>
    </div>
</section>

<!-- Sección de Testimonios -->
<section class="testimonials-section">
    <h2 class="section-title">Lo que dicen nuestros clientes</h2>
    <div class="testimonials-grid">
        <div class="testimonial-card">
            <div class="stars">
                <i class="ri-star-fill"></i>
                <i class="ri-star-fill"></i>
                <i class="ri-star-fill"></i>
                <i class="ri-star-fill"></i>
                <i class="ri-star-fill"></i>
            </div>
            <p>"Excelente servicio, productos de calidad y envío muy rápido. ¡Recomendado!"</p>
            <h4>María García</h4>
            <span>Cliente verificado</span>
        </div>
        <div class="testimonial-card">
            <div class="stars">
                <i class="ri-star-fill"></i>
                <i class="ri-star-fill"></i>
                <i class="ri-star-fill"></i>
                <i class="ri-star-fill"></i>
                <i class="ri-star-fill"></i>
            </div>
            <p>"La mejor tienda online que he encontrado. Precio, calidad y atención al cliente perfectos."</p>
            <h4>Juan López</h4>
            <span>Cliente verificado</span>
        </div>
        <div class="testimonial-card">
            <div class="stars">
                <i class="ri-star-fill"></i>
                <i class="ri-star-fill"></i>
                <i class="ri-star-fill"></i>
                <i class="ri-star-fill"></i>
                <i class="ri-star-fill"></i>
            </div>
            <p>"Muy satisfecho con mi compra. El proceso es simple y seguro. Volveré a comprar."</p>
            <h4>Ana Rodríguez</h4>
            <span>Cliente verificado</span>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let currentIndex = 0;
        const slides = document.querySelectorAll('.carousel-item');
        const totalSlides = slides.length;
        const dots = document.querySelectorAll('.carousel-dot');
        const track = document.querySelector('.carousel-tracks');

        function updateCarousel() {
            track.style.transform = `translateX(-${currentIndex * 100}%)`;
            
            dots.forEach((dot, index) => {
                if (index === currentIndex) {
                    dot.classList.add('active');
                } else {
                    dot.classList.remove('active');
                }
            });
        }

        function changeSlide(direction) {
            currentIndex += direction;
            if (currentIndex >= totalSlides) {
                currentIndex = 0;
            } else if (currentIndex < 0) {
                currentIndex = totalSlides - 1;
            }
            updateCarousel();
        }

        window.changeSlide = changeSlide;

        window.goToSlide = function(index) {
            currentIndex = index;
            updateCarousel();
        };

        // Auto-advance carousel cada 8 segundos
        setInterval(() => {
            changeSlide(1);
        }, 8000);

        updateCarousel();
    });
</script>

</body>
</html>