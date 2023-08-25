<script lang="ts">
  import { onMount } from 'svelte';
  import Button, { Label } from '@smui/button';
  import DataTable, {
    Body,
    Cell,
    Head,
    Pagination,
    Row
  } from '@smui/data-table';
  import Dialog, { Actions, Content, Title } from '@smui/dialog';
  import IconButton, { Icon } from '@smui/icon-button';
  import LinearProgress from '@smui/linear-progress';
  import Tooltip, { Wrapper } from '@smui/tooltip';
  import { toasts, ToastContainer, FlatToast } from 'svelte-toasts';
  import { api } from '../../api/axios';
  import { formatDateString } from '../../helpers/dateFormat';

  type Vehicle = {
    id: number;
    name: string;
    brand: string;
    year: string;
    plate: string;
    sale_value: number;
    created_at: string;
  };

  const ROWS_PER_PAGE = 15;

  let open = false;
  let loaded = false;
  let page = 1;
  let lastPage: number;
  let start: number;
  let end: number;
  let count: number;
  let vehicles: Vehicle[] = [];
  let selectedVehicleId = -1;

  $: start = (page - 1) * ROWS_PER_PAGE;
  $: end = Math.min(page * ROWS_PER_PAGE, count);
  $: page && getVehicles();

  let brl = new Intl.NumberFormat('pt-BR', {
    style: 'currency',
    currency: 'BRL'
  });

  const getVehicles = async () => {
    try {
      loaded = false;
      const result = await api.get(`/vehicles?page=${page}`);
      vehicles = result.data.data;
      lastPage = result.data.meta.last_page;
      count = result.data.meta.total;
      loaded = true;
    } catch (e) {
      toasts.error('Erro no servidor');
      loaded = true;
    }
  };

  const handleDelete = (id: number) => {
    open = true;
    selectedVehicleId = id;
  };

  const deleteVehicle = async () => {
    loaded = false;
    await api.delete(`/vehicle/${selectedVehicleId}`);
    await getVehicles();
    toasts.success('Veículo excluído com sucesso!');
    selectedVehicleId = -1;
  };

  onMount(() => {
    if (history.state.created) {
      toasts.success('Veículo adicionado com sucesso!');
    }
    if (history.state.updated) {
      toasts.success('Veículo editado com sucesso!');
    }
  });
</script>

<div class="title-add-container">
  <h1>Veículos</h1>
  <Button href={`veiculos/novo`} variant="raised">
    <Icon class="material-icons">add</Icon>
    <Label>Novo</Label>
  </Button>
</div>

<DataTable class="data-table">
  <Head>
    <Row>
      <Cell>Marca</Cell>
      <Cell>Modelo</Cell>
      <Cell>Ano</Cell>
      <Cell>Placa</Cell>
      <Cell>Valor de venda</Cell>
      <Cell>Data de cadastro</Cell>
      <Cell>Opções</Cell>
    </Row>
  </Head>
  <Body>
    {#each vehicles as vehicle (vehicle.id)}
      <Row class="data-table-row">
        <Cell>{vehicle.brand}</Cell>
        <Cell>{vehicle.name}</Cell>
        <Cell>{vehicle.year}</Cell>
        <Cell>{vehicle.plate}</Cell>
        <Cell>{brl.format(vehicle.sale_value)}</Cell>
        <Cell>{formatDateString(vehicle.created_at)}</Cell>
        <Cell>
          <div>
            <Wrapper>
              <IconButton href={`veiculos/${vehicle.id}`} size="mini">
                <Icon class="material-icons" style="color:#2196f3">edit</Icon>
              </IconButton>
              <Tooltip>Editar</Tooltip>
            </Wrapper>
            <Wrapper>
              <IconButton on:click={() => handleDelete(vehicle.id)} size="mini">
                <Icon class="material-icons" style="color:#f44336">delete</Icon>
              </IconButton>
              <Tooltip>Excluir</Tooltip>
            </Wrapper>
          </div>
        </Cell>
      </Row>
    {/each}
  </Body>
  <LinearProgress indeterminate bind:closed={loaded} slot="progress" />
  <Pagination slot="paginate">
    <svelte:fragment slot="total">
      {Math.min(start + 1, end) || 0}-{end || 0} de {count || 0}
    </svelte:fragment>

    <IconButton
      class="material-icons"
      action="first-page"
      title="Primeira página"
      on:click={() => (page = 1)}
      disabled={page === 1}>first_page</IconButton
    >
    <IconButton
      class="material-icons"
      action="prev-page"
      title="Página anterior"
      on:click={() => page--}
      disabled={page === 1}>chevron_left</IconButton
    >
    <IconButton
      class="material-icons"
      action="next-page"
      title="Próxima página"
      on:click={() => page++}
      disabled={page == lastPage || !lastPage}>chevron_right</IconButton
    >
    <IconButton
      class="material-icons"
      action="last-page"
      title="Última página"
      on:click={() => (page = lastPage)}
      disabled={page == lastPage || !lastPage}>last_page</IconButton
    >
  </Pagination>
</DataTable>

<Dialog bind:open>
  <Title>Atenção</Title>
  <Content>Tem certeza que deseja excluir?</Content>
  <Actions>
    <Button on:click={deleteVehicle}>
      <Label>Sim</Label>
    </Button>
    <Button on:click={() => (open = false)}>
      <Label>Não</Label>
    </Button>
  </Actions>
</Dialog>

<ToastContainer placement="bottom-left" let:data>
  <FlatToast {data} />
</ToastContainer>

<style>
  a:visited {
    color: inherit;
  }

  .title-add-container {
    display: flex;
    flex-direction: column;
    align-items: start;
    margin-bottom: 32px;
  }

  :global(.data-table) {
    width: 100%;
  }
</style>
