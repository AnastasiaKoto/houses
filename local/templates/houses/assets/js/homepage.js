document.addEventListener('DOMContentLoaded', function () {
  const sliderMainscreen = document.querySelector('.mainscreen-splide');
  if (!sliderMainscreen) return;

  const splide = new Splide(sliderMainscreen, {
    type: 'loop',
    perPage: 1,
    gap: 0,
    perMove: 1,
    pagination: false,
    arrows: false, 
    autoplay: true,
    interval: 7000,
    pauseOnHover: false,
    speed: 900,
    easing: 'ease',
  });

 
  const realSlides = sliderMainscreen.querySelectorAll('.splide__slide:not(.is-clone)');
  const slidesCount = realSlides.length;

 
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


    bar.addEventListener('click', () => {
      splide.go(i);
    });
  }

  sliderMainscreen.appendChild(progressWrapper);


  function startFill(index) {
    const realIndex = index % slidesCount;

    fills.forEach((f, i) => {
      f.style.transition = 'none';
      f.style.width = i < realIndex ? '100%' : '0%';
      f.parentElement.classList.toggle('active', i === realIndex);
    });

    const fill = fills[realIndex];
    if (!fill) return;

    setTimeout(() => {
      fill.style.transition = `width ${splide.options.interval}ms linear`;
      fill.style.width = '100%';
    }, 20);
  }

  splide.on('mounted move', () => {
    const currentIndex = splide.Components.Controller.getIndex(true);
    startFill(currentIndex);
  });

  splide.mount();

  const prevArrow = document.querySelector('.mainscreen-arrow__prev');
  const nextArrow = document.querySelector('.mainscreen-arrow__next');

  if (prevArrow && nextArrow) {
    prevArrow.addEventListener('click', () => splide.go('<')); 
    nextArrow.addEventListener('click', () => splide.go('>')); 
  }
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