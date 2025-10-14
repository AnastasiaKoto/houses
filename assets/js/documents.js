document.addEventListener('DOMContentLoaded', function () {
  const sliderCerts = document.querySelector('.certificates-slider');
  if (!sliderCerts) return;

  let splide;

  function initSplide() {
    if (window.innerWidth <= 1200) {
      if (!splide) {
        splide = new Splide(sliderCerts, {
          type: 'loop',
          autoWidth: true,
          perMove: 1,
          pagination: false,
          arrows: false,
          gap: 20,
          speed: 600,  
          easing: 'ease', 
          breakpoints: {
            700: {
              gap: 10
            }
          }
        });
        splide.mount();
      }
    } else {
      if (splide) {
        splide.destroy();
        splide = null;
      }
    }
  }

  initSplide();
  window.addEventListener('resize', initSplide);

  const prevArrow = document.querySelector('.certs-arrow__prev');
  const nextArrow = document.querySelector('.certs-arrow__next');

  if (prevArrow) {
    prevArrow.addEventListener('click', () => splide?.go('<'));
  }
  if (nextArrow) {
    nextArrow.addEventListener('click', () => splide?.go('>'));
  }
});