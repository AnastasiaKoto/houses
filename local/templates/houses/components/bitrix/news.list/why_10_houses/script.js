document.addEventListener('DOMContentLoaded', function () {
  const splideEl = document.querySelector('#aboutWhySlider');
  const prevArrow = document.querySelector('.about-why__slider-arrow__prev');
  const nextArrow = document.querySelector('.about-why__slider-arrow__next');
  const list = splideEl.querySelector('.about-why__items');
  const items = Array.from(list.children);

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
    if (window.innerWidth <= 768 && !splide) {

      const groupedSlides = [];
      for (let i = 0; i < items.length; i += 2) {
        const slide = document.createElement('li');
        slide.classList.add('splide__slide');

        slide.appendChild(items[i]);
        if (items[i + 1]) {
          slide.appendChild(items[i + 1]);
        }

        groupedSlides.push(slide);
      }

      list.innerHTML = '';
      groupedSlides.forEach(slide => list.appendChild(slide));

      splide = new Splide('#aboutWhySlider', {
        type: 'slide',
        perPage: 1,
        arrows: false,
        pagination: false,
        gap: 10,
        speed: 600,
        easing: 'ease',
      });

      splide.mount();

      // 🔥 Стрелки
      if (prevArrow) {
        prevArrow.addEventListener('click', () => {
          if (!prevArrow.classList.contains('is-disabled')) {
            splide.go('<');
          }
        });
      }

      if (nextArrow) {
        nextArrow.addEventListener('click', () => {
          if (!nextArrow.classList.contains('is-disabled')) {
            splide.go('>');
          }
        });
      }

      splide.on('mounted moved resized', updateArrows);
      updateArrows();
    }

    if (window.innerWidth > 768 && splide) {
      splide.destroy(true);
      splide = null;
      location.reload();
    }
  }

  initSlider();
  window.addEventListener('resize', initSlider);
});