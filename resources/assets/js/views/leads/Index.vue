<template>
  <base-page>

    <!-- Page header -->
    <sw-page-header :title="$t('leads.title')">
      <sw-breadcrumb slot="breadcrumbs">
        <sw-breadcrumb-item to="dashboard" :title="$t('general.home')" />
        <sw-breadcrumb-item
          to="#"
          :title="$t('leads.title')"
          active
        />
      </sw-breadcrumb>

      <template slot="actions">
        <sw-button
          tag-name="router-link"
          to="leads/create"
          size="lg"
          variant="primary"
          class="ml-4"
        >
          <plus-sm-icon class="h-6 mr-1 -ml-2 font-bold" />
          {{ $t('leads.new_lead') }}
        </sw-button>
      </template>
    </sw-page-header>

    <sw-empty-table-placeholder
      v-if="showEmptyScreen"
      :title="$t('leads.no_leads')"
      :description="$t('leads.list_of_leads')"
    >
      <capsule-icon class="mt-5 mb-4" />

      <sw-button
        slot="actions"
        tag-name="router-link"
        to="/admin/leads/create"
        size="lg"
        variant="primary-outline"
      >
        <plus-icon class="w-6 h-6 mr-1 -ml-2" />
        {{ $t('leads.new_lead') }}
      </sw-button>
    </sw-empty-table-placeholder>

    <div v-if="!showEmptyScreen" class="relative table-container">

      <!-- Leads Table -->
      <sw-table-component
        ref="table"
        :data="fetchData"
        :show-filter="false"
        table-class="table"
      >
        <!-- Column name -->
        <sw-table-column
          :sortable="true"
          :label="$t('leads.name')"
          sort-as="name"
          show="name"
        />
        <!-- Column email -->
        <sw-table-column
          :sortable="true"
          :label="$t('leads.email')"
          sort-as="email"
          show="email"
        />
        <!-- Column phone -->
        <sw-table-column
          :sortable="true"
          :label="$t('leads.phone_number')"
          sort-as="phone"
          show="phone"
        />
        <!-- Column location -->
        <sw-table-column
          :sortable="true"
          :label="$t('leads.location')"
          sort-as="location"
          show="location"
        />

        <!-- Actions column -->
        <sw-table-column
          :sortable="false"
          :filterable="false"
          cell-class="action-dropdown"
        >
          <template slot-scope="row">
            <span>{{ $t('leads.action') }}</span>
            <sw-dropdown>
              <dot-icon slot="activator" />

              <sw-dropdown-item
                tag-name="router-link"
                :to="`leads/${row.id}/edit`"
              >
                <pencil-icon class="h-5 mr-3 text-gray-600" />
                {{ $t('general.edit') }}
              </sw-dropdown-item>

              <sw-dropdown-item
                tag-name="router-link"
                :to="`leads/${row.id}/view`"
              >
                <eye-icon class="h-5 mr-3 text-gray-600" />
                {{ $t('general.view') }}
              </sw-dropdown-item>

              <sw-dropdown-item @click="removeLead(row.id)">
                <trash-icon class="h-5 mr-3 text-gray-600" />
                {{ $t('general.delete') }}
              </sw-dropdown-item>
            </sw-dropdown>
          </template>
        </sw-table-column>

      </sw-table-component>

    </div>

  </base-page>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
import CapsuleIcon from '../../components/icon/CapsuleIcon.vue'
import {
  PlusIcon,
  PlusSmIcon,
  FilterIcon,
  XIcon,
  ChevronDownIcon,
  EyeIcon,
  PencilIcon,
  TrashIcon,
} from '@vue-hero-icons/solid'

export default {
  name: 'LeadsIndex',

  components: {
    CapsuleIcon,
    PlusIcon,
    PlusSmIcon,
    FilterIcon,
    XIcon,
    ChevronDownIcon,
    EyeIcon,
    PencilIcon,
    TrashIcon,
  },

  data: () => ({
    isRequestOngoing: true,
    showFilters: false,
    sortedBy: 'created_at',
    sortOrder: 'desc',
  }),

  computed: {
    ...mapGetters('leads', [
      'totalLeads',
    ]),

    showEmptyScreen() {
      return !this.totalLeads && !this.isRequestOngoing
    },
  },

  created () {},

  methods: {
    ...mapActions('leads', [
      'fetchLeads',
      'deleteLead',
    ]),

    async fetchData ({ page, filter, sort }) {
      let params = {
        page,
        orderByField: sort.fieldName || this.sortedBy,
        orderBy: sort.order || this.sortOrder,
      }

      this.isRequestOngoing = true
      let response = await this.fetchLeads(params)
      this.isRequestOngoing = false

      return {
        data: response.data.leads.data,
        pagination: {
          totalPages: response.data.leads.last_page,
          currentPage: page,
          count: response.data.leads.count,
        },
      }
    },

    removeLead (id) {
      swal({
        title: this.$t('general.are_you_sure'),
        text: this.$tc('leads.confirm_delete'),
        icon: '/assets/icon/trash-solid.svg',
        buttons: true,
        dangerMode: true,
      }).then(async (willDelete) => {
        if (willDelete) {
          let res = await this.deleteLead(id)

          if (res.data.success) {
            window.toastr['success'](this.$tc('leads.deleted_message', 1))
            this.$refs.table.refresh()
            return true
          }

          window.toastr['error'](res.data.message)
          return true
        }
      })
    }
  }
}
</script>

<style>

</style>