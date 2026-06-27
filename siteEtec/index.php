<?php
$destaques = array(
    array('titulo' => 'Vestibulinho ETEC 2026', 'imagem' => 'imagens/etec.jpeg'),
    array('titulo' => 'Feira Tecnológica', 'imagem' => 'imagens/feira.jpg'),
    array('titulo' => 'Provão Paulista 2026', 'imagem' => 'imagens/provapaulista.png'),
    array('titulo' => 'AMS (Articulação Médio Técnico)', 'imagem' => 'imagens/ams.png')
);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ETEC Zona Leste - Centro Paula Souza</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="carrossel.css">
    <link rel="stylesheet" href="destaques.css">
</head>
<body>

<header>
    <div class="header-top">
        <div class="logo-section">
            <h1>ETEC Zona Leste</h1>
            <p>Centro Paula Souza</p>
        </div>
        <div class="header-contact">
            <span><a href="tel:+551120454000">(11) 2045-4000</a></span>
            <span><a href="mailto:dir.etezonaleste@centropaulasouza.sp.gov.br">dir.etezonaleste@centropaulasouza.sp.gov.br</a></span>
        </div>
    </div>
    <nav>
        <a href="index.php">Início</a>
        
        <div class="nav-item">
            <a href="cursos.html">Cursos</a>
            <div class="dropdown-menu">
                <a href="cursos.html#tecnicos">Cursos Técnicos - Modalidade Presencial</a>
                <a href="cursos.html#mtec">Ensino Médio Integrado ao Técnico (M-Tec)</a>
                <a href="cursos.html#ams">Articulação dos Ensinos Médios - Técnico e Superior (AMS)</a>
            </div>
        </div>
        
        <a href="inscricao.html">Inscrição</a>
        <a href="contato.php">Contato</a>
    </nav>
</header>

<div class="container">
    <section class="banner">
        <h2>Site oficial da ETEC Zona Leste</h2>
        <p>Educação Técnica de Qualidade para Transformar o Seu Futuro</p>
        <button onclick="document.getElementById('destaques-secao').scrollIntoView({behavior: 'smooth'})">Saiba Mais</button>
    </section>

    <!-- ===== CARROSSEL ===== -->
    <section id="destaques" class="carousel-section">
        <h2>Destaques da ETEC</h2>
        
        <div class="carousel-container">
            <button class="carousel-btn prev" onclick="mudarSlide(-1)">‹</button>
            
            <div class="carousel-wrapper">
                <div class="carousel-slides">
                    <div class="carousel-slide active">
                        <img src="imagens/lab.jpg" alt="Laboratório de Informática da ETEC">
                    </div>
                    
                    <div class="carousel-slide">
                        <img src="imagens/sala maker.jpg" alt="Sala de Aula Moderna">
                    </div>
                    
                    <div class="carousel-slide">
                        <img src="imagens/auditorio.jpeg" alt="Auditório">
                    </div>
                    
                    <div class="carousel-slide">
                        <img src="imagens/quadra.jpg" alt="Quadra de Esportes">
                    </div>

                    <div class="carousel-slide">
                        <img src="imagens/campus.jpg" alt="Campus da ETEC Zona Leste">
                    </div>
                </div>
            </div>
            
            <button class="carousel-btn next" onclick="mudarSlide(1)">›</button>
        </div>

        <div class="carousel-indicators">
            <span class="indicator active" onclick="irParaSlide(0)"></span>
            <span class="indicator" onclick="irParaSlide(1)"></span>
            <span class="indicator" onclick="irParaSlide(2)"></span>
            <span class="indicator" onclick="irParaSlide(3)"></span>
            <span class="indicator" onclick="irParaSlide(4)"></span>
        </div>
    </section>

    <!-- ===== DESTAQUES ===== -->
    <section id="destaques-secao" class="destaques-section">
        <h2>Destaques</h2>
        
        <div class="destaques-grid">
            <?php foreach($destaques as $destaque): ?>
            <div class="destaque-card">
                <div class="destaque-imagem">
                    <img src="<?php echo $destaque['imagem']; ?>" alt="<?php echo $destaque['titulo']; ?>">
                </div>
                <div class="destaque-titulo">
                    <h3><?php echo $destaque['titulo']; ?></h3>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- ===== CHAMADA PARA AÇÃO ===== -->
    <section style="text-align: center; margin-top: 50px; background: #f5f5f5; padding: 40px; border-radius: 3px;">
        <h2 style="color: #cf2e2e; border: none; padding: 0; text-align: center;">Comece sua Jornada Profissional</h2>
        <p style="font-size: 1.1em;">Inscreva-se agora em um de nossos cursos técnicos</p>
        <a href="inscricao.php" class="btn" style="font-size: 1.05em; padding: 15px 40px;">FAZER INSCRIÇÃO</a>
    </section>
</div>

<footer>
    <div class="footer-content">
        <div class="footer-section">
            <h3>Sobre</h3>
            <p>ETEC Zona Leste - Instituição de ensino técnico público mantida pelo Centro Paula Souza.</p>
            <p>Formando profissionais qualificados desde 2006.</p>
        </div>

        <div class="footer-section">
            <h3>Contato</h3>
            <p>📍 Avenida Águia de Haia, 2633</p>
            <p>Cidade AE Carvalho - São Paulo, SP - CEP: 03694-000</p>
            <p>📞 <a href="tel:+551120454000">(11) 2045-4000</a></p>
            <p>📧 <a href="mailto:dir.etezonaleste@centropaulasouza.sp.gov.br">dir.etezonaleste@centropaulasouza.sp.gov.br</a></p>
        </div>

        <div class="footer-section">
            <h3>Links Úteis</h3>
            <p><a href="cursos.html">Nossos Cursos</a></p>
            <p><a href="https://www.cps.sp.gov.br" target="_blank">Centro Paula Souza</a></p>
            <p><a href="contato.php">Fale Conosco</a></p>
        </div>
    </div>
    
    <div class="footer-bottom">
        <p>© 2026 ETEC Zona Leste - Centro Paula Souza | Todos os direitos reservados</p>
    </div>
</footer>

<script src="carroussel.js"></script>
</body>
</html>