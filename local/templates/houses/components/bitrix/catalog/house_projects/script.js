document.addEventListener('DOMContentLoaded', function () {
  const slidersCatalog = document.querySelectorAll('.catalog-item__images');

  slidersCatalog.forEach(slider => {
    const splide = new Splide(slider, {
      type: 'fade',
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


const showFilterItems = () => {
  const items = document.querySelectorAll(".ctalog-filters__acc-item");

  items.forEach(item => {
    const title = item.querySelector(".catalog-filter__acc-title");

    title.addEventListener("click", () => {

      item.classList.toggle("open");
    });
  });
}

const filters = () => {
  const trigger = document.querySelector(".catalog-filters__mobile-trigger");
  const filters = document.querySelector(".catalog-filters");
  const overlay = document.querySelector(".overlay");
  const dragLine = document.querySelector(".mobile-drag__line");
  const body = document.querySelector("body");

  if(!trigger || !filters) return;
  let startY = 0;
  let isDragging = false;

  if(overlay.classList.contains("active", "half") || body.classList.contains("lock") || filters.classList.contains("active")) {
    closeFilters();
  }

  function openFilters() {
    filters.classList.add("active", "half");
    overlay.classList.add("active");
    body.classList.add("lock");
  }

  function closeFilters() {
    filters.classList.remove("active", "half", "full");
    overlay.classList.remove("active");
    body.classList.remove("lock");
  }

  function expandFilters() {
    filters.classList.remove("half");
    filters.classList.add("full");
  }

  trigger?.addEventListener("click", openFilters);
  overlay?.addEventListener("click", closeFilters);

  dragLine?.addEventListener("touchstart", (e) => {
    startY = e.touches[0].clientY;
    isDragging = true;
  });

  dragLine?.addEventListener("touchend", (e) => {
    if (!isDragging) return;
    isDragging = false;

    const endY = e.changedTouches[0].clientY;
    const deltaY = endY - startY;

    // Потянули вверх
    if (deltaY < -30 && filters.classList.contains("half")) {
      expandFilters();
    }

    // Потянули вниз
    if (deltaY > 30) {
      closeFilters();
    }
  });
}


//сортировка
function customSort() {
  let filterForm = document.querySelector('form.smartfilter');
  if(filterForm) {
    let hiddenSortField = filterForm.querySelector('input[name="sort_field"]');
    let hiddenSortOrder = filterForm.querySelector('input[name="sort_order"]');
    let hiddenSort = filterForm.querySelector('input[name="sort"]');
    document.querySelectorAll('.custom-select__options li').forEach(item => {
      item.addEventListener('click', function() {
        hiddenSortField.value = this.dataset.sortField;
        hiddenSortOrder.value = this.dataset.sortOrder;
        hiddenSort.value = this.dataset.sortKey;
        if (window.smartFilter) {
          hiddenSort.setAttribute('data-is-sorting', 'true');
          smartFilter.keyup(hiddenSort);
          //smartFilter.click(hiddenSort);
        }
      })
    })
  }
}

function checkFilters() {
  const form = document.querySelector('.catalog-filters__form');
  if (!form) return;

  const btnCount = document.querySelector('.btn-count');
  if (!btnCount) return;

  
  const count = countActiveFilters(form);

  if(btnCount.classList.contains('hidden') && count > 0) {
    btnCount.classList.remove('hidden');
    if(count > 1) {
      btnCount.innerHTML = `<span>${count}</span> фильтра включены`
    } else {
      btnCount.querySelector('span').textContent = count;
    }
  } else if(count <= 0) {
    btnCount.classList.add('hidden');
  }
}


// Функция подсчёта активных фильтров по группам
function countActiveFilters(form) {
  const checkboxes = form.querySelectorAll('input[type="checkbox"]');
  const groups = new Set();

  checkboxes.forEach(checkbox => {
    if (!checkbox.checked) return;

    const name = checkbox.name;

    // Группировка для arrFilter_XX_*
    if (name.startsWith('arrFilter_')) {
      const match = name.match(/^arrFilter_(\d+)/);
      if (match) {
        groups.add('arrFilter_' + match[1]);
      }
    }
    // Группировка для диапазонов
    else if (name === 'price_ranges[]') {
      groups.add('price_ranges');
    }
    else if (name === 'square_ranges[]') {
      groups.add('square_ranges');
    }
  });

  return groups.size;
}

document.addEventListener("DOMContentLoaded", () => {
 filters();
 showFilterItems();
 customSort();
 checkFilters();
});

BX.addCustomEvent('OnAjaxSuccess', function(){
  filters();
  showFilterItems();
  customSort();
  setTimeout(checkFilters, 300);
})