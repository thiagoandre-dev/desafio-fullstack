import { ActionIcon, CloseButton, Flex, Input, Tooltip } from "@mantine/core"
import { IconSearch } from "@tabler/icons-react"

export default function SearchBar({ search, setSearch, Refresh}: { search: string, setSearch: (s: string) => void, Refresh: () => void }) {
  return (
    <Flex my={20} gap={10} justify="space-between" align="center">
      <Input placeholder="Pesquisar..." value={search} onChange={e => setSearch(e.currentTarget.value)}
        onKeyDown={(e) => { if (e.key === 'Enter') Refresh() }}
        style={{ flexGrow: 1 }}
        rightSection={ !!search && <CloseButton onClick={() => { setSearch('') }} /> }
      />
      <Tooltip label="Pesquisar" withArrow>
        <ActionIcon variant="filled" color="blue" onClick={Refresh} size={36}><IconSearch size={24} /></ActionIcon>
      </Tooltip>
    </Flex>
  )
}