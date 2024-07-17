// Variáveis para controle dos slides
let slideIndex = 1;
showSlides(slideIndex);

// Função para avançar/retroceder os slides
function plusSlides(n) {
  showSlides(slideIndex += n);
}

// Função para mostrar os slides
function showSlides(n) {
  let slides = document.getElementsByClassName("slide");
  
  // Se passar do último slide, volta para o primeiro
  if (n > slides.length) {
    slideIndex = 1;
  }
  // Se passar do primeiro slide, volta para o último
  if (n < 1) {
    slideIndex = slides.length;
  }
  
  // Esconde todos os slides
  for (let i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }
  
  // Mostra o slide atual
  slides[slideIndex - 1].style.display = "block";
}

// Event listener para abrir a modal de instruções
const btnOpenModal = document.getElementById('openModalBtn');
const modal = document.getElementById('myModal');

btnOpenModal.addEventListener('click', function() {
  modal.style.display = 'block';
  slideIndex = 1; // Reinicia o slide para o primeiro ao abrir a modal
  showSlides(slideIndex); // Mostra o primeiro slide ao abrir a modal
});

// Event listener para fechar a modal de instruções
const btnCloseModal = document.querySelector('.close');
btnCloseModal.addEventListener('click', function() {
  modal.style.display = 'none';
});