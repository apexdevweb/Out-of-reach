const tipsContainer = document.querySelectorAll(".tips__el");
const linkTips = document.querySelectorAll(".tips__el--link");
linkTips.forEach((linkEl, i) => {
  linkEl.addEventListener("click", () => {
   const openEl = tipsContainer[i].classList.toggle("viewTipsEl");
    const icon = linkEl.querySelector(".minusOrPlus")
    if (openEl) {
      icon.textContent = "-";
    } else {
      icon.textContent = "+";
    }
  });
});
