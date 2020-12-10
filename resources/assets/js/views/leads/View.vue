<template>
  <base-page>

    <sw-card v-if="!isLoading && lead">
      <div class="grid gap-6 grid-col-1 md:grid-cols-2">

        <div class="w-full">
          <h6 class="text-red-600">{{ $t('leads.name') }}</h6>
          <div>{{ lead.name }}</div>
        </div>

        <div class="w-full">
          <h6 class="text-red-600">{{ $t('leads.source') }}</h6>
          <div>{{ lead.lead_source.name }}</div>
        </div>

        <div class="w-full">
          <h6 class="text-red-600">{{ $t('leads.email') }}</h6>
          <div>{{ lead.email }}</div>
        </div>

        <div class="w-full">
          <h6 class="text-red-600">{{ $t('leads.phone_number') }}</h6>
          <div>{{ lead.phone }}</div>
        </div>

        <div class="w-full">
          <h6 class="text-red-600">{{ $t('leads.location') }}</h6>
          <div>{{ lead.location }}</div>
        </div>

        <div class="w-full">
          <h6 class="text-red-600">{{ $t('leads.interests') }}</h6>
          <div>{{ lead.interests }}</div>
        </div>

        <div class="w-full">
          <h6 class="text-red-600">{{ $t('leads.language') }}</h6>
          <div>{{ lead.language }}</div>
        </div>

        <div class="w-full">
          <h6 class="text-red-600">{{ $t('leads.message') }}</h6>
          <div>{{ lead.message }}</div>
        </div>

      </div>
    </sw-card>

  </base-page>
</template>

<script>
import { mapActions } from 'vuex'
export default {
  name: 'LeadView',

  data: () => ({
    isLoading: true,
    lead: null,
  }),

  mounted () {
    this.fetchData()
  },

  methods: {
    ...mapActions('leads', [
      'fetchLead',
    ]),

    async fetchData() {
      this.isLoading = true
      const response = await this.fetchLead(this.$route.params.id)
      this.lead = response.data.lead
      this.isLoading = false
    }
  }
}
</script>

<style>

</style>