import { useEffect, useRef, useState } from "react"
import type { PaginationMeta } from "../api"
import api from "../api"
import { notifications } from "@mantine/notifications"
import { ActionIcon, Button, Flex, Group, Image, Select, Textarea, TextInput, Tooltip, Typography } from "@mantine/core"
import Table from "../components/Table"
import Modal from "../components/Modal"
import type { NivelType } from "./Niveis"
import Loading from "../components/Loading"
import SearchBar from "../components/SearchBar"
import { Pagination } from "../components/Pagination"
import { IconUser } from "@tabler/icons-react"
import devImage from '/icon.png'

export type DesenvolvedorType = {
  id: number
  nivel_id: number
  nome: string
  nivel?: NivelType
  sexo: 'M' | 'F'
  data_nascimento: string
  hobby: string
  created_at: Date
  updated_at: Date
}

export default function Desenvolvedores() {
  const [desenvolvedores, setDesenvolvedores] = useState<DesenvolvedorType[]>([]),
        [meta, setMeta] = useState<PaginationMeta>({
          current_page: 1,
          last_page: 1,
          per_page: 1,
          total: 0,
        }),
        [page, setPage] = useState(1),
        [limit, setLimit] = useState(10),
        [search, setSearch] = useState<string|null>(null),
        [editing, setEditing] = useState<DesenvolvedorType | undefined>(undefined),
        [loading, setLoading] = useState(false),
        [order, setOrder] = useState<{ by: string; direction: 'asc' | 'desc'}>({ by: 'id', direction: 'asc' })

  const Refresh = async() => {
    setLoading(true)
    const response = await api.Index<DesenvolvedorType>('desenvolvedores', {
      page,
      limit,
      nome: search ?? '',
      order_by: order.by,
      order_direction: order.direction,
    })
    setDesenvolvedores( response?.data )
    setMeta( response?.meta )
    setLoading(false)
  }

  const Save = async() => {
    if( !editing ) return

    if( !editing.hobby ) editing.hobby = ''

    const response = editing?.id
          ? await api.Update<DesenvolvedorType>('desenvolvedores', editing.id, editing)
          : await api.Store<DesenvolvedorType>('desenvolvedores', editing)

    if( response ) {
      notifications.show({
        title: editing?.id ? 'Desenvolvedor atualizado' : 'Desenvolvedor criado',
        message: editing?.id
                  ? `O desenvolvedor "${editing.nome}" foi atualizado com sucesso.`
                  : `O desenvolvedor "${editing.nome}" foi criado com sucesso.`,
        color: 'green',
        autoClose: 3000,
      })

      setEditing(undefined)
      Refresh()
    }
  }

  const Delete = async(desenvolvedor: DesenvolvedorType) => {
    if (!confirm(`Confirma a exclusão do nível "${desenvolvedor.nome}"?`)) return
    await api.Delete('desenvolvedores', desenvolvedor.id)
    Refresh()
  }

  useEffect(() => { Refresh() }, [page, order, limit])

  useEffect(() => { if( search === '' ) Refresh() }, [search])

  return (<>
    <Flex justify="space-between" align="center" mb={20} gap={10}>
      <Typography><h2>Desenvolvedores</h2></Typography>
      <Group>
        <Button color="blue" variant="filled" onClick={() => setEditing({} as DesenvolvedorType)}>
          &#43; Novo desenvolvedor
        </Button>
      </Group>
    </Flex>

    <SearchBar search={search} setSearch={setSearch} Refresh={Refresh} setPage={setPage} />

    <Loading isLoading={loading}>
      <Table order={order} setOrder={setOrder}
        data={desenvolvedores?.map(desenvolvedor => ({...desenvolvedor,
          nome: <a onClick={() => setEditing(desenvolvedor)}>{desenvolvedor.nome}</a>,
          nivel: desenvolvedor.nivel?.nivel,
          data_nascimento: (() => {
            const [year, month, day] = desenvolvedor.data_nascimento?.split('-')
            return `${day}/${month}/${year}`
          })(),
          sexo: desenvolvedor.sexo === 'M' ? 'Masculino' : 'Feminino',
          actions: <Flex justify="center" gap={5}>
            <Tooltip label="Editar" withArrow>
              <ActionIcon color="blue" variant="filled" size={24} onClick={() => setEditing(desenvolvedor)}>&#9998;</ActionIcon>
            </Tooltip>
            <Tooltip label="Excluir" withArrow>
              <ActionIcon color="red" variant="filled" size={24} onClick={() => Delete(desenvolvedor)}>&times;</ActionIcon>
            </Tooltip>
          </Flex>
        }) )}
        colunas={[
          { key: 'id', label: '#', width: 50, orderable: true },
          { key: 'nome', label: 'Nome', orderable: true },
          { key: 'nivel', label: 'Nível', orderable: true },
          { key: 'sexo', label: 'Sexo', width: 80, orderable: true },
          { key: 'data_nascimento', label: 'Data de Nascimento', width: 150, align: 'center', orderable: true },
          { key: 'hobby', label: 'Hobby' },
          { key: 'actions', label: 'Ações', width: 100, align: 'center' },
        ]}
      />

      <Pagination meta={meta} setPage={setPage} limit={limit} setLimit={setLimit} />
    </Loading>

    <DesenvolvedorModal editing={editing} setEditing={setEditing} onSave={Save} />
  </>)
}

function DesenvolvedorModal({ editing, setEditing, onSave }: {
  editing?: Partial<DesenvolvedorType>, 
  setEditing?: (desenvolvedor?: DesenvolvedorType) => void,
  onSave?: () => Promise<void>
}) {
  const [niveis, setNiveis] = useState<NivelType[]>([]),
        [loading, setLoading] = useState(false)

  const inputRef = useRef<HTMLInputElement>(null)

  const validation =  editing?.nome?.trim() && 
                      editing?.nivel_id && 
                      editing?.sexo && 
                      editing?.data_nascimento && 
                      new Date(editing.data_nascimento) <= new Date()

  useEffect(() => {
    const fetchNiveis = async() => {
      const response = await api.Index<NivelType>('niveis', { per_page: 100 })
      setNiveis( response.data )

      setTimeout(() => inputRef.current?.focus(), 100)
    }

    if( !!editing ) fetchNiveis()
  }, [editing])

  return (
    <Modal size="xl"
      title={<Flex gap={5} align="center"><IconUser />{editing?.id ? `Editando desenvolvedor: ${editing.nome}` : 'Novo desenvolvedor'}</Flex>}
      opened={!!editing} onClose={() => setEditing?.(undefined)}
    >
      <Flex gap={10} mb={10} direction="row" wrap="wrap" justify="center">
        <Image src={devImage} alt="Desenvolvedor" maw={300} fit="contain" />

        <Flex gap={10} direction="column" miw={300} flex={1}>
          <TextInput ref={inputRef} required
            placeholder="Nome" label="Nome" defaultValue={editing?.nome}
            onChange={e => setEditing?.({...editing, nome: e.currentTarget.value} as DesenvolvedorType)}
            error={!editing?.nome && 'Nome do desenvolvedor é obrigatório'}
          />
          <Select
            label="Nível"
            placeholder="Selecione o nível"
            data={niveis.map(nivel => ({ value: String(nivel.id), label: nivel.nivel }))}
            value={editing?.nivel_id ? String(editing.nivel_id) : undefined}
            onChange={value => setEditing?.({...editing, nivel_id: value ? Number(value) : undefined} as DesenvolvedorType)}
            required
            error={!editing?.nivel_id && 'Nível é obrigatório'}
          />
          <Select
            label="Sexo"
            placeholder="Selecione o sexo"
            data={[
              { value: 'M', label: 'Masculino' },
              { value: 'F', label: 'Feminino' },
            ]}
            value={editing?.sexo}
            onChange={value => setEditing?.({...editing, sexo: value as 'M' | 'F'} as DesenvolvedorType)}
            required
            error={!editing?.sexo && 'Sexo é obrigatório'}
          />
          <TextInput
            label="Data de Nascimento"
            type="date"
            value={editing?.data_nascimento ? new Date(editing.data_nascimento).toISOString().substring(0, 10) : ''}
            onChange={e => setEditing?.({...editing, data_nascimento: e.currentTarget.value ? new Date(e.currentTarget.value).toISOString().split('T')[0] : undefined} as DesenvolvedorType)}
            required
            max={new Date().toISOString().split("T")[0]}
            error={
              !editing?.data_nascimento ? 'Data de nascimento é obrigatória'
              : new Date(editing.data_nascimento) > new Date() ? 'Data de nascimento não pode ser no futuro'
              : undefined
            }
          />
          <Textarea placeholder="Hobby" label="Hobby" 
            value={editing?.hobby ?? ''}
            onChange={e => setEditing?.({...editing, hobby: e.currentTarget.value ?? ''} as DesenvolvedorType)}
            maxLength={255}
          />
        </Flex>
      </Flex>


      <Flex justify="space-between" mt={20} gap={10}>
        <Button color="red" variant="filled" onClick={() => setEditing?.(undefined)}>
          &times; Cancelar
        </Button>
        <Button color="blue" variant="filled" disabled={!validation}
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