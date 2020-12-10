import { reject } from 'lodash'
import * as types from './mutation-types'

export const fetchLeads = ({ commit }, params) => {
  return new Promise((resolve, reject) => {
    window.axios
      .get(`/api/v1/leads`, { params })
      .then(response => {
        commit(types.SET_LEADS, response.data.leads.data)
        commit(types.SET_TOTAL_LEADS, response.data.leads.total)
        resolve(response)
      })
      .catch(reject)
  })
}

export const fetchLead = (store, leadId) => {
  return new Promise((resolve, reject) => {
    window.axios
      .get(`/api/v1/leads/${leadId}`)
      .then(resolve)
      .catch(reject)
  })
}

export const fetchLeadSources = ({ commit }, data) => {
  return new Promise((resolve, reject) => {
    window.axios
    .get(`/api/v1/lead-sources`)
    .then(response => {
      commit(types.SET_LEAD_SOURCES, response.data.lead_sources)
      resolve(response)
    })
    .catch(reject)
  })
}

export const addLead = ({ commit }, data) => {
  return new Promise((resolve, reject) => {
    window.axios
      .post(`/api/v1/leads`, data)
      .then(response => {
        commit(types.ADD_LEAD, response.data.lead)
        resolve(response)
      })
      .catch(reject)
  })
}

export const updateLead = ({ commit }, data) => {
  return new Promise((resolve, reject) => {
    window.axios
      .put(`/api/v1/leads/${data.id}`, data.form)
      .then(response => {
        commit(types.UPDATE_LEAD, response.data.lead)
        resolve(response)
      })
      .catch(reject)
  })
}

export const deleteLead = ({ commit }, leadId) => {
  return new Promise((resolve, reject) => {
    window.axios
      .delete(`/api/v1/leads/${leadId}`)
      .then(response => {
        commit(types.DELETE_LEAD, leadId)
        resolve(response)
      })
      .catch(reject)
  })
}