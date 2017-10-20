
<script>
  $(function () {
    //Datemask mm/dd/yyyy
    $(".datepicker")
        .inputmask("yyyy-mm-dd", {"placeholder": "yyyy-mm-dd"})
        .datepicker({
            language:'en',
            format: 'yyyy-mm-dd'
        });
  });
</script>
