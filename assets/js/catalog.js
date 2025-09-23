document.addEventListener('DOMContentLoaded', function () {
  const slidersCatalog = document.querySelectorAll('.catalog-item__images');

  slidersCatalog.forEach(slider => {
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


document.addEventListener("DOMContentLoaded", () => {
  const items = document.querySelectorAll(".ctalog-filters__acc-item");

  items.forEach(item => {
    const title = item.querySelector(".catalog-filter__acc-title");

    title.addEventListener("click", () => {

      item.classList.toggle("open");
    });
  });
});


