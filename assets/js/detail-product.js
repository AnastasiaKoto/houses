document.addEventListener("DOMContentLoaded", () => {
  const toggleBtn = document.querySelector(
    ".detail-product__mainscreen-config__head-change"
  );
  const viewBlock = document.querySelector(
    ".detail-product__mainscreen-config__items:not(.edit)"
  );
  const editBlock = document.querySelector(
    ".detail-product__mainscreen-config__items.edit"
  );

  if(!editBlock || viewBlock || toggleBtn) return;

  const updateViewData = () => {
    // === 1. Стиль постройки ===
    const styleValue = editBlock.querySelector(
      'input[name="style-building"]:checked'
    )?.nextElementSibling?.textContent;

    if (styleValue) {
      viewBlock.querySelectorAll(".detail-product__mainscreen-config__item")[0]
        .querySelector(".detail-product__mainscreen-config__item-prop")
        .textContent = styleValue;
    }

    // === 2. Этажность ===
    const floorValue = editBlock.querySelector(
      'input[name="floor"]:checked'
    )?.nextElementSibling?.textContent;

    if (floorValue) {
      viewBlock.querySelectorAll(".detail-product__mainscreen-config__item")[1]
        .querySelector(".detail-product__mainscreen-config__item-prop")
        .textContent = floorValue;
    }

    // === 3. Площадь дома ===
    const selectedOption = editBlock.querySelector(
      ".custom-select-js .options li.active"
    );
    if (selectedOption) {
      const strongText = selectedOption.querySelector("strong")?.textContent;
      viewBlock.querySelectorAll(".detail-product__mainscreen-config__item")[2]
        .querySelector(".detail-product__mainscreen-config__item-prop")
        .textContent = strongText || selectedOption.textContent;
    }
  };

  toggleBtn.addEventListener("click", () => {
    const isEditing = editBlock.classList.contains("open");

    if (isEditing) {
      // === Сохраняем ===
      updateViewData();
      editBlock.classList.remove("open");
      viewBlock.classList.remove("hidden");
      toggleBtn.textContent = "Изменить";
    } else {
      // === Редактируем ===
      editBlock.classList.add("open");
      viewBlock.classList.add("hidden");
      toggleBtn.textContent = "Сохранить";
    }
  });

});


document.addEventListener('DOMContentLoaded', function () {
  const sliders = document.querySelectorAll('.detail__page-slider__images');

  sliders.forEach(slider => {
    const splide = new Splide(slider, {
      type: 'slide',
      perPage: 1,
      gap: 0,
      pagination: true,
      arrows: false,
      drag: false,
    }).mount();

    const track = slider.querySelector('.splide__track');

    track.addEventListener('mousemove', e => {
      const rect = track.getBoundingClientRect();
      const x = e.clientX - rect.left;
      const width = rect.width;

      const slidesCount = splide.length;
      const hoverZone = 15;

      let index = Math.floor((x / width) * slidesCount);

      if (x < hoverZone) index = 0;
      if (x > width - hoverZone) index = slidesCount - 1;

      splide.go(index);
    });

  });
});


Fancybox.bind("[data-fancybox]", {
});


document.addEventListener("DOMContentLoaded", function () {
  const tabLinks = document.querySelectorAll(".detail-product__layout-tabs__link");
  const tabPanes = document.querySelectorAll(".tab-pane");

  tabLinks.forEach(link => {
    link.addEventListener("click", function (e) {
      e.preventDefault();

      // убираем active у всех
      tabLinks.forEach(l => l.classList.remove("active"));
      tabPanes.forEach(p => p.classList.remove("active"));

      // активируем выбранный таб
      this.classList.add("active");
      const tabId = this.getAttribute("data-tab");
      document.querySelector(`.tab-pane[data-tab="${tabId}"]`).classList.add("active");
    });
  });
});

document.addEventListener('DOMContentLoaded', function () {
  const tabHeads = document.querySelectorAll('.detail-product__preview-tabs');
  if (!tabHeads.length) return;

  tabHeads.forEach(head => {
    const root = head.closest('.detail-product') || head.closest('.container') || head.parentElement;

    // Собираем панели контента (сначала внутри root, иначе — последовательные siblings)
    let contents = Array.from(root.querySelectorAll('.detail-product__preview-tabs__content') || []);
    if (!contents.length) {
      let node = root.nextElementSibling;
      while (node) {
        if (node.classList && node.classList.contains('detail-product__preview-tabs__content')) {
          contents.push(node);
          node = node.nextElementSibling;
          continue;
        }
        if (node.querySelector && node.querySelector('.detail-product__preview-tabs')) break;
        node = node.nextElementSibling;
      }
    }

    const links = Array.from(head.querySelectorAll('.detail-product__preview-tabs__link'));
    const prevArrow = head.querySelector('.detail-product__preview-arrow__prev');
    const nextArrow = head.querySelector('.detail-product__preview-arrow__next');

    if (!links.length || !contents.length) {
      console.warn('Tabs: missing links or contents for widget', head);
      return;
    }

    const maxLen = Math.max(links.length, contents.length);
    for (let i = 0; i < maxLen; i++) {
      const l = links[i];
      const c = contents[i];

      if (l && c) {
        if (!l.dataset.tab && c.dataset.tab) l.dataset.tab = c.dataset.tab;
        else if (l.dataset.tab && !c.dataset.tab) c.dataset.tab = l.dataset.tab;
        else if (!l.dataset.tab && !c.dataset.tab) {
          const gen = `tab-${Date.now().toString(36)}-${i}`;
          l.dataset.tab = gen;
          c.dataset.tab = gen;
        }
      } else if (l && !c) {
        // есть ссылка без контента (создаём namespace)
        if (!l.dataset.tab) l.dataset.tab = `tab-${Date.now().toString(36)}-${i}`;
      } else if (c && !l) {
        if (!c.dataset.tab) c.dataset.tab = `tab-${Date.now().toString(36)}-${i}`;
      }
    }


    const contentMap = new Map();
    contents.forEach(c => {
      if (c.dataset.tab) contentMap.set(c.dataset.tab, c);
    });
    const linkMap = new Map();
    links.forEach(l => {
      if (l.dataset.tab) linkMap.set(l.dataset.tab, l);
    });


    const splides = {};
    const splideOptions = {
      type: 'loop',
      autoWidth: true,
      gap: 20,
      perMove: 1,
      pagination: false,
      arrows: false,
      breakpoints: { 992: { gap: 10 } }
    };


    function mountSplideFor(tabName) {
      if (!tabName) return null;
      if (splides[tabName]) return splides[tabName];

      const content = contentMap.get(tabName);
      if (!content) return null;

      const el = content.querySelector('.detail-product__preview-tabs__slider') || content.querySelector('.splide');
      if (!el) return null;


      const computed = window.getComputedStyle(content);
      const wasHidden = computed.display === 'none' || computed.visibility === 'hidden';
      const prev = {};
      if (wasHidden) {
        prev.display = content.style.display;
        prev.visibility = content.style.visibility;
        prev.position = content.style.position;
        prev.left = content.style.left;

        content.style.display = 'block';
        content.style.visibility = 'hidden';
        content.style.position = 'absolute';
        content.style.left = '-9999px';
      }


      const instance = new Splide(el, splideOptions);
      instance.mount();


      if (wasHidden) {
        content.style.display = prev.display || '';
        content.style.visibility = prev.visibility || '';
        content.style.position = prev.position || '';
        content.style.left = prev.left || '';
      }


      splides[tabName] = instance;
      setTimeout(() => {
        try { instance.refresh(); } catch (e) { /* ignore */ }
      }, 50);

      return instance;
    }


    let activeTab = head.querySelector('.detail-product__preview-tabs__link.active')?.dataset.tab
      || links[0].dataset.tab;


    contents.forEach(c => {
      if (c.dataset.tab === activeTab) {
        c.classList.add('active');
        c.style.display = '';
        mountSplideFor(activeTab);
      } else {
        c.classList.remove('active');
        c.style.display = 'none';
      }
    });

    // Навешиваем обработчики на ссылки
    links.forEach(link => {
      link.addEventListener('click', function (e) {
        e.preventDefault();
        const tabName = this.dataset.tab;
        if (!tabName || tabName === activeTab) return;

        // Снимаем active у ссылок и контентов
        links.forEach(l => l.classList.remove('active'));
        contents.forEach(c => {
          c.classList.remove('active');
          c.style.display = 'none';
        });

        // Активируем выбранные
        this.classList.add('active');
        const newContent = contentMap.get(tabName);
        if (newContent) {
          newContent.classList.add('active');
          newContent.style.display = '';
          // Инициализируем / обновляем слайдер для этого таба
          mountSplideFor(tabName);
        }

        activeTab = tabName;
      });
    });

    // Стрелки управляют текущим активным слайдером
    if (prevArrow) prevArrow.addEventListener('click', () => { splides[activeTab]?.go('<'); });
    if (nextArrow) nextArrow.addEventListener('click', () => { splides[activeTab]?.go('>'); });
  });
});


document.addEventListener("DOMContentLoaded", () => {
  const tabWidgets = document.querySelectorAll(".equipment-tabs");

  tabWidgets.forEach(widget => {
    const links = widget.querySelectorAll(".equipment-tabs__link");
    const contents = widget.querySelectorAll(".equipment-tabs__content");

    if (!links.length || !contents.length) return;


    function activateTab(tabName) {

      links.forEach(l => l.classList.remove("active"));
      contents.forEach(c => {
        c.classList.remove("active");
        c.style.display = "none";
      });


      const activeLink = widget.querySelector(`.equipment-tabs__link[data-tab="${tabName}"]`);
      const activeContent = widget.querySelector(`.equipment-tabs__content[data-tab="${tabName}"]`);

      if (activeLink) activeLink.classList.add("active");
      if (activeContent) {
        activeContent.classList.add("active");
        activeContent.style.display = "";
      }
    }


    links.forEach(link => {
      link.addEventListener("click", e => {
        e.preventDefault();
        const tabName = link.dataset.tab;
        if (tabName) activateTab(tabName);
      });
    });

    // При загрузке активный таб берём из верстки
    const defaultActive = widget.querySelector(".equipment-tabs__link.active");
    if (defaultActive && defaultActive.dataset.tab) {
      activateTab(defaultActive.dataset.tab);
    } else {
      // если в разметке active не проставлен — открыть первый
      const first = links[0];
      if (first && first.dataset.tab) activateTab(first.dataset.tab);
    }
  });
});

document.addEventListener('DOMContentLoaded', function () {
  const accordions = document.querySelectorAll('.equipment-tabs__content-acc');

  accordions.forEach(acc => {
    const items = acc.querySelectorAll('li');

    items.forEach(item => {
      const dt = item.querySelector('dt');
      const dd = item.querySelector('dd');
      if (!dt || !dd) return;

      // по умолчанию все закрыты
      dd.style.maxHeight = null;

      dt.addEventListener('click', () => {
        const isActive = item.classList.contains('active');

        if (isActive) {
          item.classList.remove('active');
          dd.style.maxHeight = null;
        } else {
          item.classList.add('active');
          dd.style.maxHeight = dd.scrollHeight + 'px';
        }
      });
    });
  });

  // функция для пересчёта открытых блоков
  function refreshAccordions() {
    document.querySelectorAll('.equipment-tabs__content-acc li.active dd')
      .forEach(dd => {
        dd.style.maxHeight = dd.scrollHeight + 'px';
      });
  }

  window.addEventListener('resize', refreshAccordions);
  document.addEventListener('tab-switched', refreshAccordions);
});



document.addEventListener('DOMContentLoaded', function () {
  const sliderExamples = document.querySelector('.examples-slider');
  if (!sliderExamples) return;

  let splide;

  function initSplide() {
    if (window.innerWidth <= 1500) {
      if (!splide) {
        splide = new Splide(sliderExamples, {
          type: 'loop',
          autoWidth: true,
          perMove: 1,
          pagination: false,
          arrows: false,
          gap: 20,
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


  const prevArrow = document.querySelector('.examples-arrow__prev');
  const nextArrow = document.querySelector('.examples-arrow__next');

  if (prevArrow) {
    prevArrow.addEventListener('click', () => splide?.go('<'));
  }
  if (nextArrow) {
    nextArrow.addEventListener('click', () => splide?.go('>'));
  }
});

document.addEventListener("DOMContentLoaded", () => {
  const desc = document.querySelector(".detail-product__layout-description");
  const toggleBtn = document.querySelector(".desc-toggle");

  if(!desc || desc) return;

  if (desc && toggleBtn) {
    // Показываем кнопку только на мобилке
    if (window.innerWidth <= 700) {
      toggleBtn.style.display = "inline-block";
    }

    toggleBtn.addEventListener("click", () => {
      desc.classList.toggle("expanded");
      if (desc.classList.contains("expanded")) {
        toggleBtn.textContent = "Скрыть";
      } else {
        toggleBtn.textContent = "Показать больше";
      }
    });
  }
});


  document.querySelectorAll('.player-wrapper').forEach(wrapper => {
    wrapper.addEventListener('click', () => {
      const videoId = wrapper.dataset.videoId;
      wrapper.innerHTML = `
        <iframe 
          width="100%" 
          height="100%" 
          src="https://rutube.ru/play/embed/${videoId}" 
          style="position:absolute;top:0;left:0;width:100%;height:100%;border:none;" 
          allow="clipboard-write" 
          allowfullscreen>
        </iframe>
      `;
    });
  });
