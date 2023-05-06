import {
  mdiAccountCircle,
  mdiMonitor,
  mdiSquareEditOutline,
  mdiTable,
  mdiViewList,
} from "@mdi/js";

export default [
  {
    route: "dashboard",
    icon: mdiMonitor,
    label: "Dashboard",
  },
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
      },
      {
        label: "Nuevo proyecto",
      },
    ],
  },
  {
    label: "Sprints",
    icon: mdiViewList,
    menu: [
      {
        label: "Listado de sprints",
      },
      {
        label: "Nuevo sprint",
      },
    ],
  },
  {
    label: "Tableros",
    icon: mdiViewList,
    menu: [
      {
        label: "ScrumPro",
        href: "/tableros?tablero=ScrumPro",
      },
      {
        label: "Alcon",
        href: "/tableros?tablero=Alcon",
      },
    ],
  },
  {
    to: "/forms",
    label: "Informes",
    icon: mdiSquareEditOutline,
  }
];
