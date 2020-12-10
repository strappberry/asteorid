<template>
  <base-page>
    <form @submit.prevent="onSubmitForm">

      <sw-page-header class="mb-5" :title="pageTitle">
        <sw-breadcrumb slot="breadcrumbs">
          <sw-breadcrumb-item
            to="/admin/dashboard"
            :title="$t('general.home')"
          />
          <sw-breadcrumb-item
            to="/admin/loads"
            :title="$t('leads.title')"
          />
          <sw-breadcrumb-item
            v-if="$route.name === 'leads.edit'"
            to="#"
            :title="$t('leads.edit_lead')"
            active
          />
          <sw-breadcrumb-item
            v-else
            to="#"
            :title="$t('leads.new_lead')"
            active
          />
        </sw-breadcrumb>
        <template slot="actions">
          <sw-button
            :loading="isLoading"
            :disabled="isLoading"
            variant="primary"
            type="submit"
            size="lg"
            class="hidden md:relative md:flex"
          >
            <save-icon v-if="!isLoading" class="mr-2 -ml-1" />

            {{
              isEdit
                ? $t('leads.update_lead')
                : $t('leads.save_lead')
            }}
          </sw-button>
        </template>
      </sw-page-header>

      <sw-card>

        <div class="grid gap-6 grid-col-1 md:grid-cols-2">

          <!-- Input name -->
          <sw-input-group
            :label="$t('leads.name')"
            :error="leadNameError"
            required
          >
            <sw-input
              v-model="leadForm.name"
              :invalid="$v.leadForm.name.$error"
              @input="$v.leadForm.name.$touch()"
              class="mt-1"
            />
          </sw-input-group>

          <!-- Lead sources selecet -->
          <sw-input-group
            :label="$t('leads.source')"
            :error="leadSourceError"
            required
          >
            <sw-select
              v-model="leadSource"
              :options="leadSources"
              :searchable="true"
              :show-labels="false"
              :allow-empty="false"
              :placeholder="$t('leads.select_lead_source')"
              :invalid="$v.leadSource.$error"
              @input="$v.leadSource.$touch()"
              label="name"
              class="mt-1"
              track-by="id"
            />
          </sw-input-group>

          <!-- Input email -->
          <sw-input-group
            :label="$t('leads.email')"
            :error="leadEmailError"
            required
          >
            <sw-input
              v-model="leadForm.email"
              :invalid="$v.leadForm.email.$error"
              @input="$v.leadForm.email.$touch()"
              class="mt-1"
            />
          </sw-input-group>

          <!-- Input phone -->
          <sw-input-group
            :label="$t('leads.phone_number')"
          >
            <sw-input
              v-model="leadForm.phone"
              class="mt-1"
            />
          </sw-input-group>

          <!-- Input location -->
          <sw-input-group
            :label="$t('leads.location')"
          >
            <sw-input
              v-model="leadForm.location"
              class="mt-1"
            />
          </sw-input-group>

          <!-- Input interests -->
          <sw-input-group
            :label="$t('leads.interests')"
          >
            <sw-input
              v-model="leadForm.interests"
              class="mt-1"
            />
          </sw-input-group>

          <!-- Input language -->
          <sw-input-group
            :label="$t('leads.language')"
          >
            <sw-input
              v-model="leadForm.language"
              class="mt-1"
            />
          </sw-input-group>

          <!-- Input message -->
          <sw-input-group
            :label="$t('leads.message')"
          >
            <sw-input
              v-model="leadForm.message"
              class="mt-1"
            />
          </sw-input-group>

        </div>


        <div class="grid gap-6 grid-col-1 md:grid-cols-2"></div>
        
      </sw-card>

    </form>
  </base-page>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
import CustomFieldsMixin from '../../mixins/customFields'
import { required, email } from 'vuelidate/lib/validators'

export default {
  name: 'LeadsCreate',
  
  mixins: [CustomFieldsMixin],
  data: () => ({
    isLoading: false,
    leadForm: {
      name: '',
      email: '',
      phone: '',
      location: '',
      interests: '',
      message: '',
      language: '',
    },
    leadSource: null,
  }),

  validations: () => ({
    leadForm: {
      name: {
        required,
      },
      email: {
        required,
        email,
      }
    },
    leadSource: {
      required,
    }
  }),

  computed: {
    ...mapGetters('leads', [
      'leadSources',
    ]),

    isEdit() {
      if (this.$route.name === 'leads.edit') {
        return true
      }
      return false
    },

    pageTitle (){
      if (this.isEdit) {
        return this.$t('leads.edit_lead')
      }
      return this.$t('leads.new_lead')
    },

    leadNameError () {
      if (!this.$v.leadForm.name.$error) {
        return ''
      }
      if (!this.$v.leadForm.name.required) {
        return this.$tc('validation.required')
      }
    },

    leadEmailError () {
      if (!this.$v.leadForm.email.$error) {
        return ''
      }
      if (!this.$v.leadForm.email.required) {
        return this.$tc('validation.required')
      }
      if (!this.$v.leadForm.email.email) {
        return this.$tc('validation.email_incorrect')
      }
    },

    leadSourceError () {
      if (!this.$v.leadSource.$error) {
        return ''
      }
      if (!this.$v.leadSource.required) {
        return this.$tc('validation.required')
      }
    },
  },

  created () {
    this.loadData()
  },

  methods: {
    ...mapActions('leads', [
      'fetchLeadSources',
      'fetchLead',
      'addLead',
      'updateLead',
    ]),

    async loadData ()
    {
      this.isLoading = true
      if (this.isEdit) {
        let response = await this.fetchLead(this.$route.params.id)
        this.leadForm = {
          name: response.data.lead.name,
          email: response.data.lead.email,
          phone: response.data.lead.phone,
          location: response.data.lead.location,
          interests: response.data.lead.interests,
          message: response.data.lead.message,
          language: response.data.lead.language,
        }
        this.leadSource = response.data.lead.lead_source
      }

      await this.fetchLeadSources()
      this.isLoading = false
    },

    onSubmitForm ()
    {
      if (this.isEdit) {
        return this.saveUpdatedLead()
      }
      return this.saveNewLead()
    },
    
    saveNewLead ()
    {
      const data = {
        ...this.leadForm,
        lead_source_id: this.leadSource.id,
      }

      this.addLead(data)
        .then(response => {
          window.toastr['success'](this.$t('leads.created_message'))
          this.$router.push({
            name: 'leads.index',
          })
        })
        .catch(err => {
          window.toastr['error'](err.response.data.message)
        })
    },

    saveUpdatedLead ()
    {
      const data = {
        id: this.$route.params.id,
        form: {
          ...this.leadForm,
          lead_source_id: this.leadSource.id,
        }
      }

      this.updateLead(data)
        .then(response => {
          window.toastr['success'](this.$t('leads.updated_message'))
          this.$router.push({
            name: 'leads.index',
          })
        })
        .catch(err => {
          window.toastr['error'](err.response.data.message)
        })
    }
  }
}
</script>

<style>

</style>