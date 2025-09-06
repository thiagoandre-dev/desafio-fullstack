import '@mantine/core/styles.css'
import '@mantine/notifications/styles.css'
import './App.scss'
import { MantineProvider } from '@mantine/core'
import Layout from './Layout'
import { Notifications } from '@mantine/notifications'

export default function App() {
  return (
    <MantineProvider defaultColorScheme="dark">
      <Notifications position="top-right" /> 
      <Layout/>
    </MantineProvider>
  )
}
