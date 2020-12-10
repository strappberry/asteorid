import * as types from './mutation-types'

export default {
  [types.SET_TOTAL_LEADS] (state, total) {
    state.totalLeads = total
  },

  [types.SET_LEADS] (state, leads) {
    state.leads = leads
  },

  [types.SET_LEAD_SOURCES] (state, leadSources) {
    state.leadSources = leadSources
  },

  [types.ADD_LEAD] (state, lead) {
    state.leads.push(lead)
  },

  [types.UPDATE_LEAD] (state, lead) {
    let pos = state.leads.findIndex((leadItem) => leadItem.id === lead.id)

    state.leads[pos] = lead
  },

  [types.DELETE_LEAD] (state, leadId) {
    let index = state.leads.findIndex((lead) => lead.id === leadId)
    state.leads.splice(index, 1)
  },

}