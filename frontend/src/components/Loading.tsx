import { Flex, Loader, Typography } from "@mantine/core";

export default function Loading({ isLoading, children }: { isLoading: boolean, children: React.ReactNode }) {
  return <>{
          isLoading ? (
            <Flex justify="center" align="center" style={{ height: 200 }}>
              <Loader size="lg" mr={10} />
              <Typography>Carregando...</Typography>
            </Flex>
          ) : children
        }</>
}