<template>
  <div>
      =) =) =)<br/>
      -> {{messages}}<br/>
      <textarea id="" cols="30" rows="10">{{messages.join('\n')}}</textarea>
  </div>
</template>

<script>

export default {
  data () {
    return {
      messages: []
    }
  },
    mounted() {
      console.log('mounted')
        window.Echo.channel('chat')
            .listen('Message', ({message}) => {
                this.messages.push(message)
            })
    }
}
</script>
