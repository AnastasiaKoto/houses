
class ProjectsSlider {
  constructor(selectorOrElement) {
    if (typeof selectorOrElement === 'string') {
      this.selector = selectorOrElement;
      this.elements = document.querySelectorAll(this.selector);
    } else if (selectorOrElement instanceof HTMLElement) {
      this.selector = null;
      this.elements = [selectorOrElement];
    } else {
      this.elements = [];
    }
    this.sliders = [];
    this.init();
  }

  init() {
    this.elements.forEach(sliderEl => {
      const splide = new Splide(sliderEl, {
        type: 'fade',
        perPage: 1,
        pagination: true,
        arrows: false,
        drag: false,
        speed: 600,
        easing: 'ease',
        breakpoints: {
          992: {
            drag: true,
          }
        }
      }).mount();

      const track = sliderEl.querySelector('.splide__track');

      const handleMouseMove = e => {
        if (window.innerWidth < 992) return;
        const rect = track.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const width = rect.width;
        const slidesCount = splide.length;
        const hoverZone = 15;

        let index = Math.floor((x / width) * slidesCount);
        if (x < hoverZone) index = 0;
        if (x > width - hoverZone) index = slidesCount - 1;

        splide.go(index);
      };

      const handleMouseLeave = e => {
        if (window.innerWidth < 992) return;
        splide.go(0);
      };

      track.addEventListener('mousemove', handleMouseMove);
      track.addEventListener('mouseleave', handleMouseLeave);

      this.sliders.push({ splide, track, handleMouseMove, handleMouseLeave });
    });
  }

  destroy() {
    this.sliders.forEach(({ splide, track, handleMouseMove, handleMouseLeave }) => {
      track.removeEventListener('mousemove', handleMouseMove);
      track.removeEventListener('mouseleave', handleMouseLeave);
      splide.destroy();
    });
    this.sliders = [];
  }

  reinit() {
    this.destroy();
    this.init();
  }
}


document.addEventListener("DOMContentLoaded", function () {
  const menuItems = document.querySelectorAll(".nav-menu > li");

  menuItems.forEach((item) => {
    const link = item.querySelector("a");
    const submenu = item.querySelector(".nav-submenu");

    if (submenu) {
      link.addEventListener("click", (e) => {
        e.preventDefault();

        menuItems.forEach((otherItem) => {
          if (otherItem !== item) {
            otherItem.classList.remove("active");
            const otherSubmenu = otherItem.querySelector(".nav-submenu");
            if (otherSubmenu) {
              otherSubmenu.classList.remove("active");
            }
          }
        });


        item.classList.toggle("active");
        submenu.classList.toggle("active");
      });
    }
  });


  document.addEventListener("click", (e) => {
    if (!e.target.closest(".nav-menu")) {
      menuItems.forEach((item) => {
        item.classList.remove("active");
        const submenu = item.querySelector(".nav-submenu");
        if (submenu) {
          submenu.classList.remove("active");
        }
      });
    }
  });
});


document.addEventListener("DOMContentLoaded", function () {
  const header = document.querySelector("header");
  const headerHeight = header.offsetHeight;

  window.addEventListener("scroll", function () {
    if (window.scrollY > headerHeight) {
      header.classList.add("fixed");
    } else {
      header.classList.remove("fixed");
    }
  });
});



document.addEventListener("DOMContentLoaded", () => {
  const burger = document.querySelector(".burger");
  const navMenu = document.querySelector(".nav-menu");
  const overlay = document.querySelector(".overlay");

  if (burger && navMenu && overlay) {
    burger.addEventListener("click", () => {
      burger.classList.toggle("active");
      navMenu.classList.toggle("active");
      overlay.classList.toggle("active");
    });

    overlay.addEventListener("click", () => {
      burger.classList.remove("active");
      navMenu.classList.remove("active");
      overlay.classList.remove("active");
    });
  }
});

//устраняем конфликт одинаковых форм
/*
document.addEventListener('DOMContentLoaded', function() {
  document.body.addEventListener('click', function(e) {
    if (e.target.closest('.js-modal-form-submit')) {
      e.preventDefault();
      const form = e.target.closest('form');
      BX.ajax.submit(form, 'modal');
    }
    
    if (e.target.closest('.js-footer-form-submit')) {
      e.preventDefault(); 
      const form = e.target.closest('form');
      BX.ajax.submit(form, 'footer');
    }
  });
});*/

// document.addEventListener("DOMContentLoaded", () => {
//   const accordions = document.querySelectorAll('.questions-acc');
//   if (!accordions.length) return;

//   accordions.forEach(accordion => {
//     const items = accordion.querySelectorAll('.question-acc__item');

//     items.forEach(item => {
//       const title = item.querySelector('.questions-acc__title');
//       const content = item.querySelector('.question-acc__content');
//       if (!title || !content) return;

//       const style = window.getComputedStyle(content);
//       const paddingBottom = parseFloat(style.paddingBottom) || 20;

//       if (item.classList.contains('active')) {
//         content.style.maxHeight = content.scrollHeight + paddingBottom + "px";
//       } else {
//         content.style.maxHeight = "0px";
//       }

//       title.addEventListener('click', () => {
//         const isActive = item.classList.contains('active');

//         // Закрываем все элементы в этом аккордеоне
//         items.forEach(i => {
//           const c = i.querySelector('.question-acc__content');
//           if (i !== item) {
//             i.classList.remove('active');
//             c.style.maxHeight = "0px";
//           }
//         });

//         // Переключаем текущий элемент
//         if (isActive) {
//           item.classList.remove('active');
//           content.style.maxHeight = "0px";
//         } else {
//           item.classList.add('active');
//           content.style.maxHeight = content.scrollHeight + paddingBottom + "px";
//         }
//       });
//     });
//   });
// });


document.addEventListener("DOMContentLoaded", () => {
  const accordions = document.querySelectorAll('.questions-acc');
  if (!accordions.length) return;

  accordions.forEach(accordion => {
    const items = accordion.querySelectorAll('.question-acc__item');

    items.forEach(item => {
      const title = item.querySelector('.questions-acc__title');
      const content = item.querySelector('.question-acc__content');
      if (!title || !content) return;

      const style = window.getComputedStyle(content);
      const paddingBottom = parseFloat(style.paddingBottom) || 20;

      if (item.classList.contains('active')) {
        content.style.maxHeight = content.scrollHeight + paddingBottom + "px";
      } else {
        content.style.maxHeight = "0px";
      }

      title.addEventListener('click', () => {
        const isActive = item.classList.contains('active');

        if (isActive) {
          item.classList.remove('active');
          content.style.maxHeight = "0px";
        } else {
          item.classList.add('active');
          content.style.maxHeight = content.scrollHeight + paddingBottom + "px";
        }
      });
    });
  });
});




// document.addEventListener('DOMContentLoaded', () => {
//   document.querySelectorAll('.float-input').forEach(wrapper => {
//     const input = wrapper.querySelector('input');

//     // если при загрузке уже есть значение — ставим актив
//     if (input.value && input.value.trim() !== '') {
//       wrapper.classList.add('active');
//     }

//     input.addEventListener('focus', () => {
//       wrapper.classList.add('active');
//     });

//     input.addEventListener('blur', () => {
//       if (!input.value || input.value.trim() === '') {
//         wrapper.classList.remove('active');
//       }
//     });

//     // на input (ввод) — чтобы в реальном времени реагировать на вставку/удаление
//     input.addEventListener('input', () => {
//       if (input.value && input.value.trim() !== '') {
//         wrapper.classList.add('active');
//       } else {
//         wrapper.classList.remove('active');
//       }
//     });
//   });
// });
(() => {
  const INPUT_SELECTOR = 'input, textarea';
  const DEBUG = false;
  const log = (...args) => { if (DEBUG) console.log('[float-input]', ...args); };

  function isFilled(input) {
    if (!input) return false;
    const raw = String(input.value || '').trim();


    if (raw !== '') return true;


    if (raw.replace(/\D/g, '').length > 0) return true;


    try {
      if (typeof input.inputmask?.unmaskedvalue === 'function') {
        const u = String(input.inputmask.unmaskedvalue() || '').trim();
        if (u !== '' && u.replace(/\D/g, '').length > 0) return true;
      }
      // некоторые либы хранят unmaskedValue как свойство
      if (typeof input.unmaskedValue === 'function') {
        const u = String(input.unmaskedValue() || '').trim();
        if (u !== '' && u.replace(/\D/g, '').length > 0) return true;
      }
    } catch (err) {

      log('mask lib check error', err);
    }

    return false;
  }

  function updateWrapper(wrapper) {
    if (!wrapper) return;
    const input = wrapper.querySelector(INPUT_SELECTOR);
    if (!input) return;
    if (isFilled(input)) {
      wrapper.classList.add('active');
      log('activated', input);
    } else {
      wrapper.classList.remove('active');
      log('deactivated', input);
    }
  }

  function initWrapper(wrapper) {
    if (!wrapper || wrapper.__floatInitDone) return;
    const input = wrapper.querySelector(INPUT_SELECTOR);
    if (!input) return;

    wrapper.__floatInitDone = true;


    updateWrapper(wrapper);


    const onFocus = () => wrapper.classList.add('active');
    const onCheck = () => updateWrapper(wrapper);

    input.addEventListener('focus', onFocus, true);
    input.addEventListener('input', onCheck, true);
    input.addEventListener('change', onCheck, true);
    input.addEventListener('paste', onCheck, true);
    input.addEventListener('cut', onCheck, true);
    input.addEventListener('blur', () => setTimeout(onCheck, 10), true);


    const mo = new MutationObserver(muts => {
      for (const m of muts) {
        if (m.type === 'attributes') {
          if (m.attributeName === 'value' || m.attributeName === 'data-mask-applied' || m.attributeName === 'placeholder') {
            updateWrapper(wrapper);
          }
        }
      }
    });
    mo.observe(input, { attributes: true, attributeFilter: ['value', 'data-mask-applied', 'placeholder'] });
    wrapper.__floatInputMO = mo;

    log('init wrapper', wrapper);
  }

  function initAll() {
    document.querySelectorAll('.float-input').forEach(initWrapper);
  }


  function delegatedHandler(e) {
    const target = e.target;
    if (!target) return;
    const wrapper = target.closest('.float-input');
    if (!wrapper) return;
    if (e.type === 'focus') {
      wrapper.classList.add('active');
    } else if (e.type === 'blur') {
      setTimeout(() => updateWrapper(wrapper), 10);
    } else {
      updateWrapper(wrapper);
    }
  }
  ['input', 'change', 'paste', 'cut'].forEach(ev => document.addEventListener(ev, delegatedHandler, true));
  document.addEventListener('focus', delegatedHandler, true);
  document.addEventListener('blur', delegatedHandler, true);

  // Следим за динамически добавляемыми .float-input в DOM
  const docObserver = new MutationObserver(muts => {
    for (const m of muts) {
      if (m.type === 'childList' && m.addedNodes.length) {
        m.addedNodes.forEach(node => {
          if (!(node instanceof Element)) return;
          if (node.matches && node.matches('.float-input')) initWrapper(node);
          node.querySelectorAll && node.querySelectorAll('.float-input').forEach(initWrapper);
        });
      }
    }
  });
  docObserver.observe(document.documentElement || document.body, { childList: true, subtree: true });


  window.updateFloatInputs = function () {
    initAll();
    document.querySelectorAll('.float-input').forEach(updateWrapper);
  };

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initAll);
  } else {
    initAll();
  }



})();

const customSelectTrigger = () => {
  document.querySelectorAll(".custom-select, .custom-select-cornored").forEach(select => {
    const trigger = select.querySelector(".custom-select__trigger");
    const value = select.querySelector(".custom-select__value");
    const options = select.querySelectorAll(".custom-select__options li");
    const hidden = select.querySelector("input[type=hidden]");

    trigger.addEventListener("click", (e) => {
      e.stopPropagation(); // чтобы клик не "всплывал" на document
      select.classList.toggle("open");
    });

    options.forEach(option => {
      option.addEventListener("click", (e) => {
        e.stopPropagation();
        value.textContent = option.textContent;
        hidden.value = option.dataset.value;
        select.classList.add("active");
        select.classList.remove("open");
      });
    });

    // клик вне селекта — закрываем
    document.addEventListener("click", () => {
      select.classList.remove("open");
    });
  });
}


function getUrlParameter(name) {
  const urlParams = new URLSearchParams(window.location.search);
  return urlParams.get(name);
}

function checkAcceptedSort() {
  const sortParam = getUrlParameter('sort');
  if (sortParam) {
    const sortElement = document.querySelector(`li[data-sort-key="${sortParam}"]`);
    if (sortElement) {
      const customSelectValue = document.querySelector('.custom-select__value');
      if (customSelectValue) {
        customSelectValue.textContent = sortElement.textContent;
      }
    }
  }
}

document.addEventListener("DOMContentLoaded", () => {
  customSelectTrigger();
  checkAcceptedSort();
});

BX.addCustomEvent('OnAjaxSuccess', function () {
  customSelectTrigger();
  setTimeout(checkAcceptedSort, 300);
  applyPhoneMask();
})

// document.addEventListener("DOMContentLoaded", () => {
//   document.querySelectorAll(".custom-select-bubbles-js").forEach(select => {
//     const trigger = select.querySelector(".selected");
//     const options = select.querySelectorAll(".options li");
//     const bubblesContainer = select.querySelector(".selected-bubbles");

//     let selectedValues = [];

//     function updatePlaceholder() {
//       if (selectedValues.length === 0) {
//         trigger.textContent = "Выберите вариант";
//       } else {
//         trigger.textContent = `Выбрано ${selectedValues.length} ${getPluralForm(selectedValues.length, ['постройка', 'постройки', 'построек'])}`;
//       }
//     }

//     function getPluralForm(n, forms) {
//       // forms = ['постройка', 'постройки', 'построек']
//       const n10 = n % 10, n100 = n % 100;
//       if (n10 === 1 && n100 !== 11) return forms[0];
//       if (n10 >= 2 && n10 <= 4 && (n100 < 10 || n100 >= 20)) return forms[1];
//       return forms[2];
//     }

//     trigger.addEventListener("click", (e) => {
//       e.stopPropagation();
//       select.classList.toggle("open");
//     });

//     options.forEach(option => {
//       option.addEventListener("click", (e) => {
//         e.stopPropagation();
//         const value = option.dataset.value;

//         if (option.classList.contains("active")) {
//           // снять выбор
//           option.classList.remove("active");
//           selectedValues = selectedValues.filter(v => v.value !== value);
//           const bubble = bubblesContainer.querySelector(`[data-value="${value}"]`);
//           if (bubble) bubble.remove();
//         } else {
//           // добавить выбор
//           option.classList.add("active");
//           const optionText = option.innerHTML;
//           selectedValues.push({ value, text: optionText });

//           const bubble = document.createElement("div");
//           bubble.className = "bubble";
//           bubble.dataset.value = value;
//           bubble.innerHTML = optionText;
//           bubblesContainer.appendChild(bubble);
//         }

//         updatePlaceholder();
//       });
//     });

//     document.addEventListener("click", () => {
//       select.classList.remove("open");
//     });
//   });
// });

//забрала в класс
/*
document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll(".custom-select-bubbles-js").forEach(select => {
    const trigger = select.querySelector(".selected");
    const options = select.querySelectorAll(".options li");
    const bubblesContainer = select.querySelector(".selected-bubbles");

    let selectedValues = [];

    function updatePlaceholder() {
      if (selectedValues.length === 0) {
        trigger.textContent = "Выберите вариант";
      } else {
        trigger.textContent = `Выбрано ${selectedValues.length} ${getPluralForm(selectedValues.length, ['постройка', 'постройки', 'построек'])}`;
      }
    }

    function getPluralForm(n, forms) {
      const n10 = n % 10, n100 = n % 100;
      if (n10 === 1 && n100 !== 11) return forms[0];
      if (n10 >= 2 && n10 <= 4 && (n100 < 10 || n100 >= 20)) return forms[1];
      return forms[2];
    }

    trigger.addEventListener("click", (e) => {
      e.stopPropagation();
      select.classList.toggle("open");
    });

    options.forEach(option => {
      option.addEventListener("click", (e) => {
        e.stopPropagation();
        const value = option.dataset.value;

        if (option.classList.contains("active")) {
          // снять выбор
          removeValue(value);
        } else {
          // добавить выбор
          option.classList.add("active");
          const optionText = option.innerHTML;
          selectedValues.push({ value, text: optionText });

          const bubble = document.createElement("div");
          bubble.className = "bubble";
          bubble.dataset.value = value;
          bubble.innerHTML = `
            <span class="bubble-text">${optionText}</span>
            <button class="bubble-remove" type="button"><svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M5.00058 5.00291L8.49565 8.49797M1.50549 8.49797L5.00058 5.00291L1.50549 8.49797ZM8.49565 1.50781L5.00058 5.00291L8.49565 1.50781ZM5.00058 5.00291L1.50549 1.50781L5.00058 5.00291Z" stroke="#8E9293" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            </button>
          `;
          bubblesContainer.appendChild(bubble);

          bubble.querySelector(".bubble-remove").addEventListener("click", () => {
            removeValue(value);
          });
        }

        updatePlaceholder();
      });
    });

    function removeValue(value) {
      const option = select.querySelector(`.options li[data-value="${value}"]`);
      if (option) option.classList.remove("active");

      selectedValues = selectedValues.filter(v => v.value !== value);

      const bubble = bubblesContainer.querySelector(`.bubble[data-value="${value}"]`);
      if (bubble) bubble.remove();

      updatePlaceholder();
    }

    document.addEventListener("click", () => {
      select.classList.remove("open");
    });
  });
});
*/



function inputCallback() {
  let input = this.value.replace(/\D/g, '');

  if (input.startsWith('8')) {
    input = '7' + input.slice(1);
  } else if (!input.startsWith('7')) {
    input = '7' + input;
  }

  input = input.substring(0, 11);

  let formatted = '+7';
  if (input.length > 1) {
    formatted += ' (' + input.substring(1, 4);
  }
  if (input.length >= 5) {
    formatted += ') ' + input.substring(4, 7);
  }
  if (input.length >= 8) {
    formatted += '-' + input.substring(7, 9);
  }
  if (input.length >= 10) {
    formatted += '-' + input.substring(9, 11);
  }

  this.value = formatted;
}

function focusCallback() {
  if (!this.value) {
    this.value = '+7 (';
  }
}

function blurCallback() {
  if (this.value === '+7 (' || this.value === '+7') {
    this.value = '';
  }
}

function applyPhoneMaskToInput(phoneInput) {
  if (phoneInput.dataset.maskApplied) return;

  phoneInput.dataset.maskApplied = "true";

  phoneInput.addEventListener('input', inputCallback);

  phoneInput.addEventListener('focus', focusCallback);

  phoneInput.addEventListener('blur', blurCallback);
}

function applyPhoneMask() {
  const inputs = document.querySelectorAll('input[type="tel"]');
  //console.log('Телефонные поля:', inputs);
  inputs.forEach(applyPhoneMaskToInput);
}

document.addEventListener('DOMContentLoaded', function () {
  setTimeout(applyPhoneMask, 100); // дать DOM прогрузиться
});

// modifiend
document.addEventListener("DOMContentLoaded", () => {
  const overlay = document.querySelector(".overlay");

  function openModal(modal) {
    modal.classList.add("active");
    overlay.classList.add("active");
    document.documentElement.classList.add("lock");
  }

  function closeModal(modal) {
    modal.classList.remove("active");
    overlay.classList.remove("active");
    document.documentElement.classList.remove("lock");
  }


  document.querySelectorAll("[data-modal-target]").forEach(btn => {
    btn.addEventListener("click", () => {
      const target = btn.getAttribute("data-modal-target");
      const modal = document.querySelector(target);
      if (modal) openModal(modal);
    });
  });



  document.querySelectorAll(".modal-close").forEach(btn => {
    btn.addEventListener("click", () => {
      const modal = btn.closest(".modal");
      if (modal) closeModal(modal);
    });
  });


  overlay?.addEventListener("click", () => {
    document.querySelectorAll(".modal.active").forEach(modal => closeModal(modal));
  });

  document.querySelectorAll(".modal").forEach(modal => {
    modal.addEventListener("click", e => {
      if (!e.target.closest(".modal-inner")) closeModal(modal);
    });
  });
});



document.addEventListener('DOMContentLoaded', () => {
  const selects = document.querySelectorAll('.custom-select-js');

  selects.forEach(select => {
    const selected = select.querySelector('.selected');
    const inpHidden = select.querySelector('input[name="HOUSES_SQUARES"]');
    const options = select.querySelector('.options');

    selected.addEventListener('click', () => {
      const isOpen = select.classList.contains('open');
      document.querySelectorAll('.custom-select-js.open').forEach(s => s.classList.remove('open'));
      if (!isOpen) select.classList.add('open');
    });

    options.querySelectorAll('li').forEach(option => {
      option.addEventListener('click', () => {
        options.querySelectorAll('li').forEach(o => o.classList.remove('active'));
        option.classList.add('active');

        selected.innerHTML = option.innerHTML;
        if (inpHidden) {
          inpHidden.value = option.textContent;
        }

        // Закрываем селект
        select.classList.remove('open');

        console.log('Selected value:', option.dataset.value);
      });
    });
  });

  document.addEventListener('click', (e) => {
    if (!e.target.closest('.custom-select-js')) {
      document.querySelectorAll('.custom-select-js.open').forEach(s => s.classList.remove('open'));
    }
  });
});

document.addEventListener('DOMContentLoaded', function () {

  const projectsSlider = new ProjectsSlider('.projects-slider__images');

  projectsSlider.reinit();
});

document.addEventListener("DOMContentLoaded", () => {
  const movableItems = document.querySelectorAll("[data-move-target]");

  if (!movableItems.length) return;

  const moveElements = () => {
    movableItems.forEach(item => {
      const targetSelector = item.dataset.moveTarget;
      const breakpoint = parseInt(item.dataset.moveBreak) || 700;
      const target = document.querySelector(targetSelector);
      const originalParent = item.parentNode;
      const originalNext = item.nextElementSibling;

      if (!target || !originalParent) return;

      if (window.innerWidth <= breakpoint) {
        if (!item.classList.contains("moved")) {
          target.insertAdjacentElement("afterend", item);
          item.classList.add("moved");
        }
      } else {
        if (item.classList.contains("moved")) {
          if (originalNext) {
            originalParent.insertBefore(item, originalNext);
          } else {
            originalParent.appendChild(item);
          }
          item.classList.remove("moved");
        }
      }
    });
  };

  moveElements();
  window.addEventListener("resize", moveElements);
});

document.addEventListener('DOMContentLoaded', () => {

  const anchorLinks = document.querySelectorAll('a[href^="#"]');
  if (!anchorLinks) return;

  anchorLinks.forEach(link => {
    link.addEventListener('click', e => {
      const targetId = link.getAttribute('href').substring(1);
      const targetEl = document.getElementById(targetId);

      if (targetEl) {
        e.preventDefault();

        const offset = 100;
        const topPos = targetEl.getBoundingClientRect().top + window.pageYOffset - offset;

        window.scrollTo({
          top: topPos,
          behavior: 'smooth'
        });
      }
    });
  });
});


document.addEventListener('DOMContentLoaded', () => {
  const cookieBlocks = document.querySelectorAll('.cookie');

  if (!cookieBlocks.length) return;

  const now = Date.now();

  cookieBlocks.forEach(cookieBlock => {
    const agreedBtns = cookieBlock.querySelectorAll('.cookie-agreed');

    const cookieAccepted = localStorage.getItem('cookieAccepted');
    const cookieExpire = localStorage.getItem('cookieExpire');

    if (cookieAccepted === 'true' && cookieExpire && now < Number(cookieExpire)) {
      cookieBlock.classList.add('inactive');
    }

    agreedBtns.forEach(btn => {
      btn.addEventListener('click', () => {
        cookieBlock.classList.add('inactive');

        const expireTime = now + 14 * 24 * 60 * 60 * 1000; 

        localStorage.setItem('cookieAccepted', 'true');
        localStorage.setItem('cookieExpire', expireTime);
      });
    });
  });
});

