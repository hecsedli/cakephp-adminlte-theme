<?php
use Cake\Core\Configure;
use Cake\Utility\Inflector;

$prefix = '';
if(isset($this->request->params['prefix'])) $prefix = DS . Inflector::camelize($this->request->params['prefix']);

$file = Configure::read('Theme.folder') . DS . 'src' . DS . 'Template' . $prefix . DS . 'Element' . DS . 'footer.ctp';

if (file_exists($file)) {
    ob_start();
    include_once $file;
    echo ob_get_clean();
} else {
?>
<footer class="main-footer">
    <div class="pull-right hidden-xs">
        <b>Version</b> 2.3.11
    </div>
    <strong>Copyright &copy; 2014-2017 <a href="http://almsaeedstudio.com">Almsaeed Studio</a>.</strong> All rights
    reserved.
</footer>
<?php } ?>
