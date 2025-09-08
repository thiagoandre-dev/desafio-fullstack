import { Flex, Pagination as MPagination, Select, Text } from "@mantine/core";
import type { PaginationMeta } from "../api";
import { useMediaQuery } from "@mantine/hooks";

export function Pagination({ meta, setPage, limit, setLimit }: {
  meta: PaginationMeta,
  setPage: (page: number) => void,
  limit: number,
  setLimit: (limit: number) => void,
}){
  const isMobile = useMediaQuery('(max-width: 768px)')

  return ( meta &&
    <Flex justify={isMobile ? "center" : "space-between"} mt={20} align="center" gap={10} wrap="wrap" direction={isMobile ? "column-reverse" : "row"}>
      <Select data={[
          { value: '5', label: '5 por página' },
          { value: '10', label: '10 por página' },
          { value: '20', label: '20 por página' },
          { value: '50', label: '50 por página' },
          { value: '100', label: '100 por página' },
        ]} value={String(limit)} onChange={value => { setLimit(Number(value)); setPage(1); }}
      />
      <MPagination total={meta.last_page} value={meta.current_page} onChange={setPage} />
      <Text size="sm" c="dimmed">
        {meta.total} {meta.total === 1 ? 'registro' : 'registros'} encontrado{meta.total === 1 ? '' : 's'}
      </Text>
    </Flex>
  )
}