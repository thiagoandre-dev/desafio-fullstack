import { IconAward, IconUser } from "@tabler/icons-react";
import Desenvolvedores from "./pages/Desenvolvedores";
import Niveis from "./pages/Niveis";

export default [
  {
    label: "Desenvlvedores",
    icon: IconUser,
    page: Desenvolvedores,
  },
  {
    label: "Níveis",
    icon: IconAward,
    page: Niveis,
  }
]