import { useEffect, useState } from "react"
import api, { type PaginationMeta } from "../api"
import Table from "../components/Table"
import { ActionIcon, Button, Flex, Group, Pagination, TextInput, Tooltip, Typography } from "@mantine/core"
import Modal from "../components/Modal"
import { notifications } from "@mantine/notifications"
import Loading from "../components/Loading"
import SearchBar from "../components/SearchBar"

export type NivelType = {
  id: number
  nivel: string
  created_at: Date
  updated_at: Date
}

export default function Niveis() {
  const [niveis, setNiveis] = useState<NivelType[]>([]),
        [meta, setMeta] = useState<PaginationMeta>({
          current_page: 1,
          last_page: 1,
          per_page: 1,
          total: 0,
        }),
        [page, setPage] = useState(1),
        [search, setSearch] = useState(''),
        [editing, setEditing] = useState<NivelType | undefined>(undefined),
        [loading, setLoading] = useState(false)

  const Refresh = async() => {
    setLoading(true)
    const response = await api.Index<NivelType>('niveis', { page, nivel: search })
    setNiveis( response?.data )
    setMeta( response?.meta )
    setLoading(false)
  }

  const Save = async() => {
    if( !editing ) return

    const response = editing?.id
          ? await api.Update<NivelType>('niveis', editing.id, editing)
          : await api.Store<NivelType>('niveis', editing)
    if( response ) notifications.show({
      title: editing?.id ? 'Nível atualizado' : 'Nível criado',
      message: editing?.id
                ? `O nível "${editing.nivel}" foi atualizado com sucesso.`
                : `O nível "${editing.nivel}" foi criado com sucesso.`,
      color: 'green',
      autoClose: 3000,
    })

    setEditing(undefined)
    Refresh()
  }

  const Delete = async(nivel: NivelType) => {
    if (!confirm(`Confirma a exclusão do nível "${nivel.nivel}"?`)) return
    await api.Delete('niveis', nivel.id)
    Refresh()
  }

  useEffect(() => { Refresh() }, [page])

  return (<>
    <Flex justify="space-between" align="center" mb={20} gap={10}>
      <Typography><h2>Níveis</h2></Typography>
      <Group>
        <Button color="blue" variant="filled" onClick={() => setEditing({} as NivelType)}>
          &#43; Novo nível
        </Button>
      </Group>
    </Flex>

    <SearchBar search={search} setSearch={setSearch} Refresh={Refresh} setPage={setPage} />

    <Loading isLoading={loading}>
      <Table 
        data={niveis?.map(nivel => ({...nivel, 
          nivel: <a onClick={() => setEditing(nivel)}>{nivel.nivel}</a>,
          actions: <Flex justify="center" gap={5}>
            <Tooltip label="Editar" withArrow>
              <ActionIcon color="blue" variant="filled" size={24} onClick={() => setEditing(nivel)}>&#9998;</ActionIcon>
            </Tooltip>
            <Tooltip label="Excluir" withArrow>
              <ActionIcon color="red" variant="filled" size={24} onClick={() => Delete(nivel)}>&times;</ActionIcon>
            </Tooltip>
          </Flex>
        }) )}
        colunas={[
          { key: 'id', label: 'ID', width: 50 },
          { key: 'nivel', label: 'Nível'},
          { key: 'actions', label: 'Ações', width: 100, align: 'center' },
        ]}
      />

      { meta?.total > 1 &&
        <Flex justify="center" mt={20}>
          <Pagination total={meta.last_page} value={meta.current_page} onChange={setPage} />
        </Flex>
      }
    </Loading>

    <NivelModal editing={editing} setEditing={setEditing} onSave={Save} />
  </>)
}

function NivelModal({ editing, setEditing, onSave }: {
  editing?: Partial<NivelType>, 
  setEditing?: (nivel?: NivelType) => void,
  onSave?: () => void
}) {
  return (
    <Modal title={editing?.id ? `Editando nível: ${editing.nivel}` : 'Novo nível'}
      opened={!!editing} onClose={() => setEditing?.(undefined)}
    >
      <TextInput placeholder="Nível" label="Nível" defaultValue={editing?.nivel} required 
        onChange={e => setEditing?.({...editing, nivel: e.currentTarget.value} as NivelType)}
        error={!editing?.nivel && 'Nome do nível é obrigatório'}
      />

      <Flex justify="space-between" mt={20} gap={10}>
        <Button color="red" variant="filled" onClick={() => setEditing?.(undefined)}>
          &times; Cancelar
        </Button>
        <Button color="blue" variant="filled" onClick={onSave} disabled={!editing?.nivel?.trim()}>
          &#10003; Salvar
        </Button>
      </Flex>      
    </Modal>
  )
}