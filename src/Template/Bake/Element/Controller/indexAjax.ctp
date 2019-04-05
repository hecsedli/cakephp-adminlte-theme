<%
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.1.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
%>

    /**
     * Ajax Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function indexAjax()
    {
<% $belongsTo = $this->Bake->aliasExtractor($modelObj, 'BelongsTo'); %>
<% if ($belongsTo): %>
        $this->paginate = [
            'contain' => [<%= $this->Bake->stringifyList($belongsTo, ['indent' => false]) %>]
        ];
<% endif; %>
		$filter = new FilterForm();
		$session = $this->getRequest()->getSession();
		$conditions = [];
		
		if ($this->request->is(['patch', 'post', 'put'])) {
	    	 $data = $this->request->getData();
			 $session->write("<%= $currentModelName %>Search.data", $this->request->getData());
	    } else if($session->check("<%= $currentModelName %>Search.data")) {
		    $data = $session->read("<%= $currentModelName %>Search.data");
			
	    }
	    
	    if (!empty($data['search'])) {
		    
		}
		
		$query = $this-><%= $currentModelName %>->find()->where($conditions);
		
		$<%= $pluralName %> = $this->paginate($query);

        $this->set(compact('<%= $pluralName %>', 'filter'));
        $this->set('_serialize', ['<%= $pluralName %>']);
    }
