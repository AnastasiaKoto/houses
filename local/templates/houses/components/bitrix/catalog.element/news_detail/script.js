document.addEventListener("DOMContentLoaded", () => {
  const content = document.querySelector(".news-detail-content");
  const sideLinks = document.querySelector(".news-detail__side-links");
  const offset = 100; 

  if (content && sideLinks) {
    const headings = content.querySelectorAll("h2[id]");
    sideLinks.innerHTML = "";

    headings.forEach((heading, index) => {
      const link = document.createElement("a");
      link.href = `#${heading.id}`;
      link.textContent = heading.textContent.trim();

      if (index === 0) {
        link.classList.add("current");
      }

      link.addEventListener("click", (e) => {
        e.preventDefault();

        const target = document.getElementById(heading.id);
        const y = target.getBoundingClientRect().top + window.scrollY - offset;

        window.scrollTo({
          top: y,
          behavior: "smooth"
        });
      });

      sideLinks.appendChild(link);
    });

    window.addEventListener("scroll", () => {
      let fromTop = window.scrollY + offset;

      headings.forEach((heading, i) => {
        const link = sideLinks.querySelectorAll("a")[i];
        if (
          heading.offsetTop <= fromTop &&
          heading.offsetTop + heading.offsetHeight > fromTop
        ) {
          sideLinks.querySelectorAll("a").forEach(a => a.classList.remove("current"));
          link.classList.add("current");
        }
      });
    });
  }
});