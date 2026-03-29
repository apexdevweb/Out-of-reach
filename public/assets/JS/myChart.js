document.addEventListener("DOMContentLoaded", function () {
  const canvas = document.getElementById("myChart");
  if (!canvas) return;

  // On récupère les données cachées dans l'attribut data-visites du canvas
  const rawData = canvas.getAttribute("data-visites");
  const monthlyData = JSON.parse(rawData);
  const ctx = canvas.getContext("2d");
  // Création du dégradé
  const gradient = ctx.createLinearGradient(0, 0, ctx.canvas.width, 0);
  gradient.addColorStop(0, "#00fff0");
  gradient.addColorStop(1, "#0083fe");

  new Chart(ctx, {
    type: "line",
    data: {
      labels: [
        "Jan",
        "Fév",
        "Mar",
        "Avr",
        "Mai",
        "Juin",
        "Juil",
        "Août",
        "Sep",
        "Oct",
        "Nov",
        "Déc",
      ],
      datasets: [
        {
          label: "Nombre de visites sur le shield",
          data: monthlyData ,
          borderColor: gradient,
          pointBackgroundColor: "#fff",
          pointBorderColor: "#4284DB",
          tension: 0,
          borderWidth: 2,
          fill: true,
        },
      ],
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        y: { beginAtZero: true },
      },
    },
  });
});
