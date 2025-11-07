document.addEventListener('DOMContentLoaded', function () {
  const sliderCompany = document.querySelector('.company-ms__slider.splide');
  if (!sliderCompany) return;

  let splideInstance = null;

  function checkWidth() {

    if (window.innerWidth < 1100) {
      if (!splideInstance) {
        splideInstance = new Splide(sliderCompany, {
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

      if (splideInstance) {
        splideInstance.destroy();
        splideInstance = null;
      }
    }
  }

  window.addEventListener('resize', checkWidth);
  checkWidth();
});