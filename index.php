<?php $titulo = 'Início'; include 'includes/cabecalho.php'; ?>

<section class="hero">
    <div class="hero-bg-image"></div>
    <div class="container">
        <div class="hero-content" data-animar>
            <div class="hero-tag">&#9733; Delivery - Campo Grande, MS</div>
            <h1 class="hero-title">A verdadeira<br><span>pizza artesanal</span><br>é aqui</h1>
            <p class="hero-sub">Massa fermentada por 48 horas, forno a lenha e ingredientes selecionados. Desde 2010 levando o sabor da Itália até sua mesa.</p>
            <div class="hero-actions">
                <a href="pedidos.php" class="btn btn-primary">Fazer Pedido</a>
                <a href="cardapio.php" class="btn btn-outline">Ver Cardápio</a>
            </div>
            <div class="hero-metrics">
                <div class="metric-item">
                    <div class="metric-val">15+</div>
                    <div class="metric-label">Sabores exclusivos</div>
                </div>
                <div class="metric-item">
                    <div class="metric-val">4.9</div>
                    <div class="metric-label">Avaliação dos clientes</div>
                </div>
                <div class="metric-item">
                    <div class="metric-val">50k+</div>
                    <div class="metric-label">Pizzas entregues</div>
                </div>
                <div class="metric-item">
                    <div class="metric-val">45min</div>
                    <div class="metric-label">Tempo de entrega</div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="promos">
    <div class="container">

        <div class="section-header">
            <span class="section-tag">Promoções imperdíveis</span>
            <h2>Sabores que <span>encantam</span> todo dia</h2>
            <p>Pizzas premium com preços que cabem no seu bolso. Aproveite as ofertas da semana.</p>
        </div>

        <div class="promo-grid">

            <div class="promo-card">
                <div class="promo-img">
                    <img src="https://images.unsplash.com/photo-1513104890138-7c749659a591?w=600&q=80" alt="Margherita Clássica" loading="lazy">
                    <span class="promo-badge">-30%</span>
                </div>
                <div class="promo-body">
                    <h3>Margherita Tradicional</h3>
                    <p>Molho de tomate fresco, mussarela de búfala e manjericão. A receita original italiana.</p>
                    <div class="promo-prices">
                        <span class="promo-old">R$ 49,90</span>
                        <span class="promo-new">R$ 34,90</span>
                    </div>
                    <a href="pedidos.php" class="promo-cta">Pedir agora</a>
                </div>
            </div>

            <div class="promo-card destaque">
                <div class="promo-img">
                    <img src="https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?w=600&q=80" alt="Calabresa Premium" loading="lazy">
                    <span class="promo-badge">Mais pedida</span>
                </div>
                <div class="promo-body">
                    <h3>Calabresa Premium</h3>
                    <p>Calabresa artesanal defumada, cebola roxa, mussarela e pimenta calabresa.</p>
                    <div class="promo-prices">
                        <span class="promo-old">R$ 54,90</span>
                        <span class="promo-new">R$ 39,90</span>
                    </div>
                    <a href="pedidos.php" class="promo-cta">Pedir agora</a>
                </div>
            </div>

            <div class="promo-card">
                <div class="promo-img">
                    <img src="https://images.unsplash.com/photo-1574071318508-1cdbab80d002?w=600&q=80" alt="Frango Especial" loading="lazy">
                    <span class="promo-badge">-25%</span>
                </div>
                <div class="promo-body">
                    <h3>Frango Especial</h3>
                    <p>Frango desfiado temperado, catupiry cremoso, milho verde e azeitonas.</p>
                    <div class="promo-prices">
                        <span class="promo-old">R$ 57,90</span>
                        <span class="promo-new">R$ 43,90</span>
                    </div>
                    <a href="pedidos.php" class="promo-cta">Pedir agora</a>
                </div>
            </div>

        </div>

        <div class="promo-note">
            <p>Ofertas válidas de <strong>segunda a sexta, das 18h às 22h</strong>. Peça já a sua!</p>
            <a href="cardapio.php" class="btn-more">Cardápio completo</a>
        </div>

    </div>
</section>

<?php include 'includes/rodape.php'; ?>
