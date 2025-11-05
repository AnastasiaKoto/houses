document.addEventListener('DOMContentLoaded', function () {
  const sliderIndividual = document.querySelector('.individual-ms__slider.splide');
  if (!sliderIndividual) return;

  let splideInstance = null;

  function checkWidth() {
    // Слайдер включен только при ширине меньше 1100px
    if (window.innerWidth < 1100) {
      if (!splideInstance) {
        splideInstance = new Splide(sliderIndividual, {
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
      // Если ширина ≥1100, уничтожаем слайдер
      if (splideInstance) {
        splideInstance.destroy();
        splideInstance = null;
      }
    }
  }

  window.addEventListener('resize', checkWidth);
  checkWidth(); // проверка при загрузке
});



  // const prevArrow = document.querySelector('.uniq-arrow__prev');
  // const nextArrow = document.querySelector('.uniq-arrow__next');

  // function updateArrows() {
  //   if (!prevArrow || !nextArrow) return;


  //   prevArrow.classList.toggle('is-disabled', splide.index === 0);

  //   nextArrow.classList.toggle(
  //     'is-disabled',
  //     splide.index >= splide.length - splide.options.perPage
  //   );
  // }

  // splide.on('moved', updateArrows);
  // splide.on('mounted', updateArrows);
  // splide.on('resized', updateArrows);

  // // стрелки
  // if (prevArrow) {
  //   prevArrow.addEventListener('click', () => {
  //     if (!prevArrow.classList.contains('is-disabled')) splide.go('<');
  //   });
  // }

  // if (nextArrow) {
  //   nextArrow.addEventListener('click', () => {
  //     if (!nextArrow.classList.contains('is-disabled')) splide.go('>');
  //   });
  // }
