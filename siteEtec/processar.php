<?php
/**
 * processar.php
 * Recebe o POST do formulário de inscrição, valida server-side,
 * e exibe uma página HTML com o resumo dos dados enviados (ou os erros encontrados).
 */

function limpar(string $v): string {
    return htmlspecialchars(strip_tags(trim($v)), ENT_QUOTES, 'UTF-8');
}

/*Só processa quando vier via POST*/
$resultado = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nome           = limpar($_POST['nome']           ?? '');
    $email          = limpar($_POST['email']          ?? '');
    $telefone       = limpar($_POST['telefone']       ?? '');
    $datanascimento = limpar($_POST['datanascimento'] ?? '');
    $endereco       = limpar($_POST['endereco']       ?? '');
    $bairro         = limpar($_POST['bairro']         ?? '');
    $municipio      = limpar($_POST['municipio']      ?? '');
    $escolaridade   = limpar($_POST['escolaridade']   ?? '');
    $curso          = limpar($_POST['curso']          ?? '');
    $motivacao      = limpar($_POST['motivacao']      ?? '');
    $experiencia    = limpar($_POST['experiencia']    ?? '');
    $termos         = isset($_POST['termos']);

    $escolaridadesPermitidas = [
        'Cursando o Ensino Fundamental (8º ou 9º ano)',
        'Ensino Fundamental Completo',
        'Cursando o Ensino Médio',
        'Ensino Médio Completo',
        'Ensino Superior Incompleto',
        'Ensino Superior Completo',
    ];

    $cursosPermitidos = [
        'Desenvolvimento de Sistemas',
        'Administração',
        'Contabilidade',
        'Finanças',
        'Logística',
        'Recursos Humanos',
        'Serviços Jurídicos',
    ];

    /*Validação*/
    $erros = [];
    
    if (strlen($nome) < 3)
        $erros[] = 'Nome completo deve ter ao menos 3 caracteres.';
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        $erros[] = 'E-mail inválido.';
    
    if (strlen($telefone) < 8)
        $erros[] = 'Telefone inválido.';
    
    if (!preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $datanascimento))
        $erros[] = 'Data de nascimento deve estar no formato DD/MM/AAAA.';
    
    if (strlen($endereco) < 5)
        $erros[] = 'Endereço completo é obrigatório.';
    
    if (strlen($bairro) < 2)
        $erros[] = 'Bairro é obrigatório.';
    
    if (strlen($municipio) < 2)
        $erros[] = 'Município é obrigatório.';
    
    if (!in_array($escolaridade, $escolaridadesPermitidas, true))
        $erros[] = 'Selecione um nível de escolaridade válido.';
    
    if (!in_array($curso, $cursosPermitidos, true))
        $erros[] = 'Selecione um curso válido.';
    
    if (strlen($motivacao) < 10)
        $erros[] = 'Conte-nos um pouco mais sobre seu interesse (mínimo 10 caracteres).';
    
    if (strlen($motivacao) > 500)
        $erros[] = 'Motivação excede o limite de 500 caracteres.';
    
    if (!$termos)
        $erros[] = 'Você deve concordar com os termos e condições.';

  
    if (empty($erros)) {
        if (!is_dir(__DIR__ . '/logs')) mkdir(__DIR__ . '/logs', 0755, true);
        $linha = '[' . date('Y-m-d H:i:s') . "] $nome | $email | $curso\n";
        file_put_contents(__DIR__ . '/logs/inscricoes.log', $linha, FILE_APPEND | LOCK_EX);
    }

    $resultado = [
        'sucesso'  => empty($erros),
        'erros'    => $erros,
        'campos'   => compact(
            'nome', 'email', 'telefone', 'datanascimento', 'endereco',
            'bairro', 'municipio', 'escolaridade', 'curso', 'motivacao', 'experiencia'
        ),
        'dataHora' => date('d/m/Y \à\s H:i'),
    ];
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Resultado da Inscrição</title>
  <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Sora:wght@700&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="inscricao.css"/>
  <style>
    :root {
      --bg:      #F8F7F4;
      --card:    #FFFFFF;
      --dark:    #1A1A2E;
      --accent:  #5B8CFF;
      --success: #1DB870;
      --error:   #E5452F;
      --muted:   #6B7280;
      --border:  #E5E7EB;
      --radius:  12px;
      --shadow:  0 4px 24px rgba(26,26,46,.09);
    }
    
    body.resultado-page {
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 2rem 1rem;
      background: var(--bg);
    }

    .card {
      background: var(--card);
      border-radius: 18px;
      box-shadow: var(--shadow);
      max-width: 680px;
      width: 100%;
      overflow: hidden;
    }


    .card-header {
      padding: 2rem 2.2rem 1.6rem;
      display: flex;
      align-items: flex-start;
      gap: 1rem;
    }
    .card-header.ok  { background: #ECFDF5; border-bottom: 3px solid var(--success); }
    .card-header.err { background: #FEF2F2; border-bottom: 3px solid var(--error); }

    .icon {
      width: 48px; height: 48px;
      border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      flex-shrink: 0;
      font-size: 1.4rem;
    }
    .ok  .icon { background: var(--success); color: #fff; }
    .err .icon { background: var(--error); color: #fff; }

    .header-text h1 {
      font-family: 'Sora', sans-serif;
      font-size: 1.3rem;
      font-weight: 700;
      line-height: 1.2;
      margin-bottom: .3rem;
    }
    .ok  .header-text h1 { color: #065F46; }
    .err .header-text h1 { color: #991B1B; }

    .header-text p {
      font-size: .85rem;
      color: var(--muted);
    }

    .card-body { padding: 1.8rem 2.2rem 2rem; }

    .data-table { width: 100%; border-collapse: collapse; margin-bottom: 1.5rem; }
    .data-table tr { border-bottom: 1px solid var(--border); }
    .data-table tr:last-child { border-bottom: none; }
    .data-table th {
      text-align: left;
      font-size: .75rem;
      font-weight: 600;
      letter-spacing: .06em;
      text-transform: uppercase;
      color: var(--muted);
      padding: .75rem .5rem .75rem 0;
      width: 36%;
    }
    .data-table td {
      font-size: .9rem;
      padding: .75rem 0 .75rem .5rem;
      color: var(--dark);
      word-break: break-word;
    }

    .mensagem-bloco {
      background: var(--bg);
      border-left: 3px solid var(--accent);
      border-radius: 6px;
      padding: 1rem 1.1rem;
      font-size: .88rem;
      line-height: 1.6;
      color: var(--dark);
      white-space: pre-wrap;
      margin-bottom: 1.5rem;
    }

    .erros-lista {
      list-style: none;
      display: flex;
      flex-direction: column;
      gap: .5rem;
      margin-bottom: 1.5rem;
    }
    .erros-lista li {
      font-size: .88rem;
      display: flex;
      align-items: baseline;
      gap: .5rem;
      color: #991B1B;
    }
    .erros-lista li::before {
      content: '✕';
      font-size: .75rem;
      flex-shrink: 0;
      color: var(--error);
    }

    .btn {
      display: inline-flex;
      align-items: center;
      gap: .5rem;
      font-family: 'Inter', sans-serif;
      font-size: .9rem;
      font-weight: 600;
      color: #fff;
      background: var(--accent);
      border: none;
      border-radius: var(--radius);
      padding: .75rem 1.6rem;
      cursor: pointer;
      text-decoration: none;
      transition: background .15s;
    }
    .btn:hover { background: #3A6AE0; }
    .btn.outline {
      background: transparent;
      color: var(--accent);
      border: 1.5px solid var(--accent);
    }
    .btn.outline:hover { background: #EEF3FF; }

    .actions { display: flex; gap: .75rem; flex-wrap: wrap; }

    .card-footer {
      border-top: 1px solid var(--border);
      padding: .9rem 2.2rem;
      font-size: .78rem;
      color: var(--muted);
      display: flex;
      justify-content: space-between;
      align-items: center;
      gap: .5rem;
      flex-wrap: wrap;
    }

    .noop {
      text-align: center;
      padding: 3rem 2.2rem;
    }
    .noop .big-icon { font-size: 3rem; margin-bottom: 1rem; }
    .noop h2 { font-family: 'Sora', sans-serif; font-size: 1.2rem; margin-bottom: .5rem; }
    .noop p  { font-size: .88rem; color: var(--muted); margin-bottom: 1.5rem; }

    @media (max-width: 500px) {
      .card-header, .card-body, .card-footer { padding-left: 1.3rem; padding-right: 1.3rem; }
    }
  </style>
</head>
<body class="resultado-page">

<div class="card">

<?php if ($resultado === null): ?>
  <div class="noop">
    <div class="big-icon">📋</div>
    <h2>Página de processamento</h2>
    <p>Esta página recebe e exibe os dados enviados pelo formulário de inscrição.<br>
       Acesse pelo formulário para ver o resultado.</p>
    <a href="inscricao.html" class="btn">← Ir para o formulário</a>
  </div>

<?php elseif ($resultado['sucesso']): ?>
  <!-- SUCESSO -->
  <div class="card-header ok">
    <div class="icon">✓</div>
    <div class="header-text">
      <h1>Inscrição recebida!</h1>
      <p>Dados validados e registrados em <?= $resultado['dataHora'] ?></p>
    </div>
  </div>

  <div class="card-body">
    <table class="data-table">
      <tr>
        <th>Nome</th>
        <td><?= $resultado['campos']['nome'] ?></td>
      </tr>
      <tr>
        <th>E-mail</th>
        <td><?= $resultado['campos']['email'] ?></td>
      </tr>
      <tr>
        <th>Telefone</th>
        <td><?= $resultado['campos']['telefone'] ?></td>
      </tr>
      <tr>
        <th>Data de Nascimento</th>
        <td><?= $resultado['campos']['datanascimento'] ?></td>
      </tr>
      <tr>
        <th>Endereço</th>
        <td><?= $resultado['campos']['endereco'] ?></td>
      </tr>
      <tr>
        <th>Bairro</th>
        <td><?= $resultado['campos']['bairro'] ?></td>
      </tr>
      <tr>
        <th>Município</th>
        <td><?= $resultado['campos']['municipio'] ?></td>
      </tr>
      <tr>
        <th>Escolaridade</th>
        <td><?= $resultado['campos']['escolaridade'] ?></td>
      </tr>
      <tr>
        <th>Curso</th>
        <td><?= $resultado['campos']['curso'] ?></td>
      </tr>
    </table>

    <p style="font-size:.78rem;font-weight:600;letter-spacing:.06em;text-transform:uppercase;color:var(--muted);margin-bottom:.5rem;">Motivação</p>
    <div class="mensagem-bloco"><?= $resultado['campos']['motivacao'] ?></div>

    <?php if (!empty($resultado['campos']['experiencia'])): ?>
    <p style="font-size:.78rem;font-weight:600;letter-spacing:.06em;text-transform:uppercase;color:var(--muted);margin-bottom:.5rem;">Experiência na área</p>
    <div class="mensagem-bloco"><?= $resultado['campos']['experiencia'] ?></div>
    <?php endif; ?>

    <div class="actions">
      <a href="inscricao.html" class="btn">← Fazer nova inscrição</a>
    </div>
  </div>

  <div class="card-footer">
    <span>Dados sanitizados e registrados em <code>logs/inscricoes.log</code></span>
    <span style="color:var(--success);font-weight:600;">✔ Sucesso</span>
  </div>

<?php else: ?>
  <!-- ERRO DE VALIDAÇÃO -->
  <div class="card-header err">
    <div class="icon">✕</div>
    <div class="header-text">
      <h1>Dados inválidos</h1>
      <p>Corrija os erros abaixo e tente novamente.</p>
    </div>
  </div>

  <div class="card-body">
    <ul class="erros-lista">
      <?php foreach ($resultado['erros'] as $e): ?>
        <li><?= $e ?></li>
      <?php endforeach ?>
    </ul>

    <div class="actions">
      <a href="javascript:history.back()" class="btn">← Voltar e corrigir</a>
      <a href="inscricao.html" class="btn outline">Recomeçar</a>
    </div>
  </div>

  <div class="card-footer">
    <span><?= count($resultado['erros']) ?> erro(s) encontrado(s)</span>
    <span style="color:var(--error);font-weight:600;">✕ Falha na validação</span>
  </div>

<?php endif ?>

</div>

</body>
</html>
