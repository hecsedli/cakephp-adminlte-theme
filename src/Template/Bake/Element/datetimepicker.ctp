
<script>
  $(function () {
    $(".datetimepicker")
       	.inputmask("datetime", {"inputFormat": "yyyy-mm-dd HH:MM"})
        .datetimepicker({
            locale:'en',
            format: 'YYYY-MM-DD HH:mm'
        });
  });
</script>
