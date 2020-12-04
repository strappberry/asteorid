<template>
  <footer
    class="absolute bottom-0 flex items-center justify-end w-full h-10 py-2 pr-8 text-sm font-normal text-gray-700 bg-white"
  >
    {{ $t('general.based_on') }}

    <a
      href="https://craterapp.com/"
      target="_blank"
      class="pl-1 font-normal text-gray-900"
    >
      {{ $t('general.crater_app') }}
    </a>

    &nbsp;&nbsp;
    {{ $t('general.powered_by') }}

    <a
      href="http://strappberry.com/"
      target="_blank"
      class="pl-1 font-normal text-gray-900"
    >
      {{ $t('general.strappberry') }}
    </a>
  </footer>
</template>
