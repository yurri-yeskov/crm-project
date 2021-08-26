<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('organizations')">Organizations</inertia-link>
      <span class="text-indigo-400 font-medium">/</span>
      {{ form.name }}
    </h1>
    <trashed-message v-if="organization.deleted_at" class="mb-6" @restore="restore">
      This organization has been deleted.
    </trashed-message>
    <div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
      <form @submit.prevent="update">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
          <text-input v-model="form.date" :error="form.errors.date" class="pr-6 pb-8 w-full lg:w-1/2" label="Date" />
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
        <div class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex items-center">
          <button v-if="!organization.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Delete Organization</button>
          <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Update Organization</loading-button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import Icon from '@/Shared/Icon'
import Layout from '@/Shared/Layout'
import TextInput from '@/Shared/TextInput'
import SelectInput from '@/Shared/SelectInput'
import LoadingButton from '@/Shared/LoadingButton'
import TrashedMessage from '@/Shared/TrashedMessage'

export default {
  metaInfo() {
    return { title: this.form.name }
  },
  components: {
    Icon,
    LoadingButton,
    SelectInput,
    TextInput,
    TrashedMessage,
  },
  layout: Layout,
  props: {
    organization: Object,
  },
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        id: this.organization.id,
        date: this.organization.date,
        status: this.organization.status,
        contact: this.organization.contact,
        company: this.organization.company,
        town: this.organization.town,
        area: this.organization.area,
        tel: this.organization.tel,
        mobile: this.organization.mobile,
        email: this.organization.email,
        web: this.organization.web,
        brands: this.organization.brands,
        comments: this.organization.comments,
      }),
    }
  },
  methods: {
    update() {
      this.form.put(this.route('organizations.update', this.organization.id))
    },
    destroy() {
      if (confirm('Are you sure you want to delete this organization?' + this.organization.id)) {        
        this.$inertia.delete(this.route('organizations.destroy', this.organization.id))
      }
    },
    restore() {
      if (confirm('Are you sure you want to restore this organization?')) {
        this.$inertia.put(this.route('organizations.restore', this.organization.id))
      }
    },
  },
}
</script>
