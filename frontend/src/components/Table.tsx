import { Table as MTable } from '@mantine/core'

export type ColunaType = {
  key: string
  label: string
  width?: string | number
  align?: 'left' | 'center' | 'right'
}

export default function Table({ data, colunas }: { data: any[], colunas: ColunaType[] }) {
  return (<>
    <MTable highlightOnHover withColumnBorders className='my-table'>
      <MTable.Thead>
        <MTable.Tr>
          {colunas.map((coluna) => 
            <MTable.Th 
              key={coluna.key}
              style={{width: coluna.width || 'auto', textAlign: coluna.align || 'left'}}
              align={coluna.align || 'left'}
            >
              {coluna.label}
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
  </>)
}