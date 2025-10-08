document.addEventListener('DOMContentLoaded', () => {
  const tabs = document.querySelectorAll('.projects-tabs__link');
  const contents = document.querySelectorAll('.projects-slider-wrapper');

  if (!tabs.length || !contents.length) return;

  tabs[0].classList.add('active');
  contents[0].classList.add('active');

  tabs.forEach((tab, index) => {
    tab.addEventListener('click', () => {
      // удаляем active со всех
      tabs.forEach(t => t.classList.remove('active'));
      contents.forEach(c => c.classList.remove('active'));

      // добавляем active выбранному
      tab.classList.add('active');
      contents[index].classList.add('active');
    });
  });
});

document.addEventListener('DOMContentLoaded', function () {
  const sliders = document.querySelectorAll('.projects-slider');
  if (!sliders.length) return;

  const prevArrow = document.querySelector('.projects-arrow__prev');
  const nextArrow = document.querySelector('.projects-arrow__next');


  const splides = Array.from(sliders).map(slider => {
    const s = new Splide(slider, {
      type: 'slide',
      autoWidth: true,
      gap: 20,
      perMove: 1,
      pagination: false,
      arrows: false,
    });
    s.mount();
    return s;
  });


  let currentIndex = 0;


  if (prevArrow) prevArrow.addEventListener('click', () => splides[currentIndex].go('<'));
  if (nextArrow) nextArrow.addEventListener('click', () => splides[currentIndex].go('>'));


  sliders.forEach((slider, i) => {
    slider.addEventListener('mouseenter', () => {
      currentIndex = i;
    });
  });
});