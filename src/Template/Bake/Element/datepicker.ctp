
<script>
  $(function () {
    //Datemask mm/dd/yyyy
    $(".datepicker")
        .inputmask("datetime", {"inputFormat": "yyyy-mm-dd"})
        .datepicker({
            language:'en',
            format: 'yyyy-mm-dd'
        });
  });
</script>
