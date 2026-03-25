const mouseDataCtnr = document.getElementById("mouse_data");
document.addEventListener("mousemove", (e) => {
  const xPct = Math.round((e.clientX / window.innerWidth) * 100);
  const yPct = Math.round((e.clientY / window.innerHeight) * 100);
  mouseDataCtnr.textContent = `X${xPct}%-Y${yPct}%-`;
});
