<%
use Cake\Utility\Inflector;

$fields = collection($fields)
  ->filter(function($field) use ($schema) {
    return !in_array($schema->getColumnType($field), ['binary', 'text']);
  })
  ->take(7);
%>
<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title"><?= __('List of <%= $pluralHumanName %>') ?></h3>
        	<div class="box-tools">
	        	<?php echo $this->Form->create($filter, ['id' => '<%= $pluralVar %>SearchForm']); ?>
					<div class="input-group input-group-sm"  style="width: 180px;">
						<?php echo $this->Form->text('search', ['class' => 'form-control', 'placeholder' => __('Fill in to start search')]); ?>
						<span class="input-group-btn">
							<button class="btn btn-info btn-flat" type="submit"><?= __('Filter') ?></button>
						</span>
              		</div>
            	<?php echo $this->Form->end(); ?>
          	</div>
        </div>
        <!-- /.box-header -->
        <?php if(!empty(count($<%= $pluralVar %>))): ?>
        <div class="box-body table-responsive no-padding">
          <table class="table table-hover">
            <thead>
              <tr>
<%  foreach ($fields as $field):
if (!in_array($field, ['created', 'modified', 'updated'])) :%>
                <th><?= $this->Paginator->sort('<%= $field %>') ?></th>
<%  endif; %>
<%  endforeach; %>
                
              </tr>
            </thead>
            <tbody>
            <?php foreach ($<%= $pluralVar %> as $<%= $singularVar %>): ?>
              <tr data-id="<?php echo $<%= $singularVar %>->id; ?>" class="nav-item" style="cursor:pointer">
<%  foreach ($fields as $field) {
    if (!in_array($field, ['created', 'modified', 'updated'])) {
    $isKey = false;
    if (!empty($associations['BelongsTo'])) {
    foreach ($associations['BelongsTo'] as $alias => $details) {
      if ($field === $details['foreignKey']) {
        $isKey = true;
%>
                <td><?= $<%= $singularVar %>->has('<%= $details['property'] %>') ? $this->Html->link($<%= $singularVar %>-><%= $details['property'] %>-><%= $details['displayField'] %>, ['controller' => '<%= $details['controller'] %>', 'action' => 'view', $<%= $singularVar %>-><%= $details['property'] %>-><%= $details['primaryKey'][0] %>]) : '' ?></td>
<%
          break;
        }
      }
    }

    if ($isKey !== true) {
      if (!in_array($schema->getColumnType($field), ['integer', 'biginteger', 'decimal', 'float'])) {
%>
                <td><?= h($<%= $singularVar %>-><%= $field %>) ?></td>
<%
      } else {
%>
                <td><?= $this->Number->format($<%= $singularVar %>-><%= $field %>) ?></td>
<%
      }
    }
    }
  }
  $pk = '$' . $singularVar . '->' . $primaryKey[0];
%>
                
              </tr>
            <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <?php else: ?>
        <div class="box-body">
	        <div class="alert alert-warning"><?php echo __('No results') ?></div>
        </div>
        <?php endif; ?>
        <!-- /.box-body -->
    <div class="box-footer clearfix">
        <ul class="pagination pagination-sm no-margin pull-right">
           <?php echo $this->Paginator->numbers(); ?>
        </ul>
	</div>
	<div class="overlay" style="display:none">
        <i class="fa fa-refresh fa-spin"></i>
    </div>
</div>

<script type="text/javascript">
	
	$(function () {
		$(".nav-item").on("click", function(){
			var id = $(this).data("id");
			$('.overlay').show();
			$.ajax({
				url: "<?php echo $this->Url->build(array("controller" => "<%= $pluralVar %>", "action" => "edit"), true) ?>/"+id+"?" + (new Date().getTime()),
				cache: false
			})
			.done(function( html ) {
				$('#<%= $singularVar %>-1').html( html );
				$('.overlay').hide();
  			});
		
		});
		$('.pagination a, th a').click(function(e){
			e.preventDefault();
			var url = $(this).attr("href");
			$('.overlay').show();
			$.ajax({
				url: url,
				cache: false
			})
			.done(function( html ) {
				$('#<%= $singularVar %>-2').html( html );
				$('.overlay').hide();
  			});
		});
		$('#<%= $pluralVar %>SearchForm').ajaxForm({
			replaceTarget: false,
			target: '#<%= $singularVar %>-2',
			beforeSubmit: function(arr, $form, options) {
				$('.overlay').show();
			},	
			success: function (response) {
				$('.overlay').hide();
			},
			error: function(jqXHR, textStatus, errorThrown) {
				$('.overlay').hide();
				alert(errorThrown);
	  		}
		});
	});
</script>
