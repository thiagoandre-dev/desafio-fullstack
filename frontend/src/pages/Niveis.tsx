import { useEffect, useRef, useState } from "react"
import api, { type PaginationMeta } from "../api"
import Table from "../components/Table"
import { ActionIcon, Button, Flex, Group, Image, TextInput, Tooltip, Typography } from "@mantine/core"
import Modal from "../components/Modal"
import { notifications } from "@mantine/notifications"
import Loading from "../components/Loading"
import SearchBar from "../components/SearchBar"
import { Pagination } from "../components/Pagination"
import nivelImage from '/award.png'
import { IconAward } from "@tabler/icons-react"

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
        [limit, setLimit] = useState(10),
        [search, setSearch] = useState<string|null>(null),
        [editing, setEditing] = useState<NivelType | undefined>(undefined),
        [loading, setLoading] = useState(false),
        [order, setOrder] = useState<{ by: string; direction: 'asc' | 'desc'}>({ by: 'id', direction: 'asc' })

  const Refresh = async() => {
    setLoading(true)
    const response = await api.Index<NivelType>('niveis', {
      page,
      limit,
      nivel: search ?? '',
      order_by: order.by,
      order_direction: order.direction,
    })
    setNiveis( response?.data )
    setMeta( response?.meta )
    setLoading(false)
  }

  const Save = async() => {
    if( !editing ) return

    const response = editing?.id
          ? await api.Update<NivelType>('niveis', editing.id, editing)
          : await api.Store<NivelType>('niveis', editing)

    if( response ) {
      notifications.show({
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
  }

  const Delete = async(nivel: NivelType) => {
    if (!confirm(`Confirma a exclusão do nível "${nivel.nivel}"?`)) return
    await api.Delete('niveis', nivel.id)
    Refresh()
  }

  useEffect(() => { Refresh() }, [page, order, limit])

  useEffect(() => { if( search === '' ) Refresh() }, [search])

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
      <Table order={order} setOrder={setOrder}
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
          { key: 'id', label: '#', width: 50, orderable: true },
          { key: 'nivel', label: 'Nível', orderable: true },
          { key: 'actions', label: 'Ações', width: 100, align: 'center' },
        ]}
      />

      <Pagination meta={meta} setPage={setPage} limit={limit} setLimit={setLimit} />
    </Loading>

    <NivelModal editing={editing} setEditing={setEditing} onSave={Save} />
  </>)
}

function NivelModal({ editing, setEditing, onSave }: {
  editing?: Partial<NivelType>, 
  setEditing?: (nivel?: NivelType) => void,
  onSave?: () => Promise<void>
}) {
  const [loading, setLoading] = useState(false),
        [opened, setOpened] = useState(false)

  const inputRef = useRef<HTMLInputElement>(null)

  useEffect(() => setOpened(!!editing), [editing])

  useEffect(() => {
    if( opened ) setTimeout(() => inputRef.current?.focus(), 100)
  }, [opened])

  return (
    <Modal size="xl"
      title={<Flex gap={5} align="center"><IconAward />{editing?.id ? `Editando nível: ${editing.nivel}` : 'Novo nível'}</Flex>}
      opened={!!editing} onClose={() => setEditing?.(undefined)}
    >
      <Flex gap={10} mb={10} direction="row" wrap="wrap" justify="center">
        <Image src={nivelImage} alt="Desenvolvedor" maw={300} fit="contain" />

        <Flex gap={10} direction="column" miw={300} flex={1}>
          <TextInput ref={inputRef} required
            placeholder="Nível" label="Nível" defaultValue={editing?.nivel}
            onChange={e => setEditing?.({...editing, nivel: e.currentTarget.value} as NivelType)}
            error={!editing?.nivel && 'Nome do nível é obrigatório'}
          />
        </Flex>
      </Flex>

      <Flex justify="space-between" mt={20} gap={10}>
        <Button color="red" variant="filled" onClick={() => setEditing?.(undefined)}>
          &times; Cancelar
        </Button>
        <Button color="blue" variant="filled" disabled={!editing?.nivel?.trim()}
          loading={loading}
          onClick={async() => {
            setLoading(true)
            await onSave?.()
            setLoading(false)
          }}
        >
          &#10003; Salvar
        </Button>
      </Flex>      
    </Modal>
  )
}