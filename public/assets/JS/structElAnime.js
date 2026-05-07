const allCase = document.querySelectorAll(".grid__el--ctnr");

allCase.forEach((myCases) => {
  myCases.addEventListener("click", () => {
      myCases.classList.toggle("case__expansion");
  });
});
