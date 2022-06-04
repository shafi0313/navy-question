<script>
    $('.digitOnly').on('input',function(){
        return this.value = this.value.replace(/[^\d]/g,'')
    })
</script>
