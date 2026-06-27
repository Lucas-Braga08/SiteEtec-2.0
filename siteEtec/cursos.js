function mostrarAba(abaId) {
    // Esconder todos os conteúdos
    const tabs = document.querySelectorAll('.tab-content');
    tabs.forEach(tab => {
        tab.classList.remove('active');
    });

    // Desativar todos os botões
    const botoes = document.querySelectorAll('.tab-btn');
    botoes.forEach(btn => {
        btn.classList.remove('active');
    });

    // Mostrar aba selecionada
    document.getElementById(abaId).classList.add('active');

    // Ativar botão selecionado
    event.target.classList.add('active');

    // Scroll suave para o topo
    document.querySelector('.tabs-container').scrollIntoView({ behavior: 'smooth' });
}

// Ativar primeira aba por padrão
document.addEventListener('DOMContentLoaded', function() {
    const primeiroTab = document.querySelector('.tab-btn');
    if (primeiroTab) {
        primeiroTab.classList.add('active');
    }
});