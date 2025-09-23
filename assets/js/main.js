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


document.addEventListener("DOMContentLoaded", () => {
  const accordionItems = document.querySelectorAll('.question-acc__item');
  if(!accordionItems) return;

  accordionItems.forEach(item => {
    const title = item.querySelector('.questions-acc__title');
    title.addEventListener('click', () => {
      accordionItems.forEach(i => {
        if (i !== item) i.classList.remove('active');
      });

      item.classList.toggle('active');
    });
  });
});


document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.float-input').forEach(wrapper => {
    const input = wrapper.querySelector('input');

    // если при загрузке уже есть значение — ставим актив
    if (input.value && input.value.trim() !== '') {
      wrapper.classList.add('active');
    }

    input.addEventListener('focus', () => {
      wrapper.classList.add('active');
    });

    input.addEventListener('blur', () => {
      if (!input.value || input.value.trim() === '') {
        wrapper.classList.remove('active');
      }
    });

    // на input (ввод) — чтобы в реальном времени реагировать на вставку/удаление
    input.addEventListener('input', () => {
      if (input.value && input.value.trim() !== '') {
        wrapper.classList.add('active');
      } else {
        wrapper.classList.remove('active');
      }
    });
  });
});



document.addEventListener("DOMContentLoaded", () => {
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
});




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

  document.querySelectorAll(".modal").forEach(modal => {
    const closeBtn = modal.querySelector(".modal-close");

    if (closeBtn) {
      closeBtn.addEventListener("click", () => closeModal(modal));
    }

    overlay.addEventListener("click", () => closeModal(modal));

    modal.addEventListener("click", e => {
      if (!e.target.closest(".modal-inner")) closeModal(modal);
    });
  });
});
// modifiend



