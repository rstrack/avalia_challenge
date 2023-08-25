<script lang="ts">
  import Header from '$lib/Header.svelte';
</script>

<Header />

<div class="navbar-space" />

<div class="base-container">
  <slot />
</div>

<style>
  .navbar-space {
    height: 64px;
  }

  .base-container {
    margin: 0 20%;
  }

  @media (max-width: 1500px) {
    .base-container {
      margin: 0 32px;
    }
  }
</style>
