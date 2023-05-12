export const chartColors = {
  default: {
    primary: "#00D1B2",
    info: "#209CEE",
    danger: "#FF3860",

    // Dashboard Colors
    dashboardPendientes: '#6B7280',
    dashboardEnCurso: '#3B82F6',
		dashboardAjustes: '#FB9206',
		dashboardTest: '#8B5CF6',
		dashboardQa: '#0EA5E9',
		dashboardFinalizada: '#10B981',
  },
};

const randomChartData = (n) => {
  const data = [];

  for (let i = 0; i < n; i++) {
    data.push(Math.round(Math.random() * 200));
  }

  return data;
};

const datasetObject = (color, points) => {
  return {
    fill: false,
    borderColor: chartColors.default[color],
    borderWidth: 2,
    borderDash: [],
    borderDashOffset: 0.0,
    pointBackgroundColor: chartColors.default[color],
    pointBorderColor: "rgba(255,255,255,0)",
    pointHoverBackgroundColor: chartColors.default[color],
    pointBorderWidth: 20,
    pointHoverRadius: 4,
    pointHoverBorderWidth: 15,
    pointRadius: 4,
    data: randomChartData(points),
    tension: 0.5,
    cubicInterpolationMode: "default",
  };
};

export const rendimientoTareas = (points = 6) => {
  const labels = [
    'Lunes',
    'Martes',
    'Miercoles',
    'Jueves',
    'Viernes',
    'Sabado',
  ];

  return {
    labels,
    datasets: [
      datasetObject("dashboardPendientes", points),
      datasetObject("dashboardEnCurso", points),
      datasetObject("dashboardAjustes", points),
      datasetObject("dashboardTest", points),
      datasetObject("dashboardQa", points),
      datasetObject("dashboardFinalizada", points),
    ],
  };
};
