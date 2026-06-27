let indiceAtual = 0;
let slides = [];
let indicators = [];
let autoPlayInterval;

// Inicializar quando o DOM estiver carregado
document.addEventListener('DOMContentLoaded', function() {
    slides = document.querySelectorAll('.carousel-slide');
    indicators = document.querySelectorAll('.indicator');
    
    console.log('Slides encontrados:', slides.length);
    console.log('Indicadores encontrados:', indicators.length);
    
    // Iniciar auto-play
    iniciarAutoPlay();
});

function iniciarAutoPlay() {
    autoPlayInterval = setInterval(() => {
        mudarSlide(1);
    }, 5000);
}

function pararAutoPlay() {
    clearInterval(autoPlayInterval);
}

function mudarSlide(direcao) {
    if (slides.length === 0) return;
    
    indiceAtual += direcao;

    if (indiceAtual >= slides.length) {
        indiceAtual = 0;
    } else if (indiceAtual < 0) {
        indiceAtual = slides.length - 1;
    }

    atualizarCarrossel();
    
    // Reiniciar o auto-play ao clicar
    pararAutoPlay();
    iniciarAutoPlay();
}

function irParaSlide(indice) {
    indiceAtual = indice;
    atualizarCarrossel();
    
    // Reiniciar o auto-play ao clicar
    pararAutoPlay();
    iniciarAutoPlay();
}

function atualizarCarrossel() {
    slides.forEach((slide, index) => {
        slide.classList.remove('active');
        if (index === indiceAtual) {
            slide.classList.add('active');
        }
    });

    indicators.forEach((indicator, index) => {
        indicator.classList.remove('active');
        if (index === indiceAtual) {
            indicator.classList.add('active');
        }
    });
}