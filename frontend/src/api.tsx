import { notifications } from "@mantine/notifications";
import { IconX } from "@tabler/icons-react";

export type http_methods = 'GET' | 'POST' | 'PUT' | 'DELETE'

export type PaginationMeta = {
    current_page: number
    last_page: number
    per_page: number
    total: number
  }

export type PaginatedResponse<T> = {
  data: T[]
  meta: PaginationMeta
}

export type ErrorResponse = {
  message: string
  errors?: Record<string, string[]>
}

export async function Fetch<T>(path: string, method: http_methods = 'GET', params?: Record<string, any>, body?: any): Promise<T | PaginatedResponse<T> | void | null> {
  const url = new URL(`/api/${path}`, `${window.location.origin}`)

  if (params) Object.entries(params).forEach(([key, value]) => url.searchParams.append(key, String(value)) )

  return await fetch(url, {
    method,
    headers: {
      'Content-Type': 'application/json',
      'Accept': 'application/json',
    },
    body: body ? JSON.stringify(body) : undefined,
  }).then(async response => {
    if (!response.ok) {
      const error = await response.json() as ErrorResponse
      notifications.show({
        title: error?.message,
        message: error?.errors ? Object.values(error.errors).flat().join(', ') : null,
        color: 'red',
        icon: <IconX size={16} />,
        autoClose: 3000,
      })
    }

    if (response.status !== 204) { // Sem conteúdo
      return (response.ok ? await response.json() : null) as Promise<T | PaginatedResponse<T> | null>
    }
  })
}

export async function Index<T>(path: string, params?: Record<string, any>): Promise<PaginatedResponse<T>> {
  return Fetch<T>(path, 'GET', params) as Promise<PaginatedResponse<T>>
}

export async function Show<T>(path: string, id: number | string): Promise<T> {
  return Fetch<T>(`${path}/${id}`, 'GET') as Promise<T>
}

export async function Store<T>(path: string, data: Partial<T>): Promise<T> {
  return Fetch<T>(path, 'POST', undefined, data) as Promise<T>
}

export async function Update<T>(path: string, id: number | string, data: Partial<T>): Promise<T> {
  return Fetch<T>(`${path}/${id}`, 'PUT', data) as Promise<T>
}

export async function Delete(path: string, id: number | string): Promise<void> {
  return Fetch<void>(`${path}/${id}`, 'DELETE') as Promise<void>
}

export default {
  Fetch,
  Index,
  Show,
  Store,
  Update,
  Delete,
}