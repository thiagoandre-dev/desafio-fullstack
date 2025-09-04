import { Modal as MModal } from '@mantine/core'

export default function Modal({
  opened,
  title,
  onClose = () => {},
  children,
}: {
  opened: boolean,
  title?: string,
  onClose?: () => void,
  children?: React.ReactNode
}) {
  return (
    <MModal opened={opened} onClose={onClose} title={title}>
      {children}
    </MModal>
  )
}