document.addEventListener('DOMContentLoaded', function () {
  const sliderMainscreen = document.querySelector('.mainscreen-splide');
  if (!sliderMainscreen) return;

  const interval = 7000; 

  const splide = new Splide(sliderMainscreen, {
    type: 'loop',
    perPage: 1,
    gap: 0,
    perMove: 1,
    pagination: false,
    arrows: false,
    autoplay: false,
    speed: 600,
    easing: 'ease',
  });

  const realSlides = sliderMainscreen.querySelectorAll('.splide__slide:not(.is-clone)');
  const slidesCount = realSlides.length;

  realSlides.forEach((slide, i) => slide.dataset.index = i);

  // --- Story progress bars ---
  const progressWrapper = document.createElement('div');
  progressWrapper.classList.add('story-progress');

  const fills = [];
  for (let i = 0; i < slidesCount; i++) {
    const bar = document.createElement('div');
    bar.classList.add('story-bar');

    const fill = document.createElement('div');
    fill.classList.add('story-fill');

    bar.appendChild(fill);
    progressWrapper.appendChild(bar);
    fills.push(fill);

    bar.addEventListener('click', () => goToSlide(i));
  }
  sliderMainscreen.appendChild(progressWrapper);

  let timer;

  function resetAllBars() {
    fills.forEach(f => {
      f.style.transition = 'none';
      f.style.width = '0%';
      f.parentElement.classList.remove('active');
    });
    if (timer) clearTimeout(timer);
  }

  function startFill(realIndex) {
    fills.forEach((f, i) => {
      f.style.transition = 'none';
      f.style.width = i < realIndex ? '100%' : '0%';
      f.parentElement.classList.toggle('active', i === realIndex);
    });

    const fill = fills[realIndex];
    if (!fill) return;

    fill.style.transition = `width ${interval}ms linear`;
    fill.style.width = '100%';

    timer = setTimeout(() => {
      goToSlide((realIndex + 1) % slidesCount);
    }, interval);
  }

  function goToSlide(index) {
    resetAllBars();
    splide.go(index);
    startFill(index);
  }

  splide.mount();


  const prevArrow = document.querySelector('.mainscreen-arrow__prev');
  const nextArrow = document.querySelector('.mainscreen-arrow__next');

  if (prevArrow) prevArrow.addEventListener('click', () => {
    const prevIndex = (splide.index - 1 + slidesCount) % slidesCount;
    goToSlide(prevIndex);
  });

  if (nextArrow) nextArrow.addEventListener('click', () => {
    const nextIndex = (splide.index + 1) % slidesCount;
    goToSlide(nextIndex);
  });

  startFill(0);
});


document.addEventListener('DOMContentLoaded', function () {
  const sliderStyles = document.querySelector('.styles-slider');
  if (!sliderStyles) return;

  let splide;

  function initSplide() {
    // Слайдер включается только при <= 1500px
    if (window.innerWidth <= 1500) {
      if (!splide) {
        splide = new Splide(sliderStyles, {
          type: 'slide',
          perPage: 3,
          perMove: 1,
          gap: 20,
          speed: 600,
          easing: 'ease',
          pagination: false,
          arrows: false,
          focus: 'start',
          padding: { right: 15 },
          breakpoints: {
            992: {
              perPage: 2,
              gap: 10,
              padding: { right: 10 },
            },
            700: {
              perPage: 1,
              padding: { right: 10 },
            },
          },
        });

        splide.mount();

        // --- стрелки ---
        const prevArrow = document.querySelector('.styles-arrow__prev');
        const nextArrow = document.querySelector('.styles-arrow__next');

        function updateArrows() {
          if (!prevArrow || !nextArrow) return;

          prevArrow.classList.toggle('is-disabled', splide.index === 0);

          nextArrow.classList.toggle(
            'is-disabled',
            splide.index >= splide.length - splide.options.perPage
          );
        }

        splide.on('moved', updateArrows);
        splide.on('mounted', updateArrows);
        splide.on('resized', updateArrows);

        if (prevArrow) {
          prevArrow.addEventListener('click', () => {
            if (!prevArrow.classList.contains('is-disabled')) splide.go('<');
          });
        }

        if (nextArrow) {
          nextArrow.addEventListener('click', () => {
            if (!nextArrow.classList.contains('is-disabled')) splide.go('>');
          });
        }
      }
    } else {
      // Уничтожаем слайдер при >1500px
      if (splide) {
        splide.destroy();
        splide = null;
      }
    }
  }

  initSplide();
  window.addEventListener('resize', initSplide);
});



document.addEventListener('DOMContentLoaded', function () {
	const sliderUniq = document.querySelector('.uniq-slider');
	if (!sliderUniq) return;

	const splide = new Splide(sliderUniq, {
		type: 'slide',
		perPage: 4,          
		perMove: 1,
		gap: 20,
		speed: 600,
		easing: 'ease',
		pagination: false,
		arrows: false,
		focus: 'start',       
		padding: { right: 15 }, 
		breakpoints: {
			992: {
				perPage: 2,
				gap: 10,
				padding: { right: 10 },
			},
		},
	});

	splide.mount();

	const prevArrow = document.querySelector('.uniq-arrow__prev');
	const nextArrow = document.querySelector('.uniq-arrow__next');

	function updateArrows() {
		if (!prevArrow || !nextArrow) return;


		prevArrow.classList.toggle('is-disabled', splide.index === 0);

		nextArrow.classList.toggle(
			'is-disabled',
			splide.index >= splide.length - splide.options.perPage
		);
	}

	splide.on('moved', updateArrows);
	splide.on('mounted', updateArrows);
	splide.on('resized', updateArrows);

	// стрелки
	if (prevArrow) {
		prevArrow.addEventListener('click', () => {
			if (!prevArrow.classList.contains('is-disabled')) splide.go('<');
		});
	}

	if (nextArrow) {
		nextArrow.addEventListener('click', () => {
			if (!nextArrow.classList.contains('is-disabled')) splide.go('>');
		});
	}
});


document.addEventListener("DOMContentLoaded", () => {
  function moveElementOnBreakpoint(elementSelector, targetSelector, breakpoint) {
    const element = document.querySelector(elementSelector);
    const target = document.querySelector(targetSelector);
    if (!element || !target) return;

    const originalParent = element.parentNode;

    function move() {
      if (window.innerWidth <= breakpoint) {
        if (!target.contains(element)) {
          target.appendChild(element);
        }
      } else {
        if (!originalParent.contains(element)) {
          originalParent.appendChild(element);
        }
      }
    }

    move();
    window.addEventListener("resize", move);
  }

  // Применение
  moveElementOnBreakpoint(".uniq-arrows", ".uniq-slider__wrap", 992);
  moveElementOnBreakpoint(".projects-arrows", ".projects-tabs__content", 992);
});


document.addEventListener('DOMContentLoaded', function () {
  const sliders = document.querySelectorAll('.projects-slider');
  if (!sliders.length) return;

  const prevArrow = document.querySelector('.projects-arrow__prev');
  const nextArrow = document.querySelector('.projects-arrow__next');

  const splides = Array.from(sliders).map(slider => {
    const s = new Splide(slider, {
      type: 'slide',
      perPage: 3,
      perMove: 1,
      gap: 20,
      speed: 600,
      easing: 'ease',
      pagination: false,
      arrows: false,
      focus: 'start',
      padding: { right: 15 },
      breakpoints: {
        992: {
          perPage: 2,
          gap: 10,
          padding: { right: 10 },
        },
      },
    });
    s.mount();
    return s;
  });

  let currentIndex = 0;

  function updateArrows() {
    if (!prevArrow || !nextArrow) return;

    const splide = splides[currentIndex];
    prevArrow.classList.toggle('is-disabled', splide.index === 0);
    nextArrow.classList.toggle(
      'is-disabled',
      splide.index >= splide.length - splide.options.perPage
    );
  }


  if (prevArrow) {
    prevArrow.addEventListener('click', () => {
      const splide = splides[currentIndex];
      if (!prevArrow.classList.contains('is-disabled')) {
        splide.go('<');
      }
    });
  }

  if (nextArrow) {
    nextArrow.addEventListener('click', () => {
      const splide = splides[currentIndex];
      if (!nextArrow.classList.contains('is-disabled')) {
        splide.go('>');
      }
    });
  }


  splides.forEach(splide => {
    splide.on('moved', updateArrows);
    splide.on('mounted', updateArrows);
    splide.on('resized', updateArrows);
  });


  sliders.forEach((slider, i) => {
    slider.addEventListener('mouseenter', () => {
      currentIndex = i;
      updateArrows(); 
    });
  });


  updateArrows();
});





// document.addEventListener('DOMContentLoaded', function () {
//   const sliders = document.querySelectorAll('.projects-slider__images');
//   if (!sliders.length) return;

//   sliders.forEach(slider => {
//     new Splide(slider, {
//       type: 'slide',
//       perPage: 1,
//       // gap: 20,
//       perMove: 1,
//       pagination: false,
//       arrows: false, 
//     }).mount();
//   });
// });



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