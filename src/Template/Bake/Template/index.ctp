<%
$datepicker = false;
$select2 = false;

 $fields = collection($fields)
    ->filter(function($field) use ($schema) {
        return $schema->columnType($field) !== 'binary';
    });
    
   
foreach ($fields as $field) {
	if (!in_array($field, ['created', 'modified', 'updated'])) {
		$fieldData = $schema->column($field);
        if (($fieldData['type'] === 'date')) $datepicker = true;
	}
	
	if (isset($keyFields[$field])) {
		$select2 = true;
	}
}
%>
<?php
/**
 * @var \<%= $namespace %>\View\AppView $this
 * @var \<%= $entityClass %>[]|\Cake\Collection\CollectionInterface $<%= $pluralVar %>
 */
?>

<section class="content-header">
	<h1><?php echo __('<%= $pluralHumanName %>') ?></h1>
  	<ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i><?php echo __('Home') ?></a></li>
        <li class="active"><?php echo __('<%= $pluralHumanName %>') ?></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-md-6 ajax-box" id="<%= $singularVar %>-1" data-url="<?php echo $this->Url->build(['action' => 'add']); ?>">
			
		</div>
		
		<div class="col-md-6 ajax-box" id="<%= $singularVar %>-2" data-url="<?php echo $this->Url->build(['action' => 'indexAjax']); ?>">
			
		</div>
		
	</div>
</section>

<%
if($datepicker === true):
%>
<?php
$this->Html->css([
    'AdminLTE./plugins/datepicker/datepicker3',
  ],
  ['block' => 'css']);

$this->Html->script([
  'AdminLTE./plugins/input-mask/jquery.inputmask',
  'AdminLTE./plugins/input-mask/jquery.inputmask.date.extensions',
  'AdminLTE./plugins/datepicker/bootstrap-datepicker',
  'AdminLTE./plugins/datepicker/locales/bootstrap-datepicker.pt-BR',
],
['block' => 'script']);
?>
<%
endif;
%>

<%
if($select2 === true):
%>
<?php
$this->Html->css([
    'AdminLTE./plugins/select2/select2.min',
  ],
  ['block' => 'css']);

$this->Html->script([
  'AdminLTE./plugins/select2/select2.full.min',
],
['block' => 'script']);
?>
<%
endif;
%>




<?php $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js',['block' => 'script']); ?>

<?php $this->start('scriptBottom'); ?>


<script type="text/javascript">
$(function(){
	$('.ajax-box').each(function(){
		var _this = $(this);
		
		$.ajax({
			url: _this.data('url'),
			cache: false
		})
		.done(function( html ) {
			_this.html( html );
  		});
	});
});
</script>
<?php $this->end(); ?>