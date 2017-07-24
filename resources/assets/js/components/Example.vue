<template>
    <div class="example">
                <div class="panel panel-default">
                    <div class="panel-heading">Example Component</div>

                    <div class="panel-body">
                        I'm an  hhhh component!
                    </div>
                </div>
    </div>
</template>

<script>
    export default {
        data() {
          return {
              msg: 'xixi',
          }
        },
        props: [
            'a',
        ],
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
