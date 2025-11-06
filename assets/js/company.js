document.addEventListener('DOMContentLoaded', function () {
  const sliderCompany = document.querySelector('.company-ms__slider.splide');
  if (!sliderCompany) return;

  let splideInstance = null;

  function checkWidth() {

    if (window.innerWidth < 1100) {
      if (!splideInstance) {
        splideInstance = new Splide(sliderCompany, {
          type: 'slide',
          perPage: 1,
          gap: 10,
          // padding: { right: 10 },
          arrows: false,
          easing: 'ease',
          speed: 600,
        });
        splideInstance.mount();
      }
    } else {

      if (splideInstance) {
        splideInstance.destroy();
        splideInstance = null;
      }
    }
  }

  window.addEventListener('resize', checkWidth);
  checkWidth();
});


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

