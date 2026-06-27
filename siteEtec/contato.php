<?php

$mensagemSucesso = '';
$mensagemErro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = htmlspecialchars(trim($_POST['nome'] ?? ''));
    $email = htmlspecialchars(trim($_POST['email'] ?? ''));
    $mensagem = htmlspecialchars(trim($_POST['mensagem'] ?? ''));

    if (empty($nome) || empty($email) || empty($mensagem)) {
        $mensagemErro = 'Por favor, preencha todos os campos obrigatórios.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mensagemErro = 'Por favor, insira um email válido.';
    } else {
        $mensagemSucesso = 'Mensagem Enviada com Sucesso! Entraremos em contato em breve.';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contato - ETEC Zona Leste</title>
    <link rel="stylesheet" href="style.css">
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
        <a href="index.html">Início</a>
       
        <div class="nav-item">
            <a href="cursos.html">Cursos</a>
            <div class="dropdown-menu">
                <a href="cursos.html#tecnicos">Cursos Técnicos - Modalidade Presencial</a>
                <a href="cursos.html#mtec">Ensino Médio Integrado ao Técnico (M-Tec)</a>
                <a href="cursos.html#ams">Articulação dos Ensinos Médios - Técnico e Superior (AMS)</a>
            </div>
        </div>
        
        <a href="inscricao.php">Inscrição</a>
        <a href="contato.php">Contato</a>
    </nav>
</header>

<div class="container">
    <h2>Fale Conosco</h2>
    <p style="margin-bottom: 30px;">
        Tem dúvidas sobre nossos cursos ou precisa de informações? Entre em contato conosco! 
        Responderemos o mais breve possível.
    </p>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 40px;">
        <!-- Informações de Contato -->
        <div>
            <h3 style="color: #B20000; margin-bottom: 20px; margin-top: 0;">Informações de Contato</h3>
            
            <div class="card" style="margin: 15px 0;">
                <h4 style="color: #B20000; margin-top: 0;">Endereço</h4>
                <p style="margin: 0;">Avenida Águia de Haia, 2633<br>Cidade AE Carvalho - São Paulo, SP<br>CEP: 03694-000</p>
            </div>

            <div class="card" style="margin: 15px 0;">
                <h4 style="color: #B20000; margin-top: 0;">Telefone</h4>
                <p style="margin: 0;"><strong><a href="tel:+551120454000" style="color: #B20000; text-decoration: none;">(11) 2045-4000</a></strong></p>
                <p style="margin: 5px 0 0 0; font-size: 0.9em; color: #999;">Segunda a sexta: 9h às 21h</p>
            </div>

            <div class="card" style="margin: 15px 0;">
                <h4 style="color: #B20000; margin-top: 0;">Email</h4>
                <p style="margin: 0;"><a href="mailto:dir.etezonaleste@centropaulasouza.sp.gov.br" style="color: #B20000; text-decoration: none;">dir.etezonaleste@centropaulasouza.sp.gov.br</a></p>
                <p style="margin: 5px 0 0 0; font-size: 0.9em; color: #999;">Resposta em até 24 horas</p>
            </div>

            <div class="card" style="margin: 15px 0;">
                <h4 style="color: #B20000; margin-top: 0;">Horário de Funcionamento</h4>
                <p style="margin: 0;">
                    <strong>Segunda a sexta:</strong> 9h às 21h<br>
                    <strong>Sábado:</strong> 9h às 13h<br>
                    <strong>Domingo:</strong> Fechado
                </p>
            </div>
        </div>

        <!-- Formulário de Contato -->
        <div>
            <h3 style="color: #B20000; margin-bottom: 20px; margin-top: 0;">Enviar Mensagem</h3>
            
            <!-- Mensagens PHP -->
            <?php if ($mensagemSucesso): ?>
            <div class="msg-sucesso" style="background: #d4edda; border-color: #c3e6cb; color: #155724;">
                <strong>Mensagem Enviada com Sucesso!</strong><br>
                <?php echo $mensagemSucesso; ?>
            </div>
            <?php endif; ?>

            <?php if ($mensagemErro): ?>
            <div class="msg-sucesso" style="background: #f8d7da; border-color: #f5c6cb; color: #721c24;">
                <strong>Erro ao Enviar!</strong><br>
                <?php echo $mensagemErro; ?>
            </div>
            <?php endif; ?>
            
            <form id="formContato" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                <label>Seu Nome *</label>
                <input type="text" name="nome" placeholder="Digite seu nome completo" required>

                <label>Seu Email *</label>
                <input type="email" name="email" placeholder="seu.email@exemplo.com" required>

                <label>Telefone (Opcional)</label>
                <input type="tel" name="telefone" placeholder="(11) 98765-4321">

                <label>Assunto *</label>
                <input type="text" name="assunto" placeholder="Qual é o assunto da sua mensagem?" required>

                <label>Mensagem *</label>
                <textarea name="mensagem" rows="5" placeholder="Escreva sua mensagem aqui..." required></textarea>

                <button type="submit">Enviar</button>
            </form>
        </div>
    </div>

    <!-- ===== PERGUNTAS FREQUENTES ===== -->
    <h2 style="margin-top: 50px;">Perguntas Frequentes</h2>
    
    <div class="card">
        <h3>Como faço minha inscrição?</h3>
        <p>Acesse a página de <a href="inscricao.php" style="color: #B20000; font-weight: bold;">Inscrição</a>, 
        preencha o formulário com seus dados pessoais e escolha o curso desejado. Você receberá um email 
        de confirmação e instruções sobre o processo seletivo.</p>
    </div>

    <div class="card">
        <h3>Qual é o valor da mensalidade?</h3>
        <p>A ETEC oferece <strong>educação 100% gratuita</strong>! Não há qualquer custo de mensalidade, 
        taxa de inscrição ou matrícula. A formação técnica é subsidiada pelo Governo do Estado de São Paulo.</p>
    </div>

    <div class="card">
        <h3>Qual é a idade mínima para se inscrever?</h3>
        <p>A idade mínima recomendada é <strong>15 anos</strong> e ter concluído ou estar cursando o 
        Ensino Fundamental. Também é necessário aprovação no processo seletivo da ETEC.</p>
    </div>

    <div class="card">
        <h3>Qual é a duração dos cursos?</h3>
        <p>Os cursos técnicos presenciais têm duração de <strong>2 anos</strong>, o M-Tec <strong>3 anos</strong> 
        e o AMS totalizando <strong>aproximadamente 3 anos</strong> com aproveitamento de disciplinas.</p>
    </div>

    <div class="card">
        <h3>Vocês oferecem oportunidades de estágio?</h3>
        <p>Sim! A ETEC possui <strong>convênios com várias empresas da região</strong>. Oferecemos 
        oportunidades de estágio supervisionado para alunos do 2º ano, agregando experiência prática 
        ao aprendizado em sala.</p>
    </div>

    <div class="card">
        <h3>Posso continuar estudando após concluir o curso?</h3>
        <p>Sim! Com o diploma técnico, você pode <strong>ingressar em cursos superiores de tecnologia</strong> 
        ou em cursos de graduação tradicionais. Muitos de nossos egressos prosseguem para educação superior.</p>
    </div>

    <div class="card">
        <h3>Como funciona o processo de seleção?</h3>
        <p>O processo inclui análise do histórico escolar, prova de conhecimentos gerais e, em alguns casos, 
        entrevista. Consulte o edital de inscrição para detalhes específicos de cada período.</p>
    </div>

    <div class="card">
        <h3>Há bolsas de auxílio disponíveis?</h3>
        <p>Sim! A ETEC disponibiliza <strong>bolsas de auxílio para alunos em situação de carência</strong> 
        que comprovem necessidade financeira. Consulte a coordenação para mais informações.</p>
    </div>
</div>

<footer>
    <div class="footer-content">
        <div class="footer-section">
            <h3>Sobre</h3>
            <p>ETEC Zona Leste - Instituição de ensino técnico público mantida pelo Centro Paula Souza.</p>
            <p>Formando profissionais qualificados desde 2006.</p>
        </div>

        <div class="footer-section">
            <h3>*
