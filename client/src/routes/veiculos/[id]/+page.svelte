<script lang="ts">
  import { goto } from '$app/navigation';
  import Button from '@smui/button';
  import CircularProgress from '@smui/circular-progress';
  import LayoutGrid, { Cell } from '@smui/layout-grid';
  import Textfield from '@smui/textfield';
  import HelperText from '@smui/textfield/helper-text';
  import { form, field } from 'svelte-forms';
  import {
    between,
    max,
    min,
    pattern,
    required
  } from 'svelte-forms/validators';
  import { api } from '../../../api/axios';
  import { FlatToast, ToastContainer, toasts } from 'svelte-toasts';
  import { onMount } from 'svelte';
  import LinearProgress from '@smui/linear-progress';

  export let data;

  let loadedData = false;
  let loadingSubmit = false;

  const brand = field('brand', '', [required(), min(3), max(255)]);
  const name = field('name', '', [required(), min(3), max(255)]);
  const year = field('year', '', [
    required(),
    between(1950, new Date().getFullYear())
  ]);

  const plate = field('plate', '', [
    required(),
    pattern(
      /([A-Za-z]{2}[A-Za-z0-9][0-9][A-Za-z0-9]{3})|([A-Za-z]{3}-?[0-9]{4})/
    )
  ]);

  const sale_value = field('sale_value', '', [
    required(),
    pattern(/(\d+(\.)?)+(\,\d{1,2})?$/)
  ]);

  const myForm = form(brand, name, year, plate, sale_value);

  const handleSubmit = async () => {
    try {
      loadingSubmit = true;
      await myForm.validate();
      if ($myForm.valid) {
        await api.put(`vehicle/${data.id}`, myForm.summary());
        loadingSubmit = false;
        goto('/veiculos', { state: { updated: true } });
      } else {
        loadingSubmit = false;
      }
    } catch (e: any) {
      toasts.error(e.response?.data.message || 'Erro no servidor');
      loadingSubmit = false;
    }
  };

  onMount(() => {
    async function getVehicle() {
      const result = await api.get(`vehicle/${data.id}`);
      brand.set(result.data.data.brand);
      name.set(result.data.data.name);
      year.set(result.data.data.year);
      plate.set(result.data.data.plate);
      sale_value.set(result.data.data.sale_value);
      loadedData = true;
    }

    getVehicle();
  });
</script>

<h1>Editar Veículo</h1>

<LinearProgress indeterminate bind:closed={loadedData} slot="progress" />

<LayoutGrid class="layout-grid">
  <Cell span={12}>
    <Textfield
      bind:value={$name.value}
      label="Modelo"
      variant="filled"
      style="width: 100%;"
      invalid={$myForm.hasError('name.required') ||
        $myForm.hasError('name.min') ||
        $myForm.hasError('name.max')}
    >
      <HelperText validationMsg slot="helper">
        {#if $myForm.hasError('name.required')}
          Modelo obrigatório!
        {:else}
          Modelo inválido!
        {/if}
      </HelperText>
    </Textfield>
  </Cell>
  <Cell span={6}>
    <Textfield
      bind:value={$brand.value}
      label="Marca"
      variant="filled"
      style="width: 100%;"
      invalid={$myForm.hasError('brand.required') ||
        $myForm.hasError('brand.min') ||
        $myForm.hasError('brand.max')}
    >
      <HelperText validationMsg slot="helper">
        {#if $myForm.hasError('brand.required')}
          Marca obrigatória!
        {:else}
          Marca inválida!
        {/if}
      </HelperText>
    </Textfield>
  </Cell>
  <Cell span={6}>
    <Textfield
      bind:value={$year.value}
      type="number"
      label="Ano"
      variant="filled"
      style="width: 100%;"
      invalid={$myForm.hasError('year.required') ||
        $myForm.hasError('year.between')}
    >
      <HelperText validationMsg slot="helper">
        {#if $myForm.hasError('name.required')}
          Ano obrigatório!
        {:else}
          Ano inválido!
        {/if}
      </HelperText>
    </Textfield>
  </Cell>
  <Cell span={6}>
    <Textfield
      bind:value={$plate.value}
      label="Placa"
      variant="filled"
      style="width: 100%;"
      invalid={$myForm.hasError('plate.required') ||
        $myForm.hasError('plate.pattern')}
    >
      <HelperText validationMsg slot="helper">
        {#if $myForm.hasError('plate.required')}
          Placa obrigatória!
        {:else}
          Placa inválida!
        {/if}
      </HelperText>
    </Textfield>
  </Cell>
  <Cell span={6}>
    <Textfield
      bind:value={$sale_value.value}
      type="number"
      label="Valor de venda"
      variant="filled"
      style="width: 100%;"
      invalid={$myForm.hasError('sale_value.required') ||
        $myForm.hasError('sale_value.pattern')}
    >
      <HelperText validationMsg slot="helper">
        {#if $myForm.hasError('sale_value.required')}
          Valor de venda obrigatório!
        {:else}
          Valor de venda inválido!
        {/if}
      </HelperText>
    </Textfield>
  </Cell>
  <Cell span={12} />
</LayoutGrid>
<div class="submit-button">
  <Button on:click={handleSubmit} variant="raised" disabled={loadingSubmit}>
    {#if loadingSubmit}
      <CircularProgress style="height: 32px; width: 32px;" indeterminate />
    {:else}
      Enviar
    {/if}
  </Button>
</div>
<ToastContainer placement="bottom-left" let:data>
  <FlatToast {data} />
</ToastContainer>

<style>
  .submit-button {
    display: flex;
    justify-content: center;
  }

  :global(.layout-grid) {
    margin-top: 24px;
    padding: 0;
  }
</style>
