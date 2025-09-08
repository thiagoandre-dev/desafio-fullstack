import { ActionIcon, CloseButton, Flex, Input, Tooltip } from "@mantine/core"
import { IconSearch } from "@tabler/icons-react"

export default function SearchBar({ search, setSearch, setPage, Refresh }: { 
  search: string | null,
  setSearch: (s: string) => void,
  setPage: (p: number) => void,
  Refresh: () => void
}) {
  function buscar() {
    setPage(1)
    Refresh()
  }

  return (
    <Flex my={20} gap={10} justify="space-between" align="center">
      <Input placeholder="Pesquisar..." value={search ?? ''} onChange={e => setSearch(e.currentTarget.value)}
        onKeyDown={(e) => { if (e.key === 'Enter') { buscar() } }}
        style={{ flexGrow: 1 }}
        rightSectionPointerEvents="all"
        rightSection={
          <CloseButton 
            style={{ display: search ? 'block' : 'none' }}
            aria-label="Remover pesquisa"
            onClick={() => { setSearch('') }} 
          />
        }
      />
      <Tooltip label="Pesquisar" withArrow>
        <ActionIcon variant="filled" color="blue" size={36} 
          onClick={() => { buscar() }}
        ><IconSearch size={24} /></ActionIcon>
      </Tooltip>
    </Flex>
  )
}