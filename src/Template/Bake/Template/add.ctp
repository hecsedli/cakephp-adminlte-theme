<%
use Cake\Utility\Inflector;
%>
<div class="box box-success">
    <div class="box-header">
    	<h3 class="box-title"><?php echo __('<%= $singularHumanName %>') ?> <?= __('<%= Inflector::humanize($action) %>') ?></h3>
    </div>
    <?php echo $this->Flash->render(); ?>
    <% echo $this->element('form'); %>
    <div class="overlay" style="display:none">
        <i class="fa fa-refresh fa-spin"></i>
    </div>
</div>

<script type="text/javascript">
$(function () {
	
	$('#<%= $pluralVar %><%= Inflector::humanize($action) %>Form').ajaxForm({
		replaceTarget: false,
		target: '#<%= $singularVar %>-1',
		beforeSubmit: function(arr, $form, options) {
			$('.overlay').show();
		},
		success: function (response) {
			$.ajax({
				url: "<?php echo $this->Url->build(["controller" => "<%= $pluralVar %>", "action" => "indexAjax"], true) ?>",
				cache: false
			})
			.done(function( html ) {
				$('#<%= $singularVar %>-2').html( html );
				$('.overlay').hide();
  			});
		},
		error: function(jqXHR, textStatus, errorThrown) {
			$('.overlay').hide();
	  		alert(errorThrown);
	  	}
	});

});
</script>
