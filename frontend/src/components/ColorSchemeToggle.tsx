import { ActionIcon, Tooltip, useComputedColorScheme, useMantineColorScheme } from "@mantine/core";
import { IconMoon, IconSun } from "@tabler/icons-react";

export default function ColorSchemeToggle() {
  const { setColorScheme } = useMantineColorScheme();
  // Sempre retorna 'light' ou 'dark'
  const computed = useComputedColorScheme('light', { getInitialValueInEffect: true });

  return (
    <Tooltip label={`Alterar para modo ${computed === 'light' ? 'escuro': 'claro'}`} withArrow>
      <ActionIcon
        onClick={() => setColorScheme(computed === 'light' ? 'dark' : 'light')}
        variant="default"
        size="lg"
        aria-label="Alternar tema"
      >
        {computed === 'light' ? <IconMoon /> : <IconSun />}
      </ActionIcon>
    </Tooltip>
  );
}