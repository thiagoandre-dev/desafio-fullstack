import { Modal as MModal } from '@mantine/core'
import type { ReactElement } from 'react'

export default function Modal({
  opened,
  onClose = () => {},
  children,
  ...rest
}: {
  opened: boolean,
  onClose?: () => void,
  children?: React.ReactNode,
  title?: ReactElement | string,
  size?: 'xs' | 'sm' | 'md' | 'lg' | 'xl' | (string & {}) | undefined,
}) {
  return (
    <MModal opened={opened} onClose={onClose} {...rest}>
      {children}
    </MModal>
  )
}