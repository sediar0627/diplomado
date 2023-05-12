import {
  mdiAccountCircle,
  mdiMonitor,
  mdiViewList,
} from "@mdi/js";

export default [
  {
    to: "/profile",
    label: "Mi perfil",
    icon: mdiAccountCircle,
  },
  {
    label: "Proyectos",
    icon: mdiViewList,
    menu: [
      {
        label: "Listado de proyectos",
        route: "proyectos.index",
      },
      {
        label: "Nuevo proyecto",
        route: "proyectos.create",
      },
    ],
  },
  {
    label: "Dashboards",
    icon: mdiMonitor,
    menu: [],
  },
  {
    label: "Tableros",
    icon: mdiViewList,
    menu: [],
  },
];
