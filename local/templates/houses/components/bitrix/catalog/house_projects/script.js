function openFilterBlock() {
  const items = document.querySelectorAll(".ctalog-filters__acc-item");

  items.forEach(item => {
    const title = item.querySelector(".catalog-filter__acc-title");

    title.addEventListener("click", () => {

      item.classList.toggle("open");
    });
  });
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

function showFilters() {
  const trigger = document.querySelector(".catalog-filters__mobile-trigger");
  const filters = document.querySelector(".catalog-filters");
  const overlay = document.querySelector(".overlay");
  const dragLine = document.querySelector(".mobile-drag__line");
  const body = document.querySelector("body");

  let startY = 0;
  let isDragging = false;

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
  console.log('custom sort');
  let filterForm = document.querySelector('form.smartfilter');
  if(filterForm) {
    console.log('form');
    let hiddenSortField = filterForm.querySelector('input[name="sort_field"]');
    let hiddenSortOrder = filterForm.querySelector('input[name="sort_order"]');
    let hiddenSort = filterForm.querySelector('input[name="sort"]');
    document.querySelectorAll('.custom-select__options li').forEach(item => {
      item.addEventListener('click', function() {
        hiddenSortField.value = this.dataset.sortField;
        hiddenSortOrder.value = this.dataset.sortOrder;
        hiddenSort.value = this.dataset.sortKey;
        if (window.smartFilter) {
          smartFilter.keyup(hiddenSort);
          // или smartFilter.click(hiddenSort);
        }
      })
    })
  }
}
document.addEventListener("DOMContentLoaded", () => {
  openFilterBlock();
  showFilters();
  customSort();
})

BX.addCustomEvent('OnAjaxSuccess', function(){
  openFilterBlock();
  showFilters();
  customSort();
});