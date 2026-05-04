const mouseDataCtnr = document.getElementById("mouse_data");
const mousClickCtnr = document.getElementById("mouse_click_data");
const mousInfoCtnr = document.getElementById("info_click_data");
document.addEventListener("mousemove", (e) => {
  const xPct = Math.round((e.clientX / window.innerWidth) * 100);
  const yPct = Math.round((e.clientY / window.innerHeight) * 100);
  mouseDataCtnr.textContent = `X${xPct}%-Y${yPct}%-`;
});
document.addEventListener("click", (e) => {
  const xPct = Math.round((e.clientX / window.innerWidth) * 100);
  const yPct = Math.round((e.clientY / window.innerHeight) * 100);
  const domClicked = `X${xPct}%-Y${yPct}%`;
  mousClickCtnr.textContent = "Your last click";
  mousInfoCtnr.textContent = domClicked;
});
document.addEventListener('contextmenu', (e) => {
  e.preventDefault();
});
