<%
use Cake\Utility\Inflector;

   $extras = [];
   
   $fields = collection($fields)
    ->filter(function($field) use ($schema) {
        return $schema->getColumnType($field) !== 'binary';
    });

if (isset($modelObject) && $modelObject->hasBehavior('Tree')) {
    $fields = $fields->reject(function ($field) {
        return $field === 'lft' || $field === 'rght';
    });
}

$formFileType = '';
foreach ($fields as $field) {
	if(strpos($field, 'image') !== false || strpos($field, 'file') !== false) $formFileType = "'type' => 'file', ";	
}

%>
		
			
	

        <!-- form start -->
        <?= $this->Form->create($<%= $singularVar %>, [<%= $formFileType %>'role' => 'form', 'id' => '<%= $pluralVar %><%= Inflector::humanize($action) %>Form']) ?>
          <div class="box-body">
          <?php
<%
    foreach ($fields as $field) {
      if (in_array($field, $primaryKey)) {
        continue;
      }
      if (isset($keyFields[$field])) {
        $fieldData = $schema->getColumn($field);
        $extras['select2'] = 'select2';
        if (!empty($fieldData['null'])) {
%>
            echo $this->Form->control('<%= $field %>', ['class' => 'form-control select2', 'options' => $<%= $keyFields[$field] %>, 'empty' => true]);
<%
        } else {
%>
            echo $this->Form->control('<%= $field %>', ['class' => 'form-control select2', 'options' => $<%= $keyFields[$field] %>]);
<%
        }
        continue;
      }
      if (!in_array($field, ['created', 'modified', 'updated'])) {
        $fieldData = $schema->getColumn($field);
        if (($fieldData['type'] === 'date')) {
            $extras['datepicker'] = 'datepicker';
%>
            echo $this->Form->control('<%= $field %>', ['empty' => true, 'default' => '', 'class' => 'datepicker form-control', 'type' => 'text', 'templates' => ['input' => ' <div class="input-group date"><div class="input-group-addon"><i class="fa fa-calendar"></i></div><input type="{{type}}" name="{{name}}"{{attrs}}/></div>']]);
<%
        } else if (($fieldData['type'] === 'datetime')) {
            $extras['datepicker'] = 'datetimepicker';
%>
            echo $this->Form->control('<%= $field %>', ['empty' => true, 'default' => '', 'class' => 'datetimepicker form-control', 'type' => 'text', 'templates' => ['input' => ' <div class="input-group date"><div class="input-group-addon"><i class="fa fa-calendar"></i></div><input type="{{type}}" name="{{name}}"{{attrs}}/></div>']]);
<%
        } else if(strpos($field, 'image') !== false || strpos($field, 'file') !== false){
	        $extras['file'] = 'file';
%>
            
            
            echo $this->Form->control('<%= $field %>', [
            	'type' => 'file', 
            	'style' => 'display:none',
            	'nestedInput' => true,
            	'label' => [
	            	'class' => 'input-group-btn',
	            	'text' =>  __('Browse') . '&hellip; ',	 
	            	'escape' => false           	
            	],
            	'templates' => [
            		'inputContainer' => '<div class="form-group"><label>' . __('<%= Inflector::humanize($field) %>') . '</label><div class="input-group"><input type="text" class="form-control" readonly>{{content}}</div></div>', 
            		'inputContainerError' => '<div class="form-group"><label>' . __('<%= Inflector::humanize($field) %>') . '</label><div class="input-group"><input type="text" class="form-control" readonly>{{content}}</div>{{error}}</div>',
            		'nestingLabel' => '{{hidden}}<label{{attrs}}><span class="btn btn-primary">{{text}}{{input}}</span></label>',
            	],
            ]);
            
            
<%
	    } else {
%>
            echo $this->Form->control('<%= $field %>');
<%
        }
      }
    }
    if (!empty($associations['BelongsToMany'])) {
      foreach ($associations['BelongsToMany'] as $assocName => $assocData) {
%>
            echo $this->Form->control('<%= $assocData['property'] %>._ids', ['options' => $<%= $assocData['variable'] %>]);
<%
      }
    }
%>
          ?>
          </div>
          <!-- /.box-body -->
          <div class="box-footer">
	        <?= $this->Form->button(__('Cancel'), ['type' => 'reset', 'class' => 'btn btn-default']) ?> 
            <?= $this->Form->button(__('Save'), ['type' => 'submit', 'class' => 'btn btn-info pull-right']) ?>
          </div>
        <?= $this->Form->end() ?>
      

<%
    if (!empty($extras)) {
        foreach($extras as $element) {
        %>
        <% echo $this->element($element); %>
        <%
        }
    }
%>
