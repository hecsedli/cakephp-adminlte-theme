<?php

namespace AdminLTE\Shell;

use Cake\Console\Shell;
use Cake\Datasource\ConnectionManager;
use Cake\Utility\Inflector;
use Cake\Core\Configure;
use Cake\Core\App;

/**
 * Menu generation utility for AdminLTE sidebar menu from database table names.
 *
 * Usage: bin/cake menu_generator
 *
 */

class MenuGeneratorShell extends Shell {
	
	public $connection = 'default';
	
    public function main() {
	    $connections = ConnectionManager::configured();
	    
        if (empty($connections)) {
            $this->out('Your database configuration was not found.');
            $this->out('Add your database connection information to config/app.php.');

            return false;
        }
        
        $db = ConnectionManager::get($this->connection);
        
        $prefix = '';
        
        $this->out(sprintf('<warning>Would you like to create a menu for prefix routing?</warning>'));
        $selection = $this->in('Enter prefix (eg: Admin) or n?', [], 'n');
        
        if(strtolower($selection) != 'n'){
	        $prefix = Inflector::camelize($selection);
	        $file = ROOT . DS . 'src' . DS . 'Template' . DS . $prefix . DS . 'Element' . DS . 'aside' . DS . 'sidebar-menu.ctp';
	    }else{
		    $file = ROOT . DS . 'src' . DS . 'Template' . DS . 'Element' . DS . 'aside' . DS . 'sidebar-menu.ctp'; 
	    }

		// Create a schema collection.
		$collection = $db->schemaCollection();

		// Get the table names
		$tables = $collection->listTables();
		
		$menuHtml = '<ul class="sidebar-menu" data-widget="tree">
	<li class="header"><?php echo __(\'MAIN NAVIGATION\');?></li>
	<li>
    	<a href="<?php echo $this->Url->build([\'controller\' => \'Pages\', \'action\' => \'dashboard\']); ?>">
        	<i class="fa fa-dashboard"></i> <span>Dashboard</span>
		</a>
	</li>';
	
		if ($prefix) $prefix .= '/';
     
		foreach($tables as $table){
			if (in_array($table, ['acos', 'aros', 'aros_acos'])) continue;
			$controller = Inflector::camelize($table);
			$controllerClass = App::className($prefix . $controller, 'Controller', 'Controller');
			
			if (!class_exists($controllerClass))  continue;
			$menuHtml .= '
	<li>
    	<a href="<?php echo $this->Url->build([\'controller\' => \'' . Inflector::camelize($table) . '\', \'action\' => \'index\']); ?>">
        	<i class="fa fa-table"></i> <span>'. Inflector::camelize($table) . '</span>
		</a>
	</li>';
			
		}
        
        $menuHtml .= '
</ul>';
        	
        
		
        $this->createFile($file, $menuHtml);
    }
}