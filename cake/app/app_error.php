<?php 

  class AppError extends ErrorHandler {
    function error404($params) {
      $this->controller->redirect(array('controller'=>'pages', 'action'=>'404'));
      parent::error404($params);
    }
  }

?>
