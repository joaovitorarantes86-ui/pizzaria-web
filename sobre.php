<?php $titulo = 'Sobre'; include 'includes/cabecalho.php'; ?>

<section style="padding-top: 80px;">
    <div class="container">
        <div class="sobre-grid">
            <div class="sobre-texto" data-animar>
                <h2>Nossa <span>História</span></h2>
                <p>Fundada em 2010 por uma família italiana, a Arantes Pizzaria nasceu da paixão pela culinária tradicional. Cada pizza é preparada com ingredientes frescos selecionados diariamente, seguindo receitas passadas de geração em geração.</p>
                <p>Nosso forno a lenha e a massa fermentada por 48 horas garantem aquele sabor único que nossos clientes amam. Mais de 50 mil pizzas entregues com orgulho por Campo Grande!</p>
                <a href="pedidos.php" class="btn btn-primary" style="display: inline-block; margin-top: 8px;">Peça a sua agora</a>
            </div>
            <div class="sobre-img" data-animar>
                <img src="https://images.unsplash.com/photo-1555396273-367ea4eb4db5?w=600&q=80"
                     alt="Pizzaria"
                     loading="lazy"
                     style="width:100%;border-radius:var(--radius-lg);box-shadow:var(--shadow-lg);">
            </div>
        </div>

        <div class="sobre-stats" data-animar style="margin-top:48px;">
            <div class="stat-box">
                <div class="num">+15</div>
                <p>Sabores disponíveis</p>
            </div>
            <div class="stat-box">
                <div class="num">45min</div>
                <p>Tempo médio de entrega</p>
            </div>
            <div class="stat-box">
                <div class="num">50k+</div>
                <p>Pizzas entregues</p>
            </div>
            <div class="stat-box">
                <div class="num">4.9</div>
                <p>Avaliação no Google</p>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/rodape.php'; ?>
