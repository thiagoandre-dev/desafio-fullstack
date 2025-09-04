import { AppShell, Burger, Flex, Image, NavLink, rgba, Typography, useMantineColorScheme, useMantineTheme } from "@mantine/core";
import { useDisclosure } from "@mantine/hooks";
import ColorSchemeToggle from "./components/ColorSchemeToggle";
import MenuItems from "./MenuItems";
import { useEffect, useState } from "react";
import logo from '/icon.png'
import { IconCode } from "@tabler/icons-react";

export default function Layout() {
  const [opened, { toggle }] = useDisclosure(),
        [activePageIndex, setActivePageIndex] = useState(0),
        [Page, setPage] = useState(() => MenuItems[0].page),
        { colorScheme } = useMantineColorScheme(),
        dark = colorScheme === 'dark',
        theme = useMantineTheme()

  useEffect(() => {
    setPage(() => MenuItems[activePageIndex].page)
  }, [activePageIndex])

  return <AppShell
      padding="md"
      header={{ height: 60 }}
      navbar={{
        width: 200,
        breakpoint: 'sm',
        collapsed: { mobile: !opened },
      }}
    >
      <AppShell.Header 
        style={{ 
          display: 'flex', 
          alignItems: 'center', 
          justifyContent: "space-between",
          backdropFilter: "blur(10px)",
          backgroundColor: rgba( dark ? theme.colors.dark[8] : theme.colors.gray[2], 0.6 ),
          borderBottom: `1px solid ${dark ? theme.colors.dark[5] : theme.colors.gray[3]}`,
        }} p={10}
      >
        <Flex align="center" gap={10}>
          <Burger
            opened={opened}
            onClick={toggle}
            hiddenFrom="sm"
            size="sm"
          />
          <Image src={logo} h={32} w="auto" />
          <Typography><h2>Desafio FullStack</h2></Typography>
        </Flex>
        <ColorSchemeToggle />
      </AppShell.Header>

      <AppShell.Navbar
        style={{ 
          backgroundColor: dark ? theme.colors.dark[7] : theme.colors.gray[1],
          borderRight: `1px solid ${dark ? theme.colors.dark[5] : theme.colors.gray[3]}`,
        }}
      >
        { MenuItems.map((item, i) => (
          <NavLink
            key={item.label}
            href={`#${item.label.toLowerCase()}`}
            onClick={() => setActivePageIndex(i)}
            label={item.label}
            leftSection={<item.icon size={16} stroke={1.5} />}
            active={i === activePageIndex}
          />
        )) }
        <NavLink
          style={{ borderTop: `1px solid ${dark ? theme.colors.dark[5] : theme.colors.gray[3]}`, marginTop: 10, paddingTop: 10 }}
          href={`${import.meta.env.VITE_API_BASE_URL}documentation`}
          label="API Docs"
          target="_blank"
          leftSection={<IconCode />}
        />
      </AppShell.Navbar>

      <AppShell.Main
        style={{ 
          backgroundColor: dark ? theme.colors.dark[6] : theme.colors.gray[0],
        }}
      >
        <Page />
      </AppShell.Main>
    </AppShell>
}