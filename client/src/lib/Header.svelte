<script lang="ts">
  import { page } from '$app/stores';
  import TopAppBar, { Row, Section, Title } from '@smui/top-app-bar';
  import IconButton from '@smui/icon-button';
  import Drawer, {
    Content,
    Header,
    Scrim,
    Title as DrawerTitle
  } from '@smui/drawer';
  import List, { Item, Text, Graphic, Separator, Subheader } from '@smui/list';

  let open = false;
  let active: null | number;

  function setActive(value: number) {
    active = value;
    open = false;
  }
</script>

<TopAppBar variant="standard">
  <Row>
    <Section>
      <IconButton class="material-icons" on:click={() => (open = !open)}
        >menu</IconButton
      >
      <Title>Avalia Challenge</Title>
    </Section>
  </Row>
</TopAppBar>
<Drawer variant="modal" fixed={false} bind:open>
  <Header>
    <DrawerTitle>Avalia Challenge</DrawerTitle>
  </Header>
  <Separator />
  <Content>
    <List>
      <Item
        href="/veiculos"
        on:click={() => (open = false)}
        activated={$page.url.pathname == '/veiculos'}
      >
        <Graphic class="material-icons" aria-hidden="true"
          >directions_car</Graphic
        >
        <Text>Veículos</Text>
      </Item>
    </List>
  </Content>
</Drawer>

<Scrim fixed={false} />
