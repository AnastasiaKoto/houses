document.addEventListener('DOMContentLoaded', function () {
  const splideEl = document.querySelector('#crystalSlider');
  if (!splideEl) return;

  const prevArrow = document.querySelector('.crystal__slider-arrow__prev');
  const nextArrow = document.querySelector('.crystal__slider-arrow__next');
  const items = splideEl.querySelectorAll('.crystal-slider__item');

  let splide = null;

  function updateArrows() {
    if (!splide) return;
    prevArrow.classList.toggle('is-disabled', splide.index === 0);
    nextArrow.classList.toggle(
      'is-disabled',
      splide.index >= splide.length - splide.options.perPage
    );
  }

  function initSlider() {
    if (window.innerWidth <= 1100 && !splide) {


      items.forEach(item => item.classList.add('splide__slide'));

      splide = new Splide('#crystalSlider', {
        type: 'slide',
        perPage: 1,
        arrows: false,
        pagination: false,
        gap: 10,
        speed: 600,
        easing: 'ease',
        padding: { right: 15 },
        breakpoints: {
          992: {
            padding: { right: 10 },
          },
        }
      });

      splide.mount();

      // Стрелки
      if (prevArrow) prevArrow.addEventListener('click', () => splide.go('<'));
      if (nextArrow) nextArrow.addEventListener('click', () => splide.go('>'));

      splide.on('mounted moved resized', updateArrows);
      updateArrows();
    }

    if (window.innerWidth > 1100 && splide) {
      splide.destroy(true);
      splide = null;


      items.forEach(item => item.classList.remove('splide__slide'));
    }
  }

  initSlider();
  window.addEventListener('resize', initSlider);
});