const allCase = document.querySelectorAll(".grid__el--ctnr");

allCase.forEach((myCases) => {
  myCases.addEventListener("click", () => {
    if (myCases.classList.contains("case__expansion")) {
      myCases.classList.remove("case__expansion");
    } else {
      myCases.classList.add("case__expansion");
    }
  });
});
