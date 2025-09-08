import { Center, Flex, Table as MTable, ScrollArea, UnstyledButton } from '@mantine/core'
import { IconChevronDown, IconChevronUp } from '@tabler/icons-react'

export type ColunaType = {
  key: string
  label: string
  width?: string | number
  align?: 'left' | 'center' | 'right'
  orderable?: boolean
}

export default function Table({ data, colunas, order, setOrder }: {
  data: any[],
  colunas: ColunaType[],
  order?: { by: string, direction: 'asc' | 'desc' },
  setOrder?: (order: { by: string, direction: 'asc' | 'desc' }) => void
}) {
  return (
    <ScrollArea>
      <MTable highlightOnHover withColumnBorders className='my-table' >
        <MTable.Thead>
          <MTable.Tr>
            {colunas.map((coluna) => 
              <MTable.Th 
                key={coluna.key}
                style={{width: coluna.width || 'auto', textAlign: coluna.align || 'left'}}
                align={coluna.align || 'left'}
                onClick={() => coluna.orderable && setOrder?.({
                  by: coluna.key,
                  direction: order?.by === coluna.key && order.direction === 'asc' ? 'desc' : 'asc'
                }) }
                className={coluna.orderable ? 'orderable' : '' }
              >
                {coluna.orderable ? (
                  <UnstyledButton style={{width: '100%', textAlign: coluna.align || 'left', fontSize: 'inherit'}}>
                    <Flex gap={5}>
                      {coluna.label}
                      <Center>
                        {order?.by === coluna.key ? (
                          order.direction === 'asc' ? <IconChevronUp size={14} /> : <IconChevronDown size={14} />
                        ) : null}
                      </Center>
                    </Flex>
                  </UnstyledButton>
                ) : coluna.label}
              </MTable.Th>
            )}
          </MTable.Tr>
        </MTable.Thead>
        <MTable.Tbody>
          { data?.length 
            ? data?.map((item, index) => (
                <MTable.Tr key={index}>
                  {colunas.map((coluna) => 
                    <MTable.Td key={coluna.key} align={coluna.align}>{item[coluna.key]}</MTable.Td>
                  )}
                </MTable.Tr>
              ))
            : <MTable.Tr><MTable.Td colSpan={colunas.length} align="center">Nenhum registro encontrado</MTable.Td></MTable.Tr>
          }
        </MTable.Tbody>
      </MTable>
    </ScrollArea>
  )
}