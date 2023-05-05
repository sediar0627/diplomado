import {
  mdiAccount,
  mdiLogout,
  mdiThemeLightDark,
} from "@mdi/js";

export default [
  {
    icon: mdiThemeLightDark,
    label: "Light/Dark",
    isDesktopNoLabel: true,
    isToggleLightDark: true,
  },
  {
    isCurrentUser: true,
    menu: [
      {
        icon: mdiAccount,
        label: "Mi perfil",
        to: "/profile",
      },
      {
        isDivider: true,
      },
      {
        icon: mdiLogout,
        label: "Cerrar Sesíon",
        isLogout: true,
      },
    ],
  }
];
