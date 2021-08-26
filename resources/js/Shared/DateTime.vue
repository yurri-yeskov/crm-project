<template>
  <div><datetime type="datetime" v-model="defaultDate"  /></div>
</template>
<script>
export default {
    name: 'DateTime',
  data() {
    return {
      defaultDate: '2018-02-22T12:20:00.001Z'
    }
  },
  props: {

  }
}
</script>