<template>
  <Head title="Zoho CRM Form" />
  <div class="max-w-xl mx-auto mt-10 bg-white p-6 rounded-lg shadow">
    <h2 class="text-2xl font-bold mb-6 text-center">Create Zoho CRM Deal & Account</h2>

    <form @submit.prevent="submit" class="space-y-4">
       <!-- Deal Information -->
      <div>
        <label for="deal_name" class="block text-sm font-medium text-gray-700">Deal Name</label>
        <input
          id="deal_name"
          v-model="form.deal_name"
          type="text"
          required
          class="input-field"
        />
      </div>
      <div>
        <label for="stage" class="block text-sm font-medium text-gray-700">Deal Stage</label>
        <select
          id="stage"
          v-model="form.stage"
          required
          class="input-field"
        >
          <option value="" disabled>Select stage</option>
          <option value="Qualification">Qualification</option>
          <option value="Needs Analysis">Needs Analysis</option>
          <option value="Proposal">Proposal</option>
          <option value="Negotiation">Negotiation</option>
          <option value="Closed Won">Closed Won</option>
          <option value="Closed Lost">Closed Lost</option>
        </select>
      </div>
      <!-- Account Information -->
      <div>
        <label for="account_name" class="block text-sm font-medium text-gray-700">Account Name</label>
        <input
          id="account_name"
          v-model="form.account_name"
          type="text"
          required
          class="input-field"
        />
      </div>

      <div>
        <label for="account_website" class="block text-sm font-medium text-gray-700">Account Website</label>
        <input
          id="account_website"
          v-model="form.account_website"
          type="url"
          class="input-field"
        />
      </div>

      <div>
        <label for="account_phone" class="block text-sm font-medium text-gray-700">Account Phone</label>
        <input
          id="account_phone"
          v-model="form.account_phone"
          type="tel"
          class="input-field"
        />
      </div>

      <div>
        <button
          type="submit"
          class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 transition"
          :disabled="form.processing"
        >
          {{ form.processing ? 'Submitting...' : 'Create Deal & Account' }}
        </button>
      </div>
    </form>

    <p v-if="message" class="mt-4 text-center text-green-600">{{ message }}</p>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { Head } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3'

const message = ref('')

// Initialize the form with required fields for Account and Deal creation
const form = useForm({
  account_name: '',
  account_phone: '',
  account_website: '',
  deal_name: '', 
  stage: '',  
})


const submit = () => {
  form.post('/zoho-form', {
    onSuccess: () => {
      message.value = 'Record created successfully.'
      form.reset()
    },
    onError: () => {
      message.value = 'Submission failed. Please check input.'
    }
  })
}
</script>

<style scoped>
.input-field {
  @apply mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500;
}
</style>
