<script lang="ts">
  import { goto } from '$app/navigation';
  import Button from '@smui/button';
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
      await myForm.validate();
      if ($myForm.valid) {
        const result = await api.post('/vehicle/new', myForm.summary());
        goto('/veiculos');
      }
    } catch (e) {}
  };
</script>

<h1>Novo Veículo</h1>

<LayoutGrid>
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
  <Button on:click={handleSubmit} variant="raised">Enviar</Button>
</div>

<style>
  .submit-button {
    display: flex;
    justify-content: center;
  }
</style>
