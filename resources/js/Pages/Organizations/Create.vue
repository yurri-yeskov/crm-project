<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('organizations')">Organizations</inertia-link>
      <span class="text-indigo-400 font-medium">/</span> Create
    </h1>
    <div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
      <form @submit.prevent="store">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
          <div class="pr-6 pb-8 w-full lg:w-1/2">
            <label class="form-label" :for="id">{{ "Date" }}:</label>
            <input type="date" class="form-input" v-model="form.date" />
          </div>
          <text-input v-model="form.status" :error="form.errors.status" class="pr-6 pb-8 w-full lg:w-1/2" label="Status" />
          <text-input v-model="form.contact" :error="form.errors.contact" class="pr-6 pb-8 w-full lg:w-1/2" label="Contact" />
          <text-input v-model="form.company" :error="form.errors.company" class="pr-6 pb-8 w-full lg:w-1/2" label="Company" />
          <text-input v-model="form.town" :error="form.errors.town" class="pr-6 pb-8 w-full lg:w-1/2" label="Town" />
          <text-input v-model="form.area" :error="form.errors.area" class="pr-6 pb-8 w-full lg:w-1/2" label="Area" />
          <text-input v-model="form.tel" :error="form.errors.tel" class="pr-6 pb-8 w-full lg:w-1/2" label="Tel" />
          <text-input v-model="form.mobile" :error="form.errors.mobile" class="pr-6 pb-8 w-full lg:w-1/2" label="Mobile" />
          <text-input v-model="form.email" :error="form.errors.email" class="pr-6 pb-8 w-full lg:w-1/2" label="Email" />
          <text-input v-model="form.web" :error="form.errors.web" class="pr-6 pb-8 w-full lg:w-1/2" label="Web" />          
          <text-input v-model="form.brands" :error="form.errors.brands" class="pr-6 pb-8 w-full lg:w-1/2" label="Brands" />
          <text-input v-model="form.comments" :error="form.errors.comments" class="pr-6 pb-8 w-full lg:w-1/2" label="Comments" />
        </div>
        <div class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex justify-end items-center">
          <loading-button :loading="form.processing" class="btn-indigo" type="submit">Create Organization</loading-button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import Layout from '@/Shared/Layout'
import TextInput from '@/Shared/TextInput'
import SelectInput from '@/Shared/SelectInput'
import LoadingButton from '@/Shared/LoadingButton'
import { Datetime } from 'vue-datetime';

export default {
  metaInfo: { title: 'Create Organization' },
  components: {
    LoadingButton,
    SelectInput,
    TextInput,
    datetime: Datetime
  },
  layout: Layout,
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        date: null,
        status: null,
        contact: null,
        company: null,
        town: null,
        area: null,
        tel: null,
        mobile: null,
        email: null,
        web: null,
        brands: null,
        comments: null,
      }),
    }
  },
  methods: {
    store() {
      this.form.post(this.route('organizations.store'))
    },
  },
}
</script>
